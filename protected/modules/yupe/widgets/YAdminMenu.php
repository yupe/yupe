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

class YAdminMenu extends YWidget
{
    public $view = 'adminmenu';

    public function run()
    {
        $cacheKey = 'YAdminMenu::' . Yii::app()->getUser()->getId() . '::' . Yii::app()->getLanguage();

        $cached = Yii::app()->getCache()->get($cacheKey);

        /*$modules = [
            [
                'label' => 'Blogs',
                'items' => [
                    [
                        'icon'  => 'fa fa-fw fa-list-alt',
                        'label' => 'Manage blogs',
                        'url'   => ['/blog/blogBackend/index']
                    ],
                    [
                        'icon'  => 'fa fa-fw fa-plus-square',
                        'label' => 'Add a blog',
                        'url'   => ['/blog/blogBackend/create']
                    ],
                ]
            ],
            [
                'label' => 'Posts',
                'items' => [
                    [
                        'icon'  => 'fa fa-fw fa-list-alt',
                        'label' => 'Manage posts',
                        'url'   => ['/blog/postBackend/index']
                    ],
                    [
                        'icon'  => 'fa fa-fw fa-plus-square',
                        'label' => 'Add a post',
                        'url'   => ['/blog/postBackend/create']
                    ],
                ]
            ],
            [
                'label' => 'Members',
                'items' => [
                    [
                        'icon'  => 'fa fa-fw fa-list-alt',
                        'label' => 'Manage members',
                        'url'   => ['/blog/userToBlogBackend/index']
                    ],
                    [
                        'icon'  => 'fa fa-fw fa-plus-square',
                        'label' => 'Add a member',
                        'url'   => ['/blog/userToBlogBackend/create']
                    ],
                ]
            ],
        ];*/

        $modules = Yii::app()->moduleManager->getModules(true);
        /*echo "<pre>";
        print_r($modules);
        echo "</pre>";
        die();*/

        //if (false === $cached) {

            //$modules = Yii::app()->moduleManager->getModules(true);
            $cached = $this->render(
                $this->view,
                [
                    'modules' => $modules,
                ],
                true
            );
            Yii::app()->getCache()->set(
                $cacheKey,
                $cached,
                0,
                new TagsCache('yupe', 'YAdminMenu', 'installedModules')
            );
        //}

        echo $cached;
    }
}
