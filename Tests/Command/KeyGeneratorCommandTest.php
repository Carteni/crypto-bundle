<?php

/*
 * This file is part of the MesCryptoBundle package.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mes\Security\CryptoBundle\Tests\Command;

use Mes\Security\CryptoBundle\Command\KeyGeneratorCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Process\Process;

/**
 * Class KeyGeneratorCommandTest.
 */
class KeyGeneratorCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommandTester
     */
    private $commandTester;

    /**
     * @var Command
     */
    private $command;

    /**
     * @var QuestionHelper ;
     */
    private $helper;

    protected function setUp()
    {
        $application = new Application();
        $application->add(new KeyGeneratorCommand());
        $this->command = $application->find('mes:crypto:generate-key');
        $this->helper = $this->command->getHelper('question');
        $this->commandTester = new CommandTester($this->command);
    }

    protected function tearDown()
    {
        $this->commandTester = null;
        $this->command = null;
        $this->helper = null;
    }

    /**
     * @group legacy
     */
    public function testExecuteGeneratesKeySavedInDirAndWithAuthenticationSecret()
    {
        $this->helper->setInputStream($this->getInputStream(array(
            'yes',
            'ThisIsASecret',
            'yes',
            'yes',
        )));

        // Symfony 3.2+
        /*$this->commandTester->setInputs(array(
            'yes',
            'ThisIsASecret',
            // "\n" for <Enter>
            'yes',
            'yes',
        ));*/

        $this->commandTester->execute(array(
            'command' => $this->command->getName(),
            '--dir' => __DIR__.'/../key.crypto',
        ), array(
            'interactive' => true,
            'verbosity' => OutputInterface::VERBOSITY_DEBUG,
        ));

        $process = new Process('cat ./../key.crypto | grep "secret" ', __DIR__);
        $process->run();

        $this->assertSame(0, $this->commandTester->getStatusCode(), 'Returns 0 in case of success');
        $this->assertContains('RES  Everything is OK!', $this->commandTester->getDisplay());
        $this->assertRegExp('#secret = ThisIsASecret$#', $process->getOutput());
    }

    /**
     * @expectedException \RuntimeException
     *
     * @group legacy
     */
    public function testInteractThrowsException()
    {
        // http://daleswanson.org/ascii.htm
        $this->helper->setInputStream($this->getInputStream(array(
            'yes',
            "\x09\x11",
            "\n",
        )));

        $this->commandTester->execute(array(
            'command' => $this->command->getName(),
        ), array(
            'interactive' => true,
        ));
    }

    /**
     * @group legacy
     */
    public function testExecuteAborted()
    {
        $this->helper->setInputStream($this->getInputStream(array(
            'yes',
            'ThisIsSecret',
            'no',
        )));

        $this->commandTester->execute(array(
            'command' => $this->command->getName(),
        ), array(
            'interactive' => true,
        ));

        $statusCode = $this->commandTester->getStatusCode();

        $this->assertSame(1, $statusCode, 'Returns 0 in case of success');
    }

    /**
     * @param $input
     *
     * @return resource
     */
    private function getInputStream($input)
    {
        $stream = fopen('php://memory', 'r+', false);
        fputs($stream, implode(PHP_EOL, $input));
        rewind($stream);

        return $stream;
    }
}
