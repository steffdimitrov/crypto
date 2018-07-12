<?php

namespace Crypto\Messages;

/**
 * Class MessageBox
 * @package Crypto\Messages
 */
class MessageBox
{
    /**
     * @var
     */
    private $message;
    
    /**
     * MessageBox constructor.
     *
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }
    
    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
}