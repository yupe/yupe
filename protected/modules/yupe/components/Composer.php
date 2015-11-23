<?php

namespace yupe\components;

use Composer\Script\Event;

/**
 * Class Composer
 * @package yupe\components
 */
class Composer
{

    /**
     * @param Event $event
     */
    public static function postCreate(Event $event)
    {
        self::prepare($event);
        echo "Project created!\n";
    }

    /**
     * @param Event $event
     */
    public static function preInstall(Event $event)
    {
        echo "Yupe install\n";
        self::copyInstallConfig();
    }

    /**
     * @param Event $event
     */
    public static function postInstall(Event $event)
    {
        self::prepare($event);
        echo "Installation finished!\n";
    }

    /**
     * @param Event $event
     */
    public static function preUpdate(Event $event)
    {
        echo "Yupe update\n";
    }

    /**
     * @param Event $event
     */
    public static function postUpdate(Event $event)
    {
        echo "Update finished\n";
    }

    /**
     * @param Event $event
     */
    public static function prepare(Event $event)
    {
        $extra = $event->getComposer()->getPackage()->getExtra();

        if (!file_exists('protected/config/db.php')) {
            copy('protected/config/db.back.php', 'protected/config/db.php');
        }

        self::makeWritable($extra);
    }

    /**
     *
     */
    public static function copyInstallConfig()
    {
        copy('protected/modules/install/install/install.php', 'protected/config/modules/install.php');
    }

    /**
     *
     */
    public static function removeInstallConfig()
    {
        unlink('protected/config/modules/install.php');
    }

    /**
     * @param $extra
     */
    public static function makeWritable($extra)
    {
        if (isset($extra['writable'])) {
            foreach ($extra['writable'] as $path) {
                echo "chmod('$path', 0777)...";
                if (is_dir($path) || is_file($path)) {
                    chmod($path, 0777);
                    echo "done.\n";
                } else {
                    echo "file not found.\n";
                }
            }
        }
    }
} 
