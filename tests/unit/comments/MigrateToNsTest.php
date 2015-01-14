<?php
namespace comments;

class MigrateToNsTest extends \Codeception\TestCase\Test
{
    /**
     * @var \CodeGuy
     */
    protected $codeGuy;
    /**
     * @var \MigrateToNestedSetsCommand
     */
    protected $command;

    protected function _before()
    {
        $this->codeGuy->createConsoleYiiApp();
        require_once MOCKED_DIR . 'Migrator.php';
        $this->codeGuy->setDbConnectionOptionsFromYiiConfig(APPLICATION_DIR . 'config/db-test.php');
        $this->codeGuy->setDbDumpOptions(['dump' => 'tests/_data/convert_to_ns.sql', 'populate' => true]);

        $this->command = new \MigrateToNestedSetsCommand('migratetonestedsets', null);
        $this->command->init();
        $this->command->actionUnlock();
    }

    protected function _after()
    {
        $this->command->actionUnlock();
        unset($this->command);
    }

    // tests
    public function testMigrateToNestedSetsCommand()
    {
        $this->command->actionIndex();
        $this->expectOutputRegex('/Prepare for migrating to/is');
        $this->expectOutputRegex('/Migrating to \'.+\' migration -> \[OK\]/is');
        $this->expectOutputRegex('/Selecting models which contains comments -> \[OK\]/is');
        $this->expectOutputRegex('/Converted succesfully./is');
    }

    public function testMigrateIfConvertorLocked()
    {
        $this->command->lockConverter();
        $this->command->actionIndex();
        $this->expectOutputRegex('/Converter is LOCKED./is');
    }

    public function testLockConverter()
    {
        $this->command->lockConverter();
        $this->assertTrue($this->command->converterLocked());
    }
}
