<?php

namespace CryptoTest\unit\Decryptors;

use Crypto\Decryptors\MessageDecryptor;
use Crypto\Exceptions\DecryptionException;
use Crypto\Processors\Processor;
use Crypto\Resources\MessageResource;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageDecryptorTest
 * @package CryptoTest\unit\Decryptors
 */
class MessageDecryptorTest extends TestCase
{
    private const MESSAGE = '8cfp/NJBL++uRStTdfuigfx6107xx7Z8qNl/b0W6ZxAWRE+mHb6Qpz48wzN43Xoxq4yCALaHAI09aHGycuNDJcrDvdeWRllT4UQ8jBPZyA==';
    private const KEY = 'bdd3d02607f26b1f2feb8571a4e25b5e5e9435da9a1a20c29c73baf4a1c80298';
    /**
     * @var MessageDecryptor
     */
    private $decryptor;
    
    public function setUp()
    {
        parent::setUp();
        
        $processor = new Processor();
        $this->decryptor = new MessageDecryptor($processor);
    }
    
    public function testMustBeInstanceOfMessageDecryptor()
    {
        $this->assertInstanceOf(MessageDecryptor::class, $this->decryptor);
    }
    
    public function testMustDecryptMessage()
    {
        try {
            $resource = new MessageResource($this->getKey(), self::MESSAGE);
            $message = $this->decryptor->decrypt($resource);
            $this->assertEquals('message', $message);
        } catch (DecryptionException $e) {
        }
    }
    
    /**
     * @expectedException \Crypto\exceptions\DecryptionException
     * @expectedExceptionMessage key must be SODIUM_CRYPTO_AUTH_KEYBYTES bytes
     */
    public function testMustThrowDecryptionException()
    {
        $processor = new Processor();
        $resource = new MessageResource(self::KEY, self::MESSAGE);
        $this->decryptor = new MessageDecryptor($processor);
        $this->decryptor->decrypt($resource);
    }
    
    /**
     * @return string
     */
    private function getKey(): string
    {
        return hex2bin(self::KEY);
    }
}
