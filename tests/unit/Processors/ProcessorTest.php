<?php

namespace CryptoTest\unit\Processor;

use Crypto\Processors\Processor;
use Crypto\Messages\MessageBox;
use PHPUnit\Framework\TestCase;

/**
 * Class ProcessorTest
 * @package CryptoTest\unit\Processor
 */
class ProcessorTest extends TestCase
{
    /**
     * @var Processor
     */
    private $processor;
    
    public function setUp()
    {
        parent::setUp();
        $this->processor = new Processor();
    }
    
    public function testMustBeInstanceOfCrypto()
    {
        $this->assertInstanceOf(Processor::class, $this->processor);
    }
    
    public function testEncryptionWillReturnMessageBoxObject()
    {
        $message = 'texttexttexttext';
        
        $encryption = $this->processor->encrypt($message, $this->getKey());
        
        $this->assertInstanceOf(MessageBox::class, $encryption);
    }
    
    public function testMustAssureThatMessageWithTheSameTextHaveDifferentEncryptionValue()
    {
        $message = 'texttexttexttext';
        $encryption1 = $this->processor->encrypt($message, $this->getKey());
        
        $encryption2 = $this->processor->encrypt($message, $this->getKey());
        
        $this->assertNotEquals($encryption1->getMessage(), $encryption2->getMessage());
    }
    
    public function testMustDecryptMessage()
    {
        $message = 'texttexttexttext';
        $key = $this->getKey();
        $box = $this->processor->encrypt($message, $key);
        
        $message2 = $this->processor->decrypt($box->getMessage(), $key);
        
        $this->assertEquals($message, $message2);
    }
    
    /**
     * @expectedException \Crypto\exceptions\MessageAuthenticationException
     * @expectedExceptionMessage Message authentication is broken!
     */
    public function testMustThrowExceptionWhenMessageIsCompromised()
    {
        $message = 'text';
        $key = $this->getKey();
        $box = $this->processor->encrypt($message, $key);
        
        $message = $box->getMessage() . '\x00';
        $message2 = $this->processor->decrypt($message, $key);
    }
    
    /**
     * @return string
     */
    private function getKey(): string
    {
        try {
            return random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
        } catch (\Exception $e) {
            return str_repeat("\x80", 32);
        }
    }
}
