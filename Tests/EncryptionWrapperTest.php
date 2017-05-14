<?php

/*
 * This file is part of the MesCryptoBundle package.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mes\Security\CryptoBundle\Tests;

use Defuse\Crypto\Exception\CryptoException as BaseCryptoException;
use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Mes\Security\CryptoBundle\EncryptionWrapper;
use Mes\Security\CryptoBundle\Exception\CryptoException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class EncryptionWrapperTest.
 */
class EncryptionWrapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mes\Security\CryptoBundle\EncryptionWrapper
     */
    private $wrapper;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $encryption;

    protected function setUp()
    {
        $this->encryption = $this->getMockBuilder('Mes\Security\CryptoBundle\EncryptionInterface')
                                 ->getMock();
        $this->wrapper = new EncryptionWrapper($this->encryption);
    }

    protected function tearDown()
    {
        $this->wrapper = null;
        $this->encryption = null;
    }

    /**
     * @group legacy
     *
     * @throws \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testEncryptEncryptsPlaintext()
    {
        $this->encryption->expects($this->once())
                         ->method('encrypt')
                         ->with('The quick brown fox jumps over the lazy dog', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'))
                         ->will($this->returnValue('ThisIsACipherText'));

        $ciphertext = $this->wrapper->encrypt('The quick brown fox jumps over the lazy dog', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));

        $this->assertTrue(ctype_print($ciphertext), 'is printable');
    }

    /**
     * @throws \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testEncryptWithKeyEncryptsPlaintext()
    {
        $this->encryption->expects($this->once())
                         ->method('encryptWithKey')
                         ->with('The quick brown fox jumps over the lazy dog', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'))
                         ->will($this->returnValue('ThisIsACipherText'));

        $ciphertext = $this->wrapper->encryptWithKey('The quick brown fox jumps over the lazy dog', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));

        $this->assertTrue(ctype_print($ciphertext), 'is printable');
    }

    /**
     * @group legacy
     *
     * @expectedException \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testEncryptEncryptsPlaintextThrowsException()
    {
        try {
            $this->encryption->expects($this->once())
                             ->method('encrypt')
                             ->with('The quick brown fox jumps over the lazy dog', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'))
                             ->will($this->throwException(new EnvironmentIsBrokenException()));
        } catch (EnvironmentIsBrokenException $e) {
            $this->throwException(new CryptoException());
        }

        $this->wrapper->encrypt('The quick brown fox jumps over the lazy dog', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));
    }

    /**
     * @expectedException \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testEncryptWithKeyEncryptsPlaintextThrowsException()
    {
        try {
            $this->encryption->expects($this->once())
                             ->method('encryptWithKey')
                             ->with('The quick brown fox jumps over the lazy dog', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'))
                             ->will($this->throwException(new EnvironmentIsBrokenException()));
        } catch (EnvironmentIsBrokenException $e) {
            $this->throwException(new CryptoException());
        }

        $this->wrapper->encryptWithKey('The quick brown fox jumps over the lazy dog', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));
    }

    /**
     * @group legacy
     *
     * @throws \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testDecryptDecryptsCiphertext()
    {
        $this->encryption->expects($this->once())
                         ->method('decrypt')
                         ->with('ThisIsACipherText', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'))
                         ->will($this->returnValue('The quick brown fox jumps over the lazy dog'));

        $decryptedText = $this->wrapper->decrypt('ThisIsACipherText', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));

        $this->assertSame('The quick brown fox jumps over the lazy dog', $decryptedText);
    }

    /**
     * @throws \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testDecryptWithKeyDecryptsCiphertext()
    {
        $this->encryption->expects($this->once())
                         ->method('decryptWithKey')
                         ->with('ThisIsACipherText', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'))
                         ->will($this->returnValue('The quick brown fox jumps over the lazy dog'));

        $decryptedText = $this->wrapper->decryptWithKey('ThisIsACipherText', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));

        $this->assertSame('The quick brown fox jumps over the lazy dog', $decryptedText);
    }

    /**
     * @group legacy
     *
     * @expectedException \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testDecryptDecryptsCiphertextThrowsException()
    {
        try {
            $this->encryption->expects($this->once())
                             ->method('decrypt')
                             ->with('ThisIsACipherText', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'))
                             ->will($this->throwException(new BaseCryptoException()));
        } catch (BaseCryptoException $e) {
            $this->throwException(new CryptoException());
        }

        $this->wrapper->decrypt('ThisIsACipherText', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));
    }

    /**
     * @expectedException \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testDecryptWithKeyDecryptsCiphertextThrowsException()
    {
        try {
            $this->encryption->expects($this->once())
                             ->method('decryptWithKey')
                             ->with('ThisIsACipherText', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'))
                             ->will($this->throwException(new BaseCryptoException()));
        } catch (BaseCryptoException $e) {
            $this->throwException(new CryptoException());
        }

        $this->wrapper->decryptWithKey('ThisIsACipherText', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));
    }

    /**
     * @group legacy
     *
     * @throws \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testEncryptFileEncryptsFile()
    {
        $this->encryption->expects($this->once())
                         ->method('encryptFile')
                         ->will($this->returnCallback(function ($input, $output) {
                             $fs = new Filesystem();
                             $fs->dumpFile($output, '');
                         }));

        $this->wrapper->encryptFile(__DIR__.'/file.txt', __DIR__.'/file.crypto', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));

        $this->assertFileExists(__DIR__.'/file.crypto');

        unlink(__DIR__.'/file.crypto');
    }

    /**
     * @throws \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testEncryptWithKeyFileEncryptsFile()
    {
        $this->encryption->expects($this->once())
                         ->method('encryptFileWithKey')
                         ->will($this->returnCallback(function ($input, $output) {
                             $fs = new Filesystem();
                             $fs->dumpFile($output, '');
                         }));

        $this->wrapper->encryptFileWithKey(__DIR__.'/file.txt', __DIR__.'/file.crypto', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));

        $this->assertFileExists(__DIR__.'/file.crypto');

        unlink(__DIR__.'/file.crypto');
    }

    /**
     * @group legacy
     *
     * @throws \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testDecryptFileDecryptsEncryptedFile()
    {
        $this->encryption->expects($this->once())
                         ->method('decryptFile')
                         ->will($this->returnCallback(function ($input, $output) {
                             $fs = new Filesystem();
                             $fs->dumpFile($output, 'Plain text');
                         }));

        $this->wrapper->decryptFile(__DIR__.'/file.crypto', __DIR__.'/file.txt', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));

        $this->assertFileExists(__DIR__.'/file.txt');
        $this->assertContains('Plain text', file_get_contents(__DIR__.'/file.txt'));

        unlink(__DIR__.'/file.txt');
    }

    /**
     * @throws \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testDecryptWithKeyFileDecryptsEncryptedFile()
    {
        $this->encryption->expects($this->once())
                         ->method('decryptFileWithKey')
                         ->will($this->returnCallback(function ($input, $output) {
                             $fs = new Filesystem();
                             $fs->dumpFile($output, 'Plain text');
                         }));

        $this->wrapper->decryptFileWithKey(__DIR__.'/file.crypto', __DIR__.'/file.txt', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));

        $this->assertFileExists(__DIR__.'/file.txt');
        $this->assertContains('Plain text', file_get_contents(__DIR__.'/file.txt'));

        unlink(__DIR__.'/file.txt');
    }

    /**
     * @group legacy
     *
     * @expectedException \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testEncryptFileThrowsException()
    {
        try {
            $this->encryption->expects($this->once())
                             ->method('encryptFile')
                             ->will($this->throwException(new BaseCryptoException()));
        } catch (BaseCryptoException $e) {
            $this->throwException(new CryptoException());
        }

        $this->wrapper->encryptFile(__DIR__.'/file.txt', __DIR__.'/file.crypto', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));
    }

    /**
     * @expectedException \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testEncryptWithKeyFileThrowsException()
    {
        try {
            $this->encryption->expects($this->once())
                             ->method('encryptFileWithKey')
                             ->will($this->throwException(new BaseCryptoException()));
        } catch (BaseCryptoException $e) {
            $this->throwException(new CryptoException());
        }

        $this->wrapper->encryptFileWithKey(__DIR__.'/file.txt', __DIR__.'/file.crypto', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));
    }

    /**
     * @group legacy
     *
     * @expectedException \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testDecryptFileThrowsException()
    {
        try {
            $this->encryption->expects($this->once())
                             ->method('decryptFile')
                             ->will($this->throwException(new BaseCryptoException()));
        } catch (BaseCryptoException $e) {
            $this->throwException(new CryptoException());
        }

        $this->wrapper->decryptFile(__DIR__.'/file.crypto', __DIR__.'/file.txt', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));
    }

    /**
     * @expectedException \Mes\Security\CryptoBundle\Exception\CryptoException
     */
    public function testDecryptWithKeyFileThrowsException()
    {
        try {
            $this->encryption->expects($this->once())
                             ->method('decryptFileWithKey')
                             ->will($this->throwException(new BaseCryptoException()));
        } catch (BaseCryptoException $e) {
            $this->throwException(new CryptoException());
        }

        $this->wrapper->decryptFileWithKey(__DIR__.'/file.crypto', __DIR__.'/file.txt', $this->getMock('Mes\Security\CryptoBundle\Model\KeyInterface'));
    }
}
