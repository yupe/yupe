<?php
namespace comments;
use Codeception\Util\Stub as Strub;

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
        $config = require_once APPLICATION_DIR.'config/console.php';
        if(!\Yii::app()) \Yii::createConsoleApplication($config);
        require_once MOCKED_DIR.'Migrator.php';

        $this->fixture = new \MigrateToNestedSetsCommand('migratetonestedsets', new \CConsoleCommandRunner());
        $this->fixture->migrator = $this->getFilledMigratorStrub();
    }

    protected function _after()
    {

        unset($this->fixture);
    }

    // tests
    public function testNsMigrationExists()
    {
        $this->assertTrue($this->fixture->NsMigrationExists($this->fixture->migrator));
        $this->fixture->migrator = $this->getEmptyMigratorStrub();
        $this->assertFalse($this->fixture->NsMigrationExists($this->fixture->migrator));
    }

    public function testActionMigrationUp()
    {
        $this->assertTrue($this->fixture->actionMigrationUp());
    }

    // other help functions
    protected function getEmptyMigratorStrub()
    {
        return Strub::makeEmpty(
            'mocked\Migrator',
            array(
                'getMigrationHistory' => function () {
                    return array();
                }
            )
        );
    }

    protected function getFilledMigratorStrub()
    {
        return Strub::make(
            'mocked\Migrator',
            array(
                'getMigrationHistory' => function() {
                    return array(\MigrateToNestedSetsCommand::NS_MIGRATION_NAME => "0");
                },
                'updateToLatest' => function($module){
                    return true;
                }
            )
        );
    }

}