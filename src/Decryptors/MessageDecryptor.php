<?php

namespace Crypto\Decryptors;

use Crypto\Exceptions\MessageAuthenticationException;
use Crypto\exceptions\MessageDecryptionException;
use Crypto\Processors\Processor;
use Crypto\Resources\MessageResource;

/**
 * Class MessageDecryptor
 * @package Crypto\Decryptors
 */
class MessageDecryptor
{
    /**
     * @var Processor
     */
    private $processor;
    
    /**
     * MessageDecryptor constructor.
     *
     * @param Processor $processor
     */
    public function __construct(Processor $processor)
    {
        $this->processor = $processor;
    }
    
    /**
     * @param MessageResource $resource
     *
     * @return string
     * @throws MessageDecryptionException
     */
    public function decrypt(MessageResource $resource): string
    {
        try {
            return $this->processor->decrypt($resource->getMessage(), $resource->getKey());
        } catch (\SodiumException | MessageAuthenticationException | MessageDecryptionException $e) {
            throw new MessageDecryptionException($e->getMessage());
        }
    }
}