<?php

class YupeCommand extends \yupe\components\ConsoleCommand
{
    /**
     * Команда для обновления конфигов модулей.
     *
     * Examples:
     *
     * yiic yupe updateConfig
     * yiic yupe updateConfig --modules=yupe
     * yiic yupe updateConfig --modules=yupe,comment,blog
     * yiic yupe updateConfig --modules=yupe --interactive=0
     *
     * @param string|null $modules Module name to update or module names separated by comma.
     * @param bool $interactive Ask before update?
     *
     * @return bool
     */
    public function actionUpdateConfig($modules = null, $interactive = true)
    {
        $filter = $modules === null ? null : array_map('trim', explode(',', $modules));

        $modules = [];

        foreach (Yii::app()->getModules() as $key => $value) {
            $module = Yii::app()->getModule($key);
            if (!empty($module) && $module->isConfigNeedUpdate() && ($filter === null || in_array(
                        $module->getId(),
                        $filter
                    ))
            ) {
                $modules[$key] = $module;
            }
        }

        if (empty($modules)) {
            $this->log("There is no modules to update config.");

            return true;
        } else {
            $this->log(
                'The following modules have update for config files: ' . implode(',', array_keys($modules)) . '.'
            );

            if ($interactive) {
                if (!$this->confirm("Are you sure you want to do this?")) {
                    $this->log("ABORTING!");

                    return true;
                }
            }

            echo "\n";

            foreach ($modules as $key => $value) {
                $this->log('Change module "' . $key . '"');

                $result = Yii::app()->moduleManager->updateModuleConfig($value);

                if ($result) {
                    $this->log('Module "' . $key . '" successfully updated!');
                } else {
                    $this->log('An error occurred while updating the module "' . $key . '"', CLogger::LEVEL_ERROR);

                    return false;
                }
            }

            return true;
        }
    }

    /**
     * Команда для применения миграции модулей.
     *
     * Examples:
     *
     * yiic yupe updateMigrations
     * yiic yupe updateMigrations --modules=yupe
     * yiic yupe updateMigrations --modules=yupe,comment,blog
     * yiic yupe updateMigrations --modules=yupe --interactive=0
     *
     * @param string|null $modules Module(s) name(s)
     * @param bool $interactive
     * @return bool
     */
    public function actionUpdateMigrations($modules = null, $interactive = true)
    {
        $filter = $modules === null ? null : array_map('trim', explode(',', $modules));
        $modules = [];

        foreach (Yii::app()->getModules() as $key => $value) {
            if ($filter === null || in_array($key, $filter)) {
                $module = Yii::app()->getModule($key);
                if (!empty($module) && Yii::app()->migrator->checkForUpdates([$key => $value])) {
                    $modules[$key] = $module;
                }
            }
        }

        if (empty($modules)) {
            $this->log("There is no modules to update migrations.");

            return true;
        } else {
            $this->log('The following modules have new migrations: ' . implode(',', array_keys($modules)) . '.');

            if ($interactive) {
                if (!$this->confirm("Are you sure you want to do this?")) {
                    $this->log("ABORTING!");

                    return true;
                }
            }

            echo "\n";

            foreach ($modules as $key => $value) {
                $this->log('Change module "' . $key . '"');

                $result = Yii::app()->migrator->updateToLatest($key);

                if ($result) {
                    $this->log('Module "' . $key . '" successfully updated!');
                } else {
                    $this->log('An error occurred while updating the module "' . $key . '"', CLogger::LEVEL_ERROR);

                    return false;
                }
            }

            return true;
        }
    }

    /**
     * Команда для обновления конфигов и наката миграций.
     *
     * Examples:
     *
     * yiic yupe update
     * yiic yupe update --modules=comment
     * yiic yupe update --modules=comment,blog,catalog
     * yiic yupe update --modules=comment --interactive=0
     *
     * @param string|null $modules
     * @param bool $interactive
     * @return bool
     */
    public function actionUpdate($modules = null, $interactive = true)
    {
        return $this->actionUpdateConfig($modules, $interactive) & $this->actionUpdateMigrations(
            $modules,
            $interactive
        );
    }

    /**
     * Команда для очистки кэша.
     *
     * Examples:
     *
     * yiic yupe flushCache
     *
     * @return bool
     */
    public function actionFlushCache()
    {
        return Yii::app()->getCache()->flush();
    }

    /**
     * Команда для очистки папки assets.
     *
     * Examples:
     *
     * yiic yupe flushAssets
     *
     * @return bool
     */
    public function actionFlushAssets()
    {
        $dirs = glob(Yii::getPathOfAlias('webroot.assets') . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);

        foreach ($dirs as $value) {
            if (!\yupe\helpers\YFile::rmDir($value)) {
                $this->log('Failed to remove directory "' . $value . '"', CLogger::LEVEL_ERROR);
            }
        }

        return true;
    }

    /**
     * Команда для очистки кэша и assets.
     *
     * Usage:
     *
     * yiic yupe flush
     *
     * @return bool
     */
    public function actionFlush()
    {
        return $this->actionFlushCache() & $this->actionFlushAssets();
    }
}
