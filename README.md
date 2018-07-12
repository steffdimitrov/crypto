# This is Crypto library.

## Description
* It provides availability for encryption and decryption of strings and files.

* Internally it uses build-in libsodium into php 7.*

# Examples
For encrypting a single message text:
#### Usage
```php
$key = '\x80\x90';
$message = 'this is a sample text message';

$processor = new Processor();
$resource = new MessageResource($key, $message);
$encryptor = new MessageEncryptor($processor, $resource);
try {
    $cipher = $encryptor->encrypt();
} catch (EncryptionException $e) {
    echo $e->getMessage();
}
```

For decrypting a message:
#### Usage
```php
$key = '\x80\x90';
$message = '8cfp/NJBL++uRStTdfuigfx6107xx7Z8qNl/b0W6ZxAWRE+mHb6Qpz48wzN43Xoxq4yCALaHAI09aHGycuNDJcrDvdeWRllT4UQ8jBPZyA==';

$processor = new Processor();
$message = new MessageResource($key, $message);
$decryptor = new MessageDecryptor($processor,$message);
try {
    $text = $decryptor->decrypt();
} catch (DecryptionException $e) {
    echo $e->getMessage();
}
```

For encrypting a file:
#### Usage
```php
$key = '\x80\x90';
$in = __DIR__ . '/file.html';
$out = __DIR__ . '/file.crypt';

$processor = new Processor();
$resource = new EncryptFileResource($in, $out, $this->getKey());
$encryptor = new FileEncryptor($resource, $processor);
try {
    $encryptor->encrypt();
} catch (EncryptionException $e) {
    echo $e->getMessage();
}
```

For decryption of a file:
#### Usage
```php
$key = '\x80\x90';
$out = __DIR__ . '/file.crypt';

$processor = new Processor();
$resource = new DecryptFileResource($in, $out, $this->getKey());
$encryptor = new FileDecryptor($resource, $processor);
try {
    $encryptor->decrypt();
} catch (DecryptionException $e) {
    echo $e->getMessage();
}
```

Test for memory usage and execution time!
#### Code
```php
<?php
$encryptionStartTime = microtime(true);
require_once __DIR__ . '/vendor/autoload.php';

//390.txt is file with 390MB size
const FILE_IN = __DIR__ . '/tests/mock/390.txt';
const FILE_OUT = __DIR__ . '/tests/mock/390_out.txt';
const FILE_NEW = __DIR__ . '/tests/mock/test_new.txt';
const KEY = 'bdd3d02607f26b1f2feb8571a4e25b5e5e9435da9a1a20c29c73baf4a1c80298';

function convert($size) {
    $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
    
    $precision = 2;
    
    $base = 1024;
    
    return @round($size / pow($base, ($i = floor(log($size, $base)))), $precision) . ' ' . $unit[$i];
}

function getKey(): string{
    return hex2bin(KEY);
}
$processor = new \Crypto\Processors\Processor();
$encryptor = new \Crypto\Encryptors\FileEncryptor($processor);

$resource = new \Crypto\Resources\FileResource(FILE_IN, FILE_OUT, getKey());
$encryptor->encrypt($resource);

echo 'Encryption (mem): ';
echo convert(memory_get_peak_usage(true)), PHP_EOL;

$encryptionEndTime = microtime(true);
echo 'Total Encryption Time: ' . ($encryptionEndTime - $encryptionStartTime);

$decryptionStartTime = microtime(true);
$decryptor = new \Crypto\Decryptors\FileDecryptor($processor);
$resource = new \Crypto\Resources\FileResource(FILE_OUT, FILE_NEW, getKey());
$decryptor->decrypt($resource);

echo 'Decryption (mem): ';
echo convert(memory_get_peak_usage(true)), PHP_EOL;

$decryptionEndTime = microtime(true);
echo 'Total Decryption Time: ' . ($decryptionEndTime - $decryptionStartTime);
```

### Result (similar to):
```
Encryption (mem): 2 mb
Total Encryption Time: 12.331204175949
Decryption (mem): 2 mb
Total Decryption Time: 18.772175073624
```

## Resources
* https://paragonie.com/book/pecl-libsodium/read/00-intro.md
* https://paragonie.com/blog/2015/08/you-wouldnt-base64-a-password-cryptography-decoded
* https://paragonie.com/blog/2016/02/how-safely-store-password-in-2016
* https://tonyarcieri.com/all-the-crypto-code-youve-ever-written-is-probably-broken
* https://paragonie.com/blog/2015/05/using-encryption-and-authentication-correctly#title.2.1
* https://moxie.org/blog/the-cryptographic-doom-principle/
* http://www.daemonology.net/blog/2009-06-11-cryptographic-right-answers.html
* https://crypto.stackexchange.com/
* https://paragonie.com/blog/2015/11/choosing-right-cryptography-library-for-your-php-project-guide
* https://dev.to/paragonie/php-72-the-first-programming-language-to-add-modern-cryptography-to-its-standard-library
 