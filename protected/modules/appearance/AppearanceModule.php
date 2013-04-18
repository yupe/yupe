<?php
/**
 * Class AppearanceModule
 *
 * @author Alexander Bolshakov <a.bolshakov.coder@gmail.com>
 */
class AppearanceModule extends YWebModule
{
    protected static $_themeSettings;

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getIsNoDisable()
    {
        return true;
    }

    public function getName()
    {
        return Yii::t('AppearanceModule.messages', 'Внешний вид');
    }

    public function getDescription()
    {
        return Yii::t('AppearanceModule.messages', 'Управляйте настройками тем оформления');
    }

    public function getAdminPageLink()
    {
        return '/appearance/theme/list';
    }

    public function getVersion()
    {
        return '0.1';
    }

    public function getAuthor()
    {
        return 'Alexander Bolshakov';
    }

    public function getAuthorEmail()
    {
        return 'a.bolshakov.coder@gmail.com';
    }

    public function getIcon()
    {
        return 'eye-open';
    }

    public function getUrl()
    {
        return 'https://github.com/alphard-code';
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('AppearanceModule.messages', 'Темы оформления')),
            array(
                'icon'  => 'list-alt',
                'label' => Yii::t('AppearanceModule.messages', 'Сменить тему'),
                'url'   => array('/appearance/theme/list')
            ),
            // @TODO installation
//            array(
//                'icon'  => 'plus',
//                'label' => Yii::t('AppearanceModule.messages', 'Установить'),
//                'url'   => array('/appearance/theme/install')
//            ),
        );
    }

    /**
     * Shortcut method.
     *
     * @return AppearanceModule
     */
    public static function get()
    {
        return Yii::app()->getModule('appearance');
    }


    /**
     * @param YTheme $theme   Instance of theme to check
     * @param bool   $refresh Whether to refresh cached result
     *
     * @return bool Whether theme is enabled for its environment - frontend or backend.
     */
    public function getIsThemeEnabled(YTheme $theme, $refresh = false)
    {
        if ($refresh || self::$_themeSettings == null) {
            self::$_themeSettings = Settings::model()->fetchModuleSettings(
                'yupe',
                array('theme', 'backendTheme'),
                false
            );
        }

        if ($theme->getIsBackend()) {
            return (
                isset(self::$_themeSettings['backendTheme'])
                    && (self::$_themeSettings['backendTheme']->param_value == $theme->getName())
            );
        } else {
            return (
                isset(self::$_themeSettings['theme'])
                    && (self::$_themeSettings['theme']->param_value == $theme->getName())
            );
        }
    }

    /**
     * Enables theme for its environment - frontend or backend.
     *
     * @param YTheme $theme Instance of theme to enable.
     *
     * @return bool Whether saving was successful.
     */
    public function toggleTheme(YTheme $theme)
    {
        return $this->saveModuleSettings(
            'yupe',
            array(
                ($theme->getIsBackend() ? 'backendTheme' : 'theme') => $theme->getName()
            )
        );
    }


    /**
     * Метода сохранения настроек модуля:
     *
     * @param string $moduleID - идетификтор модуля
     * @param array  $params   - массив настроек, paramName => paramValue
     *
     * @return bool
     **/
    public function saveModuleSettings($moduleID, $params)
    {
        $settings = Settings::model()->fetchModuleSettings($moduleID, array_keys($params), false);

        foreach ($params as $paramName => $paramValue) {
            // Если параметр уже был - обновим, иначе надо создать новый
            if (isset($settings[$paramName])) {
                // Если действительно изменили настройку
                if ($settings[$paramName]->param_value != $paramValue) {
                    $settings[$paramName]->param_value = $paramValue;
                    if ($settings[$paramName]->save()) {
                        return true;
                    }
                }
            } else {
                $settings[$paramName] = new Settings;

                $settings[$paramName]->setAttributes(
                    array(
                        'module_id'   => $moduleID,
                        'param_name'  => $paramName,
                        'param_value' => $paramValue,
                    )
                );

                if ($settings[$paramName]->save()) {
                    return true;
                }
            }
        }
        return false;
    }
}