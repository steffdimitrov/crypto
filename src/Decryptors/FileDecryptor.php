<?php

namespace Crypto\Decryptors;

use Crypto\Processors\Processor;
use Crypto\Exceptions\FileDecryptionException;
use Crypto\Exceptions\IOException;
use Crypto\Exceptions\MessageAuthenticationException;
use Crypto\Exceptions\MessageDecryptionException;
use Crypto\Resources\FileResource;
use Crypto\Transformers\BaseFileTransformer;

/**
 * Class FileDecryptor
 * @package Crypto\Decryptors
 */
class FileDecryptor extends BaseFileTransformer
{
    /**
     * 4kb text are encoded with base64_encode up to 5560kb
     * @var int
     */
    protected $chunk = 5560;
    
    /**
     * @param FileResource $resource
     *
     * @return string
     * @throws FileDecryptionException
     */
    public function decrypt(FileResource $resource): string
    {
        try {
            $input = $this->open($resource->getInputFile(), self::READ_MODE);
            $output = $this->open($resource->getOutputFile(), self::WRITE_MODE);
            
            $iterator = $this->readFile($input);
            
            foreach ($iterator as $item) {
                $message = $this->processor->decrypt($item, $resource->getKey());
                $this->write($output, $message);
            }
            
            return true;
        } catch (\SodiumException | IOException | MessageAuthenticationException | MessageDecryptionException $e) {
            if (! empty($output)) {
                $this->close($output);
                unlink($resource->getOutputFile());
            }
            throw new FileDecryptionException('Error occurs while file was decrypted!' . ' ' . ucfirst($e->getMessage()));
        } finally {
            if (! empty($input)) {
                $this->close($input);
            }
            if (! empty($output)) {
                $this->close($output);
            }
        }
    }
}