<?php

namespace CryptoTest\unit\Resources;

use Crypto\Resources\FileResource;
use PHPUnit\Framework\TestCase;

/**
 * Class FileResourceTest
 * @package CryptoTest\unit\Resources
 */
class FileResourceTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testMustBeInstanceOfFileResource()
    {
        $resource = new FileResource('in', 'out', 'key');
        $this->assertInstanceOf(FileResource::class, $resource);
    }
    
    public function testMustReturnFileInputResource()
    {
        $resource = new FileResource('in', 'out', 'key');
        $this->assertEquals('in', $resource->getInputFile());
    }
    
    public function testMustReturnFileOutputResource()
    {
        $resource = new FileResource('in', 'out', 'key');
        $this->assertEquals('out', $resource->getOutputFile());
    }
    
    public function testMustReturnKey()
    {
        $resource = new FileResource('in', 'out', 'key');
        $this->assertEquals('key', $resource->getKey());
    }
}
