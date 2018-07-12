<?php

namespace Crypto\Transformers;

use Crypto\Processors\Processor;
use Crypto\Exceptions\IOException;

/**
 * Class BaseFileTransformer
 * @package Crypto\Transformers
 */
abstract class BaseFileTransformer
{
    protected const READ_MODE = 'rb';
    protected const WRITE_MODE = 'wb';
    /**
     * @var int
     */
    protected $chunk = 4096;
    /**
     * @var Processor
     */
    protected $processor;
    
    /**
     * BaseFileTransformer constructor.
     *
     * @param Processor $processor
     */
    public function __construct(Processor $processor)
    {
        $this->processor = $processor;
    }
    
    /**
     * @param string $file
     * @param string $mode
     *
     * @return bool|resource
     * @throws IOException
     */
    protected function open(string $file, string $mode)
    {
        $handler = fopen($file, $mode);
        if ($handler === false) {
            throw new IOException('Cannot open file: ' . $file);
        }
        
        return $handler;
    }
    
    /**
     * @param $handler
     *
     * @return void
     */
    protected function close($handler): void
    {
        if (\is_resource($handler)) {
            fclose($handler);
        }
    }
    
    /**
     * @param $handler
     *
     * @return \Generator
     */
    protected function readFile($handler): \Generator
    {
        while (! feof($handler)) {
            yield fread($handler, $this->chunk);
        }
    }
    
    /**
     * @param $handler
     * @param string $chunk
     *
     * @throws IOException
     */
    protected function write($handler, string $chunk): void
    {
        $recorded = fwrite($handler, $chunk);
        if (false === $recorded) {
            throw new IOException('Error in recording!');
        }
    }
}