<?php

namespace Crypto\Resources;

/**
 * Class FileResource
 * @package Crypto\Resources
 */
class FileResource
{
    /**
     * @var string
     */
    private $in;
    /**
     * @var string
     */
    private $out;
    /**
     * @var string
     */
    private $key;
    
    /**
     * FileResource constructor.
     *
     * @param string $in
     * @param string $out
     * @param string $key
     */
    public function __construct(string $in, string $out, string $key)
    {
        $this->in = $in;
        $this->out = $out;
        $this->key = $key;
    }
    
    /**
     * @return string
     */
    public function getInputFile(): string
    {
        return $this->in;
    }
    
    /**
     * @return string
     */
    public function getOutputFile(): string
    {
        return $this->out;
    }
    
    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}