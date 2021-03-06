<?php
namespace Indatus\Assembler;

use Indatus\Assembler\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testApiTokenIsParsedWell()
    {
        $apiToken = (new Configuration(realpath('tests'), 'configuration.yaml'))->apiToken();

        $this->assertEquals('yoursuperlongapitoken111', $apiToken);
    }

    /**
     * @expectedException \Indatus\Assembler\Exceptions\NoProviderTokenException
     */
    public function testComplainsWithBadProvider()
    {
        (new Configuration(realpath('tests'), 'bad-configuration-provider.yaml'))->apiToken();
    }

    public function testSshKeysAreParsedWell()
    {
        $sshKeys         = (new Configuration(realpath('tests'), 'configuration.yaml'))->sshKeys();
        $expectedSshKeys = [
            '00:00:00:00:00:00:00:00:00:00:00:00:00:00:00:00',
            '11:11:11:11:11:11:11:11:11:11:11:11:11:11:11:11',
        ];

        $this->assertEquals($expectedSshKeys, $sshKeys);
    }

    /**
     * @expectedException \Indatus\Assembler\Exceptions\MalformedSSHKeysException
     */
    public function testComplainsWhenSshKeysAreMalformed()
    {
        $sshKeys = (new Configuration(realpath('tests'), 'bad-configuration-ssh.yaml'))->sshKeys();
    }
}
