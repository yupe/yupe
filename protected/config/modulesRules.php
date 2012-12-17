<?php
return array(
    // правила аккаунтинга модуля user
    '/login'                                              => 'user/account/login',
    '/logout'                                             => 'user/account/logout',
    '/registration'                                       => 'user/account/registration',
    '/recovery'                                           => 'user/account/recovery',
    '/users'                                              => 'user/people/index',
    '/profile'                                            => 'user/people/profile',
    '/user/<username:\w+>/'                               => 'user/people/userInfo',
    // правила модуля news и page
    '/pages/<slug>'                                       => 'page/page/show',
    '/story/<title>'                                      => 'news/news/show',
    // правила модуля blog
    '/post/<slug>.html'                                   => 'blog/post/show',
    '/posts/tag/<tag>'                                    => 'blog/post/list',
    '/blog/<slug>'                                        => 'blog/blog/show',
    '/blogs'                                              => 'blog/blog/index',
    // правила остальных модулей
    '/wiki/<controller:\w+>/<action:\w+>'                 => 'yeeki/wiki/<controller>/<action>',
    '/feedback/<action:\w+>'                              => 'feedback/contact/<action>',
    '/yupe/backend/modulesettings/<module:\w+>'           => 'yupe/backend/modulesettings',
    '/install'                                            => 'install/default/index',
);