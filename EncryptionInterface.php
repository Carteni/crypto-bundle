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

use Mes\Security\CryptoBundle\Model\KeyInterface;

/**
 * Interface EncryptionInterface.
 */
interface EncryptionInterface
{
    /**
     * Encrypts a plaintext string using a secret key.
     *
     * @param string       $plaintext String to encrypt
     * @param KeyInterface $key       Instance of KeyInterface containing the secret key for encryption
     *
     * @return string
     */
    public function encrypt($plaintext, KeyInterface $key);

    /**
     * Decrypts a ciphertext string using a secret key.
     *
     * @param string            $ciphertext ciphertext to be decrypted
     * @param KeyInterface|null $key        Instance of KeyInterface containing the secret key for decryption
     *
     * @return string
     */
    public function decrypt($ciphertext, KeyInterface $key);

    /**
     * Encrypts a file using a secret key.
     *
     * @param string       $inputFilename  Path to a file containing the plaintext to encrypt
     * @param string       $outputFilename Path to save the ciphertext file
     * @param KeyInterface $key            Instance of KeyInterface containing the secret key for encryption
     */
    public function encryptFile($inputFilename, $outputFilename, KeyInterface $key);

    /**
     * Decrypts a file using a secret key.
     *
     * @param string       $inputFilename  Path to a file containing the ciphertext to decrypt
     * @param string       $outputFilename Path to save the decrypted plaintext file
     * @param KeyInterface $key            Instance of KeyInterface containing the secret key for encryption
     */
    public function decryptFile($inputFilename, $outputFilename, KeyInterface $key);
}
