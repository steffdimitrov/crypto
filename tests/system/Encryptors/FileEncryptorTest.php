<?php

namespace CryptoTest\system\Encryptors;

use Crypto\Processors\Processor;
use Crypto\Encryptors\FileEncryptor;
use Crypto\Resources\FileResource;
use PHPUnit\Framework\TestCase;

/**
 * Class FileEncryptorTest
 * @package CryptoTest\system\Encryptors
 */
class FileEncryptorTest extends TestCase
{
    private const FILE_IN = __DIR__ . '/../../mock/390.txt';
    private const FILE_OUT = __DIR__ . '/../../mock/390_out.txt';
    private const KEY = 'bdd3d02607f26b1f2feb8571a4e25b5e5e9435da9a1a20c29c73baf4a1c80298';
    /**
     * @var FileEncryptor
     */
    private $encryptor;
    /**
     * @var Processor
     */
    private $processor;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->processor = new Processor();
        $this->encryptor = new FileEncryptor($this->processor);
    }
    
    public function testMustBeInstanceOfFileEncryptor()
    {
        $this->assertInstanceOf(FileEncryptor::class, $this->encryptor);
    }
    
    public function testMustEncryptFileContentAndStoreItIntoOutFile()
    {
        $resource = new FileResource(self::FILE_IN, self::FILE_OUT, $this->getKey());
        $this->encryptor->encrypt($resource);
        $this->assertStringNotEqualsFile(self::FILE_OUT, '');
        $this->assertFileExists(self::FILE_OUT);
        $this->assertFileIsReadable(self::FILE_OUT);
    }
    
    /**
     * @return string
     */
    private function getKey(): string
    {
        return hex2bin(self::KEY);
    }
}
