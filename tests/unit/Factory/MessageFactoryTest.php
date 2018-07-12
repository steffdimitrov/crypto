<?php

namespace CryptoTest\unit\Factory;

use Crypto\Factory\MessageFactory;
use Crypto\Messages\MessageBox;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageFactoryTest
 * @package CryptoTest\unit\Factory
 */
class MessageFactoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testMustReturnMessageBoxInstance()
    {
        $message = MessageFactory::create('message');
        
        $this->assertInstanceOf(MessageBox::class, $message);
    }
}
