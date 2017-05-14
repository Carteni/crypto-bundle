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

    public function __construct(EncryptionInterface $encryption)
    {
        $this->encryption = $encryption;
    }

    /**
     * {@inheritdoc}
     *
     * @throw CryptoException
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
     * @throw CryptoException
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
     * @throw CryptoException
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
     * @throw CryptoException
     */
    public function decryptFileWithKey($inputFilename, $outputFilename, KeyInterface $key)
    {
        try {
            $this->encryption->decryptFileWithKey($inputFilename, $outputFilename, $key);
        } catch (BaseCryptoException $ex) {
            throw new CryptoException($ex->getMessage());
        }
    }
}
