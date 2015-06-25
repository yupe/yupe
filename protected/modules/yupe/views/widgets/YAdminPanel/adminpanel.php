<?php
/**
 * Отображение для виджета YAdminPanel:
 *
 * @category YupeView
 * @package  yupe
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
$mainAssets = Yii::app()->getAssetManager()->publish(
    Yii::getPathOfAlias('application.modules.yupe.views.assets')
);
$this->widget(
    'bootstrap.widgets.TbNavbar',
    [
        'fluid'    => true,
        'fixed'    => 'top',
        'brand'    => CHtml::image(
            $mainAssets . '/img/logo.png',
            CHtml::encode(Yii::app()->name),
            [
                'width'  => '38',
                'height' => '38',
                'title'  => CHtml::encode(Yii::app()->name),
            ]
        ),
        'brandUrl' => CHtml::normalizeUrl(["/yupe/backend/index"]),
        'items'    => [
            [
                'class' => 'bootstrap.widgets.TbMenu',
                'type'  => 'navbar',
                'htmlOptions' => ['class' => 'visible-xs hidden-sm visible-md visible-lg'],
                'items' => $modules
            ],
            [
                'class' => 'bootstrap.widgets.TbMenu',
                'type'  => 'navbar',
                'htmlOptions' => ['class' => 'hidden-xs visible-sm hidden-md'],
                'items' => $modulesMobile
            ],
            [
                'class'       => 'bootstrap.widgets.TbMenu',
                'htmlOptions' => ['class' => 'navbar-right'],
                'type'        => 'navbar',
                'encodeLabel' => false,
                'items'       => $navbarRight,
            ],
        ],
    ]
);?>

<script type="text/javascript">
    $(document).ready(function () {
        var url = window.location.href;
        $('.navbar .nav li').removeClass('active');
        $('.nav a').filter(function () {
            return this.getAttribute("href") != '#' && this.href == url;
        }).parents('li').addClass('active');
    });
</script>
