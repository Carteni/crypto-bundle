<?php

/*
 * This file is part of the MesCryptoBundle package.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mes\Security\CryptoBundle\Tests\KeyStorage;

use Defuse\Crypto\KeyProtectedByPassword;
use Mes\Security\CryptoBundle\KeyStorage\KeyStorage;
use Mes\Security\CryptoBundle\KeyStorage\KeyStorageInterface;
use Mes\Security\CryptoBundle\Model\Key;

/**
 * Class KeyStorageTest.
 */
class KeyStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var KeyStorageInterface
     */
    private $keyStorage;

    protected function setUp()
    {
        $this->keyStorage = new KeyStorage();
    }

    protected function tearDown()
    {
        $this->keyStorage = null;
    }

    public function testSetKeyStoresKey()
    {
        $secret = 'ThisIsASecret';
        $key = Key::create(KeyProtectedByPassword::createRandomPasswordProtectedKey($secret), $secret);

        $this->keyStorage->setKey($key);

        $this->assertInstanceOf('Defuse\Crypto\KeyProtectedByPassword', $this->keyStorage->getKey()
                                                                                         ->getRawKey());
        $this->assertSame($secret, $this->keyStorage->getKey()
                                                    ->getSecret());
    }
}
