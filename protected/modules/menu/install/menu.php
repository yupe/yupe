<?php
/**
 * Файл конфигурации модуля
 *
 * @category YupeMigration
 * @package  yupe.modules.menu.install
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     https://yupe.ru
 **/
return [
    'module'    => [
        'class' => 'application.modules.menu.MenuModule',
    ],
    'import'    => [
        'application.modules.page.models.Page'
    ],
    'component' => [
        'menu' => [
            'class' => 'application.modules.menu.components.MenuComponent',
            'modules' => [
                'page' => [
                    'entities' => [
                        'page' => [
                            'label' => 'Страницы',
                            'model' => 'application.modules.page.models.Page',
                            'modelAttributeName' => 'title',
                            'url' => [
                                'route' => '/page/page/view',
                                'params' => [
                                    'slug' => 'slug'
                                ]
                            ]
                        ],
                    ]
                ],
                'store' => [
                    'entities' => [
                        'category' => [
                            'label' => 'Категории магазина',
                            'model' => 'application.modules.store.models.StoreCategory',
                            'modelAttributeName' => 'name',
                            'url' => [
                                'route' => '/store/category/view',
                                'params' => [
                                    'path' => 'slug'
                                ]
                            ]
                        ]
                    ]
                ],
                'news' => [
                    'entities' => [
                        'category' => [
                            'label' => 'Категории новостей',
                            'model' => 'application.modules.category.models.Category',
                            'modelAttributeName' => 'name',
                            'url' => [
                                'route' => '/news/newsCategory/view',
                                'params' => [
                                    'slug' => 'slug'
                                ]
                            ]
                        ],
                        'news' => [
                            'label' => 'Новости',
                            'model' => 'application.modules.news.models.News',
                            'modelAttributeName' => 'title',
                            'url' => [
                                'route' => 'news/news/view',
                                'params' => [
                                    'slug' => 'slug'
                                ]
                            ]
                        ],
                    ]
                ]
            ]
        ]
    ],
    'rules'     => [],
];
