<?php

namespace Crypto\Processors;

use Crypto\Exceptions\KeyGenerationException;
use Crypto\Exceptions\MessageAuthenticationException;
use Crypto\Exceptions\MessageDecryptionException;
use Crypto\Factory\MessageFactory;
use Crypto\Messages\MessageBox;

/**
 * Class Processor
 * @package Crypto\Processors
 */
class Processor
{
    private const ZERO = 0;
    private const ENCODING = '8bit';
    
    /**
     * @param string $message
     * @param string $key
     *
     * @return MessageBox
     * @throws KeyGenerationException
     */
    public function encrypt(string $message, string $key): MessageBox
    {
        $nonce = $this->getRandomBytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $ciphertext = $this->encryptWithSodium($key, $nonce, $message);
        
        $this->clear($message);
        $mac = $this->authenticate($nonce . $ciphertext, $key);
        $this->clear($key);
    
        $encoded = $this->encodeWithBase64($mac . $nonce . $ciphertext);
        
        return MessageFactory::create($encoded);
    }
    
    /**
     * @param string $message
     * @param string $key
     *
     * @return string
     * @throws MessageAuthenticationException
     * @throws MessageDecryptionException
     * @throw SodiumException
     */
    public function decrypt(string $message, string $key): string
    {
        $decoded = $this->decodeWithBase64($message);
        
        $nonce = $this->getNonce($decoded);
        $ciphertext = $this->getCipherText($decoded);
        $mac = $this->getMac($decoded);
        if ($this->verify($mac, $nonce . $ciphertext, $key)) {
            $text = $this->decryptWithSodium($ciphertext, $nonce, $key);
            if ($text === false) {
                throw new MessageDecryptionException('Message cannot be decrypt!');
            }
            
            return $text;
        }
        
        throw new MessageAuthenticationException('Message authentication is broken!');
    }
    
    /**
     * Clear memory
     * @param string $text
     */
    private function clear(string $text): void
    {
        sodium_memzero($text);
    }
    
    /**
     * Extract Message Authentication Code from crypted string
     *
     * @param string $cipher
     *
     * @return string
     */
    private function getMac(string $cipher): string
    {
        return mb_substr(
            $cipher,
            self::ZERO,
            SODIUM_CRYPTO_AUTH_BYTES,
            self::ENCODING
        );
    }
    
    /**
     * @param string $cipher
     *
     * @return string
     */
    private function getNonce(string $cipher): string
    {
        return mb_substr(
            $cipher,
            SODIUM_CRYPTO_AUTH_BYTES,
            SODIUM_CRYPTO_STREAM_NONCEBYTES,
            self::ENCODING
        );
    }
    
    /**
     * @param string $cipher
     *
     * @return string
     */
    private function getCipherText(string $cipher): string
    {
        return mb_substr(
            $cipher,
            SODIUM_CRYPTO_AUTH_BYTES + SODIUM_CRYPTO_STREAM_NONCEBYTES,
            null,
            self::ENCODING
        );
    }
    
    /**
     * @param string $message
     * @param string $key
     *
     * @return string
     */
    private function authenticate(string $message, string $key): string
    {
        return sodium_crypto_auth($message, $key);
    }
    
    /**
     * @param string $mac
     * @param string $message
     * @param string $key
     *
     * @return bool
     * @throw SodiumException
     */
    private function verify(string $mac, string $message, string $key): bool
    {
        return sodium_crypto_auth_verify($mac, $message, $key);
    }
    
    /**
     * @param string $key
     * @param string $nonce
     * @param string $message
     *
     * @return string
     */
    private function encryptWithSodium(
        string $key,
        string $nonce,
        string $message
    ): string {
        return sodium_crypto_secretbox($message, $nonce, $key);
    }
    
    /**
     * @param string $message
     * @param string $nonce
     * @param string $key
     *
     * @return string|bool
     */
    private function decryptWithSodium(string $message, string $nonce, string $key)
    {
        return sodium_crypto_secretbox_open($message, $nonce, $key);
    }
    
    /**
     * @param string $message
     *
     * @return string
     */
    private function encodeWithBase64(string $message): string
    {
        return base64_encode($message);
    }
    
    /**
     * @param string $message
     *
     * @return string
     */
    private function decodeWithBase64(string $message): string
    {
        return base64_decode($message);
    }
    
    /**
     * @param int $key
     *
     * @return null|string
     * @throws KeyGenerationException
     */
    private function getRandomBytes(int $key): ?string
    {
        try {
            return random_bytes($key);
        } catch (\Throwable $e) {
            $message = 'Random bytes generation failed! Error is: ' . $e->getMessage();
            throw new KeyGenerationException($message);
        }
    }
}