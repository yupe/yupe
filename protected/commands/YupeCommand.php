<?php

class YupeCommand extends \yupe\components\ConsoleCommand
{
    /**
     * Команда для обновления конфигов модулей.
     *
     * Examples:
     *
     * yiic yupe update_config
     * yiic yupe update_config --module=yupe
     * yiic yupe update_config --module=yupe,comment,blog
     * yiic yupe update_config --module=yupe --interactive=0
     *
     * @param string|null $module Module name to update or module names separated by comma.
     * @param bool $interactive Ask before update?
     *
     * @return int
     */
    public function actionUpdate_config($module = null, $interactive = true)
    {
        $modules = [];
        $filter = $module === null ? null : array_map('trim', explode(',', $module));

        foreach (Yii::app()->getModules() as $key => $value) {
            $module = Yii::app()->getModule($key);
            if (!empty($module) && $module->isConfigNeedUpdate() && ($filter === null || in_array($module->getId(), $filter))) {
                $modules[$key] = $module;
            }
        }

        if (empty($modules)) {
            $this->log("There is no modules to update.");
            return 0;
        } else {
            $this->log('The following modules have update for config files: ' . implode(',', array_keys($modules)) . '.');

            if ($interactive) {
                if (!$this->confirm("Are you sure you want to do this?")) {
                    $this->log("ABORTING!");
                    exit;
                }
            }

            echo "\n";

            foreach ($modules as $key => $value) {
                $this->log('Update module "' . $key . '"');

                $result = Yii::app()->moduleManager->updateModuleConfig($value);

                if ($result) {
                    $this->log('Module "' . $key . '" successfully updated!');
                } else {
                    $this->log('An error occurred while updating the module "' . $key . '"', CLogger::LEVEL_ERROR);
                    return 1;
                }
            }

            return 0;
        }
    }

    /**
     * Команда для применения миграции модулей.
     *
     * Examples:
     *
     * yiic yupe update_migrations
     * yiic yupe update_migrations --module=yupe
     * yiic yupe update_migrations --module=yupe,comment,blog
     * yiic yupe update_migrations --module=yupe --interactive=0
     *
     * @param string|null $module Module name(s)
     * @param bool $interactive
     * @return int
     */
    public function actionUpdate_migrations($module = null, $interactive = true)
    {
        $modules = [];
        $filter = $module === null ? null : array_map('trim', explode(',', $module));

        foreach (Yii::app()->getModules() as $key => $value) {
            if ($filter === null || in_array($key, $filter)) {
                $module = Yii::app()->getModule($key);
                if (!empty($module) && Yii::app()->migrator->checkForUpdates([$key => $value])) {
                    $modules[$key] = $module;
                }
            }
        }

        if (empty($modules)) {
            $this->log("There is no modules to update.");
            return 0;
        } else {
            $this->log('The following modules have new migrations: ' . implode(',', array_keys($modules)) . '.');

            if ($interactive) {
                if (!$this->confirm("Are you sure you want to do this?")) {
                    $this->log("ABORTING!");
                    exit;
                }
            }

            echo "\n";

            foreach ($modules as $key => $value) {
                $this->log('Update module "' . $key . '"');

                $result = Yii::app()->migrator->updateToLatest($key);

                if ($result) {
                    $this->log('Module "' . $key . '" successfully updated!');
                } else {
                    $this->log('An error occurred while updating the module "' . $key . '"', CLogger::LEVEL_ERROR);
                    return 1;
                }
            }

            return 0;
        }
    }

    /**
     * Команда для обновления конфигов и наката миграций.
     *
     * Examples:
     *
     * yiic yupe update
     * yiic yupe update --module=comment
     * yiic yupe update --module=comment,blog,catalog
     * yiic yupe update --module=comment --interactive=0
     *
     * @param string|null $module
     * @param bool $interactive
     * @return bool
     */
    public function actionUpdate($module = null, $interactive = true)
    {
        return $this->actionUpdate_config($module, $interactive) || $this->actionUpdate_migrations($module, $interactive);
    }
}
