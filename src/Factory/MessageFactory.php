<?php

namespace Crypto\Factory;

use Crypto\Messages\MessageBox;

/**
 * Class MessageFactory
 * @package Crypto\Factory
 */
class MessageFactory
{
    /**
     * @param string $message
     *
     * @return MessageBox
     */
    public static function create(string $message): MessageBox
    {
        return new MessageBox($message);
    }
}