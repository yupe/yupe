<?php
/**
 * Виджет админ-панели для фронтальной части сайта
 *
 * @category YupeWidget
 * @package  yupe.modules.yupe.widgets
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/

namespace yupe\widgets;
use Yii;
use CHtml;
use CClientScript;
use TagsCache;

class YAdminPanel extends YWidget
{
    public $view = 'application.modules.yupe.views.widgets.YAdminPanel.adminpanel';

    public function init()
    {
        if (!isset($this->controller->yupe->bootstrap)) {
            $this->controller->yupe->getComponent('bootstrap');
        }

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
            $mainAssets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.yupe.views.assets'));
            
            Yii::app()->clientScript->registerCssFile($mainAssets . '/css/frontpanel.css');
            Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/main.js');

            Yii::app()->clientScript->registerScript(
                'yupeToken', 'var actionToken = ' . json_encode(
                    array(
                        'token'      => Yii::app()->getRequest()->csrfTokenName . '=' . Yii::app()->getRequest()->csrfToken,
                        'url'        => Yii::app()->createAbsoluteUrl('yupe/backend/modulestatus'),
                        'message'    => Yii::t('YupeModule.yupe', 'Wait please, your request in process...'),
                        'error'      => Yii::t('YupeModule.yupe', 'During the processing of your request an unknown error occurred =('),
                        'loadingimg' => CHtml::image(
                            $mainAssets . '/img/progressbar.gif', '', array(
                                'style' => 'width: 100%; height: 20px;',
                            )
                        ),
                        'buttons'    => array(
                            'yes'    => Yii::t('YupeModule.yupe', 'Ok'),
                            'no'     => Yii::t('YupeModule.yupe', 'Cancel'),
                        ),
                        'messages'   => array(
                            'confirm_update'           => Yii::t('YupeModule.yupe', 'Do you really want to update configuration file?'),
                            'confirm_deactivate'       => Yii::t('YupeModule.yupe', 'Do you really want to disable module?'),
                            'confirm_activate'         => Yii::t('YupeModule.yupe', 'Do you really want to enable module?'),
                            'confirm_uninstall'        => Yii::t('YupeModule.yupe', 'Do you really want to delete module?') . '<br />' . Yii::t('YupeModule.yupe', 'All module parameters will be deleted'),
                            'confirm_install'          => Yii::t('YupeModule.yupe', 'Do you really want to install module?') . '<br />' . Yii::t('YupeModule.yupe', 'New module parameters will be added'),
                            'confirm_cacheFlush'       => Yii::t('YupeModule.yupe', 'Do you really want to clean cache?'),
                            'confirm_assetsFlush'      => Yii::t('YupeModule.yupe', 'Do you really want to clean assets?'),
                            'confirm_cacheAssetsFlush' => Yii::t('YupeModule.yupe', 'Do you really want to clean cache and assets?') . '<br />' . Yii::t('YupeModule.yupe', 'This process can take much time!'),
                            'unknown'                  => Yii::t('YupeModule.yupe', 'Unknown action was selected!'),
                        )
                    )
                ), CClientScript::POS_BEGIN
            );

            $cached = Yii::app()->cache->get(
                'YAdminPanel::' . Yii::app()->user->getId() . (
                    Yii::app()->controller instanceof yupe\components\controllers\BackController
                    ? 'backend'
                    : 'frontend'
                ) . '::' . Yii::app()->language
            );

            if ($cached === false) {
                $cached = $this->render($this->view, array(), true);
                Yii::app()->cache->set(
                    'YAdminPanel::' . Yii::app()->user->getId() . (
                        Yii::app()->controller instanceof yupe\components\controllers\BackController
                        ? 'backend'
                        : 'frontend'
                    ) . '::' . Yii::app()->language, $cached, 0, new TagsCache('yupe', 'YAdminPanel', 'installedModules')
                );
            }

            echo $cached;
        }
    }
}