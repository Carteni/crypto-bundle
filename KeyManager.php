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

use Mes\Security\CryptoBundle\KeyGenerator\KeyGeneratorInterface;
use Mes\Security\CryptoBundle\KeyStorage\KeyStorageInterface;
use Mes\Security\CryptoBundle\Model\KeyInterface;

/**
 * Class KeyManager.
 */
final class KeyManager implements KeyManagerInterface
{
    /**
     * @var KeyStorageInterface
     */
    protected $keyStorage;

    /**
     * @var KeyGeneratorInterface
     */
    protected $keyGenerator;

    /**
     * @var string
     */
    protected $secret;

    public function __construct(KeyStorageInterface $keyStorage, KeyGeneratorInterface $keyGenerator)
    {
        $this->keyStorage = $keyStorage;
        $this->keyGenerator = $keyGenerator;
        $this->setSecret(null);
    }

    /**
     * {@inheritdoc}
     */
    public function generate($secret = null)
    {
        return $this->keyGenerator->generate($secret);
    }

    /**
     * {@inheritdoc}
     */
    public function generateFromAscii($key_encoded, $secret = null)
    {
        return $this->keyGenerator->generateFromAscii($key_encoded, $secret);
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        if (null === $key = $this->keyStorage->getKey()) {
            $this->keyStorage->setKey($key = $this->generate($this->getSecret()));
        }

        return $key;
    }

    /**
     * {@inheritdoc}
     */
    public function setKey(KeyInterface $key)
    {
        $this->keyStorage->setKey($key);
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }
}
