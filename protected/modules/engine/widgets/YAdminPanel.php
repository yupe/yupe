<?php
/**
 * Виджет админ-панели для фронтсайда:
 *
 * @category YupeWidget
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://engine.ru
 *
 **/
class YAdminPanel extends YWidget
{
    public function init()
    {
        if (!isset($this->controller->yupe->bootstrap))
            $this->controller->yupe->getComponent('bootstrap');

        parent::init();
    }

    /**
     * Запуск виджета
     *
     * @return void
     **/
    public function run()
    {
        if (Yii::app()->user->isSuperUser()) {
            $mainAssets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.engine.views.assets'));
            
            Yii::app()->clientScript->registerCssFile($mainAssets . '/css/frontpanel.css');
            Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/main.js');

            Yii::app()->clientScript->registerScript(
                'yupeToken', 'var actionToken = ' . json_encode(
                    array(
                        'token'      => Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken,
                        'url'        => Yii::app()->createAbsoluteUrl('engine/backend/modulestatus'),
                        'message'    => Yii::t('YupeModule.engine', 'Подождите, идёт обработка вашего запроса...'),
                        'error'      => Yii::t('YupeModule.engine', 'Во время обработки вашего запроса произошла неизвестная ошибка =('),
                        'loadingimg' => CHtml::image(
                            $mainAssets . '/img/progressbar.gif', '', array(
                                'style' => 'width: 100%; height: 20px;',
                            )
                        ),
                        'buttons'    => array(
                            'yes'    => Yii::t('YupeModule.engine', 'Да'),
                            'no'     => Yii::t('YupeModule.engine', 'Отмена'),
                        ),
                        'messages'   => array(
                            'confirm_update'           => Yii::t('YupeModule.engine', 'Вы уверены, что хотите обновить файл конфигурации?'),
                            'confirm_deactivate'       => Yii::t('YupeModule.engine', 'Вы уверены, что хотите отключить модуль?'),
                            'confirm_activate'         => Yii::t('YupeModule.engine', 'Вы уверены, что хотите включить модуль?'),
                            'confirm_uninstall'        => Yii::t('YupeModule.engine', 'Вы уверены, что хотите удалить модуль?') . '<br />' . Yii::t('YupeModule.engine', 'Все данные модуля буду удалены.'),
                            'confirm_install'          => Yii::t('YupeModule.engine', 'Вы уверены, что хотите установить модуль?') . '<br />' . Yii::t('YupeModule.engine', 'Будут добавлены новые данные для работы модуля.'),
                            'confirm_cacheFlush'       => Yii::t('YupeModule.engine', 'Вы уверены, что хотите удалить весь кеш?'),
                            'confirm_assetsFlush'      => Yii::t('YupeModule.engine', 'Вы уверены, что хотите удалить все ресурсы (assets)?'),
                            'confirm_cacheAssetsFlush' => Yii::t('YupeModule.engine', 'Вы уверены, что хотите удалить весь кеш и все ресурсы (assets)?') . '<br />' . Yii::t('YupeModule.engine', 'Стоит учесть, что это трудоёмкий процесс и может занять некоторое время!'),
                            'unknown'                  => Yii::t('YupeModule.engine', 'Выбрано неизвестное действие!'),
                        )
                    )
                ), CClientScript::POS_BEGIN
            );
            $cached = Yii::app()->cache->get(
                'YAdminPanel' . (
                    Yii::app()->controller instanceof YBackController
                    ? 'backend'
                    : 'frontend'
                )
            );

            if ($cached === false) {
                $cached = $this->render('application.modules.engine.views.widgets.YAdminPanel.adminpanel', array(), true);
                
                Yii::app()->cache->set(
                    'YAdminPanel' . (
                        Yii::app()->controller instanceof YBackController
                        ? 'backend'
                        : 'frontend'
                    ), $cached, 0, new TagsCache('engine', 'YAdminPanel', 'installedModules')
                );
            }

            echo $cached;
        }
    }
}