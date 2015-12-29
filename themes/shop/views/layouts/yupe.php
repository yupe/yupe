<!DOCTYPE html>
<html lang="<?= Yii::app()->getLanguage(); ?>">

<head>
    <?php
    \yupe\components\TemplateEvent::fire(ShopThemeEvents::HEAD_START);

    Yii::app()->getController()->widget(
        'vendor.chemezov.yii-seo.widgets.SeoHead',
        [
            'httpEquivs' => [
                'Content-Type' => 'text/html; charset=utf-8',
                'X-UA-Compatible' => 'IE=edge,chrome=1',
                'Content-Language' => 'ru-RU',
                'viewport' => 'width=1200',
                'imagetoolbar' => 'no',
                'msthemecompatible' => 'no',
                'cleartype' => 'on',
                'HandheldFriendly' => 'True',
                'format-detection' => 'telephone=no',
                'format-detection' => 'address=no',
                'apple-mobile-web-app-capable' => 'yes',
                'apple-mobile-web-app-status-bar-style' => 'black-translucent',
            ],
            'defaultTitle' => $this->yupe->siteName,
            'defaultDescription' => $this->yupe->siteDescription,
            'defaultKeywords' => $this->yupe->siteKeyWords,
        ]
    );

    Yii::app()->getClientScript()->registerCssFile($this->mainAssets . '/styles/slick.css');
    Yii::app()->getClientScript()->registerCssFile($this->mainAssets . '/libs/select2/select2.css');
    Yii::app()->getClientScript()->registerCssFile($this->mainAssets . '/styles/common.css');
    Yii::app()->getClientScript()->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css');

    Yii::app()->getClientScript()->registerCoreScript('jquery');
    Yii::app()->getClientScript()->registerScriptFile($this->mainAssets . '/js/index.js', CClientScript::POS_END);
    Yii::app()->getClientScript()->registerScriptFile($this->mainAssets . '/js/jquery.collapse.js', CClientScript::POS_END);
    Yii::app()->getClientScript()->registerScriptFile($this->mainAssets . '/js/jquery.collapse_storage.js', CClientScript::POS_END);
    Yii::app()->getClientScript()->registerScriptFile($this->mainAssets . '/js/jquery.fancybox.js', CClientScript::POS_END);
    Yii::app()->getClientScript()->registerScriptFile($this->mainAssets . '/js/overlay.js', CClientScript::POS_END);
    Yii::app()->getClientScript()->registerScriptFile($this->mainAssets . '/js/product-gallery.js', CClientScript::POS_END);
    Yii::app()->getClientScript()->registerScriptFile($this->mainAssets . '/js/slick.js', CClientScript::POS_END);
    Yii::app()->getClientScript()->registerScriptFile($this->mainAssets . '/js/slick.min.js', CClientScript::POS_END);
    Yii::app()->getClientScript()->registerScriptFile($this->mainAssets . '/js/tabs.js', CClientScript::POS_END);
    Yii::app()->getClientScript()->registerScriptFile($this->mainAssets . '/js/toggle.js', CClientScript::POS_END);
    Yii::app()->getClientScript()->registerScriptFile($this->mainAssets . '/libs/select2/select2.min.js', CClientScript::POS_END);
    Yii::app()->getClientScript()->registerScriptFile($this->mainAssets . '/js/store.js', CClientScript::POS_END);
    ?>
    <script type="text/javascript">
        var yupeTokenName = '<?= Yii::app()->getRequest()->csrfTokenName;?>';
        var yupeToken = '<?= Yii::app()->getRequest()->getCsrfToken();?>';
        var yupeCartDeleteProductUrl = '<?= Yii::app()->createUrl('/cart/cart/delete/')?>';
        var yupeCartUpdateUrl = '<?= Yii::app()->createUrl('/cart/cart/update/')?>';
        var yupeCartWidgetUrl = '<?= Yii::app()->createUrl('/cart/cart/widget/')?>';
    </script>
    <?php \yupe\components\TemplateEvent::fire(ShopThemeEvents::HEAD_END);?>
</head>

