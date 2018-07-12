<?php

namespace Crypto\Resources;

/**
 * Class MessageResource
 * @package Crypto\Resources
 */
class MessageResource
{
    /**
     * @var string
     */
    private $key;
    /**
     * @var string
     */
    private $message;
    
    /**
     * MessageResource constructor.
     *
     * @param string $key
     * @param string $message
     */
    public function __construct(string $key, string $message)
    {
        $this->key = $key;
        $this->message = $message;
    }
    
    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
    
    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}