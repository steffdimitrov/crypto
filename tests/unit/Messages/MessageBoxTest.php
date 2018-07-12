<?php

namespace CryptoTest\unit\Messages;

use Crypto\Messages\MessageBox;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageBoxTest
 * @package CryptoTest\unit\Messages
 */
class MessageBoxTest extends TestCase
{
    private const MESSAGE = 'message';
    /**
     * @var MessageBox
     */
    private $message;
    
    public function setUp()
    {
        parent::setUp();
        $this->message = new MessageBox(self::MESSAGE);
    }
    
    public function testMustBeInstanceOfMessageBox()
    {
        $this->assertInstanceOf(MessageBox::class, $this->message);
    }
    
    public function testMustGetMessage()
    {
        $this->assertEquals(self::MESSAGE, $this->message->getMessage());
    }
}
