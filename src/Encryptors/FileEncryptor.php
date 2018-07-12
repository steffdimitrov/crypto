<?php

namespace Crypto\Encryptors;

use Crypto\Processors\Processor;
use Crypto\Exceptions\FileEncryptionException;
use Crypto\Exceptions\IOException;
use Crypto\Exceptions\KeyGenerationException;
use Crypto\Resources\FileResource;
use Crypto\Transformers\BaseFileTransformer;

/**
 * Class FileEncryptor
 * @package Crypto\Encryptors
 */
class FileEncryptor extends BaseFileTransformer
{
    /**
     * @param FileResource $resource
     *
     * @return bool
     * @throws FileEncryptionException
     */
    public function encrypt(FileResource $resource): bool
    {
        try {
            $input = $this->open($resource->getInputFile(), self::READ_MODE);
            $output = $this->open($resource->getOutputFile(), self::WRITE_MODE);
            $iterator = $this->readFile($input);
            
            foreach ($iterator as $item) {
                $cipher = $this->processor->encrypt($item, $resource->getKey());
                $this->write($output, $cipher->getMessage());
            }
            
            return true;
        } catch (IOException | KeyGenerationException $e) {
            throw new FileEncryptionException('Error occurs while file was encrypted!' . ' ' . ucfirst($e->getMessage()));
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