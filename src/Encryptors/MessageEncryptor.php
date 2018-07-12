<?php

namespace Crypto\Encryptors;

use Crypto\Exceptions\KeyGenerationException;
use Crypto\Exceptions\MessageEncryptionException;
use Crypto\Messages\MessageBox;
use Crypto\Processors\Processor;
use Crypto\Resources\MessageResource;

/**
 * Class MessageEncryptor
 * @package Crypto\Encryptors
 */
class MessageEncryptor
{
    /**
     * @var Processor
     */
    private $processor;
    
    /**
     * MessageEncryptor constructor.
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
     * @return \Crypto\Messages\MessageBox
     * @throws MessageEncryptionException
     */
    public function encrypt(MessageResource $resource): ?MessageBox
    {
        try {
            return $this->processor->encrypt($resource->getMessage(),
                $resource->getKey());
        } catch (KeyGenerationException $e) {
            throw new MessageEncryptionException($e->getMessage());
        }
    }
}