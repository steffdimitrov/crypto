<?php

namespace CryptoTest\unit\Resources;

use Crypto\Resources\MessageResource;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageResourceTest
 * @package CryptoTest\unit\Resources
 */
class MessageResourceTest extends TestCase
{
    private const MESSAGE = 'message';
    private const KEY = 'key';
    /**
     * @var MessageResource
     */
    private $resource;
    
    public function setUp()
    {
        // TODO: Change the auto generated stub
        parent::setUp();
        
        $this->resource = new MessageResource(self::KEY, self::MESSAGE);
    }
    
    public function testMustBeInstanceOfMessageResource()
    {
        $this->assertInstanceOf(MessageResource::class, $this->resource);
    }
    
    public function testMustReturnKey()
    {
        $this->assertEquals(self::KEY, $this->resource->getKey());
    }
    
    public function testMustReturnMessage()
    {
        $this->assertEquals(self::MESSAGE, $this->resource->getMessage());
    }
}
