<?php
namespace comments;
use Codeception\Util\Stub as Strub;
use yupe\components\Migrator;
class MigrateToNsTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;
    /**
     * @var \MigrateToNestedSetsCommand
     */
    protected $fixture;

    protected function _before()
    {
        Strub::$magicMethods = array('__isset', '__get');
        $migratorMock = Strub::makeEmpty(
            'yupe\components\Migrator',
            array(
                'getMigrationHistory' => function($module, $limit = 20) {
                    return array(\MigrateToNestedSetsCommand::NS_MIGRATION_NAME => "0");
                },
                'updateToLatest' => function($module){
                    return true;
                }
            )
        );

        $this->fixture = new \MigrateToNestedSetsCommand('migratetonestedsets', new \CConsoleCommandRunner());
        $this->fixture->migrator = $migratorMock;
    }

    protected function _after()
    {
        Strub::$magicMethods = array('__isset', '__get', '__set');
        $this->fixture;
    }

    // tests

    public function testNsMigrationExists()
    {
        $migratorNoMigration = Strub::makeEmpty(
            'yupe\components\Migrator',
            array(
                'getMigrationHistory' => function($module, $limit = 20) {
                    return array();
                }
            )
        );

        $this->assertTrue($this->fixture->NsMigrationExists($this->fixture->migrator));
        $this->assertFalse($this->fixture->NsMigrationExists($migratorNoMigration));
    }

    public function testActionMigrationUp()
    {
        $this->assertTrue($this->fixture->actionMigrationUp());
    }

}