<body>
<?php \yupe\components\TemplateEvent::fire(ShopThemeEvents::BODY_START);?>
<div class="main">
    <div class="main__navbar">
        <div class="navbar">
            <div class="navbar__wrapper grid">
                <div class="navbar__menu">
                    <?php if (Yii::app()->hasModule('menu')): ?>
                        <?php $this->widget('application.modules.menu.widgets.MenuWidget', ['name' => 'top-menu']); ?>
                    <?php endif; ?>
                </div>
                <div class="navbar__personal">
                    <div class="navbar__toolbar">
                        <?php if(Yii::app()->hasModule('favorite')):?>
                            <a href="<?= Yii::app()->createUrl('/favorite/default/index');?>" class="toolbar-button"><span class="toolbar-button__label"><i class="fa fa-heart-o fa-lg fa-fw"></i> Избранное</span><span class="badge badge_light-blue" id="yupe-store-favorite-total"><?= Yii::app()->favorite->count();?></span></a>
                        <?php endif;?>
                        <?php if(Yii::app()->hasModule('compare')):?>
                            <a href="javascript:void(0);" class="toolbar-button"><span class="toolbar-button__label"><i class="fa fa-balance-scale fa-lg fa-fw"></i> Сравнение</span><span class="badge badge_light-blue">0</span></a>
                        <?php endif;?>
                    </div>
                    <div class="navbar__user">
                        <?php if (Yii::app()->getUser()->isGuest): ?>
                            <a href="<?= Yii::app()->createUrl('/user/account/login') ?>" class="btn btn_login-button">
                                <?= Yii::t('UserModule.user', 'Login'); ?>
                            </a>
                        <?php else: ?>
                            <div class="toolbar-button toolbar-button_dropdown">
                                <span class="toolbar-button__label">
                                    <i class="fa fa-user fa-lg fa-fw"></i> Личный кабинет
                                </span>
                                <span class="badge badge_light-blue"></span>

                               <div class="dropdown-menu">
                                   <div class="dropdown-menu__header"><?= Yii::app()->getUser()->getProfile()->getFullName() ?></div>
                                   <div class="dropdown-menu__item">
                                       <div class="dropdown-menu__link">
                                           <a href="<?= Yii::app()->createUrl('/order/user/index') ?>">Мои заказы</a>
                                       </div>
                                   </div>
                                   <div class="dropdown-menu__item">
                                       <div class="dropdown-menu__link">
                                           <a href="<?= Yii::app()->createUrl('/user/profile/profile') ?>">
                                               <?= Yii::t('UserModule.user', 'My profile') ?>
                                           </a>
                                       </div>
                                   </div>
                                   <div class="dropdown-menu__separator"></div>
                                   <div class="dropdown-menu__item">
                                       <div class="dropdown-menu__link dropdown-menu__link_exit">
                                           <a href="<?= Yii::app()->createUrl('/user/account/logout') ?>">
                                               <?= Yii::t('UserModule.user', 'Logout'); ?>
                                           </a>
                                       </div>
                                   </div>
                               </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main__header">
        <div class="header grid">
            <div class="header__item header-logo">
                <a href="<?= Yii::app()->createUrl(Yii::app()->hasModule('homepage') ? '/homepage/hp/index' : '/site/index') ?>" class="header__logo-link">
                    <img src="<?= $this->mainAssets ?>/images/logo.png" class="header-logo-image">
                </a>
            </div>
            <div class="header__item header-description"><?= CHtml::encode(Yii::app()->getModule('yupe')->siteName);?></div>
            <div class="header__item header-phone">
                <div class="header__phone"><?= CHtml::encode(Yii::app()->getModule('store')->phone);?></div>
                <?php if (Yii::app()->hasModule('callback')): ?>
                    <?php $this->widget('application.modules.callback.widgets.CallbackWidget'); ?>
                <?php endif; ?>
            </div>
            <?php if (Yii::app()->hasModule('cart')): ?>
                <div id="shopping-cart-widget">
                    <?php $this->widget('application.modules.cart.widgets.ShoppingCartWidget'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="main__search grid">
        <div class="search-bar">
            <div class="search-bar__wrapper"><a href="javascript:void(0);" data-toggle="#menu-catalog" class="search-bar__catalog-button">Каталог товаров</a>
                <?php $this->widget('application.modules.store.widgets.SearchProductWidget'); ?>
            </div>
            <?php if($this->beginCache('store::category::menu', ['duration' => $this->yupe->coreCacheTime])):?>
                <?php $this->widget('application.modules.store.widgets.CategoryWidget', ['depth' => 2]); ?>
                <?php $this->endCache();?>
            <?php endif;?>
        </div>
    </div>
    <div class="main__breadcrumbs grid">
        <div class="breadcrumbs">
            <?php $this->widget(
                'zii.widgets.CBreadcrumbs',
                [
                    'links' => $this->breadcrumbs,
                    'tagName' => 'ul',
                    'separator' => '',
                    'homeLink' => '<li><a href="/">' . Yii::t('Yii.zii', 'Home') . '</a>',
                    'activeLinkTemplate' => '<li><a href="{url}">{label}</a>',
                    'inactiveLinkTemplate' => '<li><a>{label}</a>',
                    'htmlOptions' => []
                ]
            );?>
        </div>
    </div>
    <?= $content ?>
    <div class="main__footer">
        <div class="footer">
            <div class="grid">
                <div class="footer__wrap">
                    <div class="footer__group">
                        <div class="footer__item">&copy; Yupe! <?= date('Y') ?></div>
                        <div class="footer__item footer__item_mute">Все права защищены.</div>
                    </div>
                    <div class="footer__group">
                        <?php if (Yii::app()->hasModule('menu')): ?>
                            <?php $this->widget('application.modules.menu.widgets.MenuWidget', [
                                'name' => 'top-menu',
                                'layout' => 'footer'
                            ]); ?>
                        <?php endif; ?>
                    </div>
                    <div class="footer__group">
                        <?php if($this->beginCache('store::category::footer', ['duration' => $this->yupe->coreCacheTime])):?>
                        <?php $this->widget('application.modules.store.widgets.CategoryWidget', [
                            'depth' => 0,
                            'view' => 'footer'
                        ]); ?>

                            <?php $this->endCache();?>
                        <?php endif;?>
                    </div>
                    <div class="footer__group">
                        <div class="footer__item footer__item_header">Контакты</div>
                        <div class="footer__item"><i class="fa fa-phone fa-fw"></i> <?= CHtml::encode(Yii::app()->getModule('store')->phone);?></div>
                        <div class="footer__item"><i class="fa fa-envelope fa-fw"></i> E-mail: <?= CHtml::encode(Yii::app()->getModule('store')->email);?></div>
                    </div>
                    <div class="footer__group">
                        <div class="footer__item footer__item_header">Работаем</div>
                        <div class="footer__item">Пн–Пт 09:00–20:00</div>
                        <div class="footer__item">Сб 09:00–17:00</div>
                        <div class="footer__item">Вс выходной</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php \yupe\components\TemplateEvent::fire(ShopThemeEvents::BODY_END);?>
<div class='notifications top-right' id="notifications"></div>
</body>
</html>