<?php

namespace CryptoTest\unit\Encryptors;

use Crypto\Encryptors\MessageEncryptor;
use Crypto\Exceptions\EncryptionException;
use Crypto\Messages\MessageBox;
use Crypto\Processors\Processor;
use Crypto\Resources\MessageResource;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageEncryptorTest
 * @package CryptoTest\unit\Encryptors
 */
class MessageEncryptorTest extends TestCase
{
    private const MESSAGE = 'message';
    private const KEY = 'bdd3d02607f26b1f2feb8571a4e25b5e5e9435da9a1a20c29c73baf4a1c80298';
    /**
     * @var MessageEncryptor
     */
    private $encryptor;
    
    public function setUp()
    {
        parent::setUp();
        
        $processor = new Processor();
        $this->encryptor = new MessageEncryptor($processor);
    }
    
    public function testMustBeInstanceOfMessageEncryptor()
    {
        $this->assertInstanceOf(MessageEncryptor::class, $this->encryptor);
    }
    
    public function testMustEncryptMessage()
    {
        try {
            $resource = new MessageResource($this->getKey(), self::MESSAGE);
            $message = $this->encryptor->encrypt($resource);
            
            $this->assertInstanceOf(MessageBox::class, $message);
            $this->assertNotEmpty($message->getMessage());
        } catch (EncryptionException $e) {
        }
    }
    
    /**
     * @return string
     */
    private function getKey(): string
    {
        return hex2bin(self::KEY);
    }
}
