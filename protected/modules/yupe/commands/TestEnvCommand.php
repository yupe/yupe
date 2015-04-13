<?php
/**
 * TestEnvCommand
 *
 * Console application for create and manage testing environment.
 * @package  yupe.commands
 * @author   Anton Kucherov <idexter.ru@gmail.com>
 * @author   YupeTeam <team@yupe.ru>
 * @link     http://yupe.ru
 */
/*
 *
 * @TODO добавить возможность указать параметры для Selenium2 драйвера, можно ограичиться только url
 *
 **/

class TestEnvCommand extends CConsoleCommand
{
    const COMMAND_DIR = __DIR__;
    const ROOT_DIR = "/../..";
    const CONFIG_DIR = "/../config";
    const TESTS_DIR = "/../../tests";

    public $dbOptions = ['dbname' => 'yupe_test', 'dbuser' => 'root', 'dbpass' => ''];

    public function actionIndex()
    {
        echo self::COMMAND_DIR . "\n";
        echo self::COMMAND_DIR . self::ROOT_DIR . "\n";
        echo self::COMMAND_DIR . self::CONFIG_DIR . "\n";
        echo self::COMMAND_DIR . self::TESTS_DIR . "\n";
        $this->readOptions();
    }

    public function actionCreate()
    {
        $this->createConfigFile(
            self::COMMAND_DIR . self::CONFIG_DIR,
            'db-test.php',
            'db.back.php'
        );
        $this->createConfigFile(
            self::COMMAND_DIR . self::ROOT_DIR,
            'codeception.yml',
            'codeception.dist.yml'
        );
        $this->createConfigFile(
            self::COMMAND_DIR . self::TESTS_DIR,
            'acceptance.suite.yml',
            'acceptance.suite.dist.yml'
        );
        $this->createConfigFile(
            self::COMMAND_DIR . self::TESTS_DIR,
            'functional.suite.yml',
            'functional.suite.dist.yml'
        );
        $this->createConfigFile(
            self::COMMAND_DIR . self::TESTS_DIR,
            'unit.suite.yml',
            'unit.suite.dist.yml'
        );

        $this->readOptions();

        $this->replaceDbOptionsInConfig(self::COMMAND_DIR . self::CONFIG_DIR . "/db-test.php");
        $this->replaceDbOptionsInConfig(self::COMMAND_DIR . self::ROOT_DIR . "/codeception.yml");
        $this->replaceDbOptionsInConfig(self::COMMAND_DIR . self::TESTS_DIR . "/acceptance.suite.yml");
        $this->replaceDbOptionsInConfig(self::COMMAND_DIR . self::TESTS_DIR . "/functional.suite.yml");
        $this->replaceDbOptionsInConfig(self::COMMAND_DIR . self::TESTS_DIR . "/unit.suite.yml");
    }

    public function actionReset()
    {
        $this->removeConfigFile(self::COMMAND_DIR . self::CONFIG_DIR . "/db-test.php");
        $this->removeConfigFile(self::COMMAND_DIR . self::ROOT_DIR . "/codeception.yml");
        $this->removeConfigFile(self::COMMAND_DIR . self::TESTS_DIR . "/acceptance.suite.yml");
        $this->removeConfigFile(self::COMMAND_DIR . self::TESTS_DIR . "/functional.suite.yml");
        $this->removeConfigFile(self::COMMAND_DIR . self::TESTS_DIR . "/unit.suite.yml");
    }

    /**
     * Creates config file from source file.
     * @param $dir string Config directory
     * @param $fileName string Config filename
     * @param $distFileName string SourceConfig filename
     * @return bool True if file was created, False if not
     */
    private function createConfigFile($dir, $fileName, $distFileName)
    {
        $config = $dir . "/" . $fileName;
        if (!file_exists($config)) {
            return copy($dir . '/' . $distFileName, $config);
        }

        return false;
    }

    /**
     * Reads options for environment from console.
     */
    private function readOptions()
    {
        echo "Enter name of testing DB (default: yupe_test): ";
        $this->readFromConsole($this->dbOptions["dbname"]);

        echo "Enter login for testing DB (default: root): ";
        $this->readFromConsole($this->dbOptions["dbuser"]);

        echo "Enter password for testing DB (default: ): ";
        $this->readFromConsole($this->dbOptions["dbpass"]);
    }

    /**
     * Reads line from the console and writes it to variable.
     * @param $value string.
     */
    private function readFromConsole(&$value)
    {
        $stdin = substr(trim(fgets(STDIN)), 0, 50);
        $value = (strlen($stdin) > 0) ? $stdin : $value;
    }

    /**
     * Replace DataBase config parameters in config files
     * @param $file string Config File Name
     * @return bool True if replaced, False if not
     */
    private function replaceDbOptionsInConfig($file)
    {
        if (file_exists($file)) {
            $fileContents = file_get_contents($file, FILE_TEXT);
            $fileContents = preg_replace('/<db\.name>/is', $this->dbOptions['dbname'], $fileContents);
            $fileContents = preg_replace('/<db\.user>/is', $this->dbOptions['dbuser'], $fileContents);
            $fileContents = preg_replace('/<db\.pass>/is', $this->dbOptions['dbpass'], $fileContents);

            return (bool)file_put_contents($file, $fileContents, FILE_TEXT);
        }

        return false;
    }

    /**
     * Remove file if it exists
     * @param $file string File name
     * @return bool True if file removed of not exists, False in another case
     */
    private function removeConfigFile($file)
    {
        if (file_exists($file)) {
            return unlink($file);
        }

        return true;
    }
}
