<?php

namespace CryptoTest\system\Decryptors;

use Crypto\Processors\Processor;
use Crypto\Decryptors\FileDecryptor;
use Crypto\Exceptions\FileDecryptionException;
use Crypto\Resources\FileResource;
use PHPUnit\Framework\TestCase;

/**
 * Class FileDecryptorTest
 * @package CryptoTest\system\Decryptors
 */
class FileDecryptorTest extends TestCase
{
    private const FILE_IN = __DIR__ . '/../../mock/390_out.txt';
    private const FILE_NEW = __DIR__ . '/../../mock/test_new.txt';
    private const KEY = 'bdd3d02607f26b1f2feb8571a4e25b5e5e9435da9a1a20c29c73baf4a1c80298';
    /**
     * @var FileDecryptor
     */
    private $decryptor;
    /**
     * @var Processor
     */
    private $processor;
    
    public function setUp()
    {
        parent::setUp();
        $this->processor = new Processor();
        $this->decryptor = new FileDecryptor($this->processor);
    }
    
    public function testMustReturnInstanceOfFileDecryptor()
    {
        $this->assertInstanceOf(FileDecryptor::class, $this->decryptor);
    }
    
    public function testMustDecryptFile()
    {
        try {
            $resource = new FileResource(self::FILE_IN, self::FILE_NEW, $this->getKey());
            $this->decryptor->decrypt($resource);
            $this->assertFileExists(self::FILE_NEW);
            $this->assertFileIsReadable(self::FILE_NEW);
        } catch (FileDecryptionException $e) {
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
