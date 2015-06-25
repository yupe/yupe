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
    public $view = 'adminpanel';

    public function run()
    {
        $cacheKey = 'YAdminPanel::' . Yii::app()->getUser()->getId() . '::' . Yii::app()->getLanguage();

        $cached = Yii::app()->getCache()->get($cacheKey);

        $modules = $modulesMobile = Yii::app()->moduleManager->getModules(true);
        foreach($modulesMobile as &$item){
            $item['linkOptions'] = ['title'=>$item['label']];
            $item['label'] = '';
        }

        if (false === $cached) {
            $cached = $this->render(
                $this->view,
                [
                    'modules' => $modules,
                    'modulesMobile' => $modulesMobile,
                    'navbarRight' => $this->getNavbarRight(),
                ],
                true
            );
            Yii::app()->getCache()->set(
                $cacheKey,
                $cached,
                0,
                new TagsCache('yupe', 'YAdminPanel', 'installedModules')
            );
        }

        echo $cached;
    }

    private function getNavbarRight()
    {
        return array_merge(
            [
                [
                    'icon'  => 'fa fa-fw fa-question-circle',
                    'label' => Yii::t('YupeModule.yupe', 'Help'),
                    'url'   => CHtml::normalizeUrl(['/yupe/backend/help']),
                    'items' => [
                        [
                            'icon'        => 'fa fa-fw fa-globe',
                            'label'       => Yii::t('YupeModule.yupe', 'Official site'),
                            'url'         => 'http://yupe.ru?from=help',
                            'linkOptions' => ['target' => '_blank'],
                        ],
                        [
                            'icon'        => 'fa fa-fw fa-book',
                            'label'       => Yii::t('YupeModule.yupe', 'Official docs'),
                            'url'         => 'http://yupe.ru/docs/index.html?from=help',
                            'linkOptions' => ['target' => '_blank'],
                        ],
                        [
                            'icon'        => 'fa fa-fw fa-th-large',
                            'label'       => Yii::t('YupeModule.yupe', 'Additional modules'),
                            'url'         => 'https://github.com/yupe/yupe-ext',
                            'linkOptions' => ['target' => '_blank'],
                        ],
                        [
                            'icon'        => 'fa fa-fw fa-comment',
                            'label'       => Yii::t('YupeModule.yupe', 'Forum'),
                            'url'         => 'http://yupe.ru/talk/?from=help',
                            'linkOptions' => ['target' => '_blank'],
                        ],
                        [
                            'icon'        => 'fa fa-fw fa-comment',
                            'label'       => Yii::t('YupeModule.yupe', 'Chat'),
                            'url'         => 'http://gitter.im/yupe/yupe',
                            'linkOptions' => ['target' => '_blank'],
                        ],
                        [
                            'icon'        => 'fa fa-fw fa-globe',
                            'label'       => Yii::t('YupeModule.yupe', 'Community on github'),
                            'url'         => 'https://github.com/yupe/yupe',
                            'linkOptions' => ['target' => '_blank'],
                        ],
                        [
                            'icon'        => 'fa fa-fw fa-thumbs-up',
                            'label'       => Yii::t('YupeModule.yupe', 'Order development and support'),
                            'url'         => 'http://amylabs.ru/contact?from=help-support',
                            'linkOptions' => ['target' => '_blank'],
                        ],
                        [
                            'icon'        => 'fa fa-fw fa-warning',
                            'label'       => Yii::t('YupeModule.yupe', 'Report a bug'),
                            'url'         => 'http://yupe.ru/contacts?from=panel',
                            'linkOptions' => ['target' => '_blank'],
                        ],
                        [
                            'icon'  => 'fa fa-fw fa-question-circle',
                            'label' => Yii::t('YupeModule.yupe', 'About Yupe!'),
                            'url'   => ['/yupe/backend/help'],
                        ],
                    ]
                ],
                [
                    'icon'  => 'fa fa-fw fa-home',
                    'label' => Yii::t('YupeModule.yupe', 'Go home'),
                    'url'   => Yii::app()->createAbsoluteUrl('/')
                ],
                [
                    'icon'  => 'fa fa-fw fa-user',
                    'label' => '<span class="label label-info">' . CHtml::encode(
                            Yii::app()->getUser()->getProfileField('fullName')
                        ) . '</span>',
                    'items' => [
                        [
                            'icon'  => 'fa fa-fw fa-cog',
                            'label' => Yii::t('YupeModule.yupe', 'Profile'),
                            'url'   => CHtml::normalizeUrl(
                                (['/user/userBackend/update', 'id' => Yii::app()->getUser()->getId()])
                            ),
                        ],
                        [
                            'icon'  => 'fa fa-fw fa-power-off',
                            'label' => Yii::t('YupeModule.yupe', 'Exit'),
                            'url'   => CHtml::normalizeUrl(['/user/account/logout']),
                        ],
                    ],
                ],
            ],
            $this->getController()->yupe->getLanguageSelectorArray()
        );
    }
}
