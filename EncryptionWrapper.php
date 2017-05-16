<?php

/*
 * This file is part of the MesCryptoBundle package.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mes\Security\CryptoBundle;

use Defuse\Crypto\Exception\CryptoException as BaseCryptoException;
use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Mes\Security\CryptoBundle\Exception\CryptoException;
use Mes\Security\CryptoBundle\Model\KeyInterface;

/**
 * Class EncryptionWrapper.
 */
final class EncryptionWrapper implements EncryptionInterface
{
    /**
     * @var EncryptionInterface
     */
    private $encryption;

    /**
     * EncryptionWrapper constructor.
     *
     * @param EncryptionInterface $encryption
     */
    public function __construct(EncryptionInterface $encryption)
    {
        $this->encryption = $encryption;
    }

    /**
     * {@inheritdoc}
     *
     * @throws CryptoException
     */
    public function encryptWithKey($plaintext, KeyInterface $key)
    {
        try {
            return $this->encryption->encryptWithKey($plaintext, $key);
        } catch (EnvironmentIsBrokenException $ex) {
            throw new CryptoException($ex->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws CryptoException
     */
    public function decryptWithKey($ciphertext, KeyInterface $key)
    {
        try {
            return $this->encryption->decryptWithKey($ciphertext, $key);
        } catch (BaseCryptoException $ex) {
            throw new CryptoException($ex->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws CryptoException
     */
    public function encryptFileWithKey($inputFilename, $outputFilename, KeyInterface $key)
    {
        try {
            $this->encryption->encryptFileWithKey($inputFilename, $outputFilename, $key);
        } catch (BaseCryptoException $ex) {
            throw new CryptoException($ex->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws CryptoException
     */
    public function decryptFileWithKey($inputFilename, $outputFilename, KeyInterface $key)
    {
        try {
            $this->encryption->decryptFileWithKey($inputFilename, $outputFilename, $key);
        } catch (BaseCryptoException $ex) {
            throw new CryptoException($ex->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws CryptoException
     */
    public function encryptWithPassword($plaintext, $password)
    {
        try {
            return $this->encryption->encryptWithPassword($plaintext, $password);
        } catch (EnvironmentIsBrokenException $ex) {
            throw new CryptoException($ex->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws CryptoException
     */
    public function decryptWithPassword($ciphertext, $password)
    {
        try {
            return $this->encryption->decryptWithPassword($ciphertext, $password);
        } catch (BaseCryptoException $ex) {
            throw new CryptoException($ex->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws CryptoException
     */
    public function encryptFileWithPassword($inputFilename, $outputFilename, $password)
    {
        try {
            return $this->encryption->encryptFileWithPassword($inputFilename, $outputFilename, $password);
        } catch (BaseCryptoException $ex) {
            throw new CryptoException($ex->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws CryptoException
     */
    public function decryptFileWithPassword($inputFilename, $outputFilename, $password)
    {
        try {
            return $this->encryption->decryptFileWithPassword($inputFilename, $outputFilename, $password);
        } catch (BaseCryptoException $ex) {
            throw new CryptoException($ex->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws CryptoException
     */
    public function encryptResourceWithKey($inputHandle, $outputHandle, KeyInterface $key)
    {
        try {
            $this->encryption->encryptResourceWithKey($inputHandle, $outputHandle, $key);
        } catch (BaseCryptoException $ex) {
            throw new CryptoException($ex->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws CryptoException
     */
    public function decryptResourceWithKey($inputHandle, $outputHandle, KeyInterface $key)
    {
        try {
            return $this->encryption->decryptResourceWithKey($inputHandle, $outputHandle, $key);
        } catch (BaseCryptoException $ex) {
            throw new CryptoException($ex->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws CryptoException
     */
    public function encryptResourceWithPassword($inputHandle, $outputHandle, $password)
    {
        try {
            return $this->encryption->encryptResourceWithPassword($inputHandle, $outputHandle, $password);
        } catch (BaseCryptoException $ex) {
            throw new CryptoException($ex->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws CryptoException
     */
    public function decryptResourceWithPassword($inputHandle, $outputHandle, $password)
    {
        try {
            return $this->encryption->decryptResourceWithPassword($inputHandle, $outputHandle, $password);
        } catch (BaseCryptoException $ex) {
            throw new CryptoException($ex->getMessage());
        }
    }
}
