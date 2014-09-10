<?php

namespace Codeception\Module;

class DbHelper extends \Codeception\Module\Db
{
    /**
     * Gets Driver from Db module and adds some sugar.
     * Yo ho ho !!! :D
     * @return array dbConfig
     */
    public function getDbConfig()
    {
        $dbConfig = $this->config;
        $dbConfig["dbname"] = preg_replace('/.+dbname=(.+)$/is', '$1', $dbConfig["dsn"]);

        return $dbConfig;
    }
}
