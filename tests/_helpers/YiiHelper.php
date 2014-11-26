<?php
namespace Codeception\Module;

// here you can define custom functions for CodeGuy

class YiiHelper extends \Codeception\Module
{
    public function createConsoleYiiApp()
    {
        require dirname(__FILE__) . '/../../vendor/autoload.php';
        $config = require dirname(__FILE__) . '/../../protected/config/console-test.php';
        \Yii::$enableIncludePath = false;
        if (!\Yii::app()) {
            \Yii::createConsoleApplication($config);
        }
    }

    /**
     * Sets Db configuration file from Yii db.php or other file.
     * @param $dbConfigFile string DataBase Configuration file
     */
    public function setDbConnectionOptionsFromYiiConfig($dbConfigFile)
    {
        $dbConfig = include $dbConfigFile;
        $mapKeys = ['connectionString' => 'dsn', 'username' => 'user', 'password' => 'password'];
        foreach ($mapKeys as $k => $v) {
            if (array_key_exists($k, $dbConfig)) {
                $dbConfig[$v] = $dbConfig[$k];
                unset($dbConfig[$k]);
            }
        }
        $config = $this->_filterOptions($dbConfig, ['dsn', 'user', 'password']);
        $this->getModule('Db')->_reconfigure($config);
        $this->getModule('Db')->_initialize();
    }

    /**
     * Sets DataBase Dump file and its options
     * For example:
     *
     * ``` php
     * <?php
     *     $this->setDbDumpOptions( array('dump'=>'tests/_data/mydump.sql','populate'=>true,'cleanup'=>false) );
     * ?>
     * ```
     *
     * @param array $dumpOptions module config options
     */
    public function setDbDumpOptions(array $dumpOptions)
    {
        $config = $this->_filterOptions($dumpOptions, ['dump', 'populate', 'cleanup']);
        $this->getModule('Db')->_reconfigure($config);
        $this->getModule('Db')->_initialize();
    }

    protected function _filterOptions(array $options, array $optionsList)
    {
        foreach ($options as $k => $v) {
            if (in_array($k, $optionsList) && !empty($v)) {
                $summary[$k] = $v;
            }
        }

        return $summary;
    }
}
