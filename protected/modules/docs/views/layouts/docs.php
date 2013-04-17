<?php
/**
 * Отображение для layouts/docs:
 * 
 *   @category YupeLayout
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CHtml::encode(Yii::app()->name); ?> <?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php
    $docsAssets = Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('application.modules.docs.views.assets')
    );
    $mainAssets = Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('application.modules.yupe.views.assets')
    );
    Yii::app()->clientScript->registerCssFile($mainAssets . '/css/styles.css');
    Yii::app()->clientScript->registerCssFile($docsAssets . '/css/main.css');
    if (($langs = Yii::app()->getModule('yupe')->languageSelectorArray) != array())
        Yii::app()->clientScript->registerCssFile($mainAssets. '/css/flags.css');
    ?>
</head>
<body>
    <div id="overall-wrap">
        <!-- mainmenu -->
        <?php
        $this->widget(
            'bootstrap.widgets.TbNavbar', array(
                'htmlOptions' => array('class' => 'navbar-inverse'),
                'fluid'       => true,
                'brand'       => CHtml::image(
                    Yii::app()->getModule('yupe')->themeBaseUrl . "/web/images/logo.png", Yii::t('DocsModule.docs', 'Юпи! Документация'), array(
                        'width'  => '38',
                        'height' => '38',
                        'title'  => Yii::t('DocsModule.docs', 'Юпи! Документация'),
                    )
                ),
                'brandUrl'    => CHtml::normalizeUrl(array("index")),
                'items'       => array(
                    array(
                        'class' => 'bootstrap.widgets.TbMenu',
                        'items' => Yii::app()->getModule('docs')->articles,
                    ),
                    array(
                        'class'       => 'bootstrap.widgets.TbMenu',
                        'htmlOptions' => array('class' => 'pull-right'),
                        'encodeLabel' => false,
                        'items'       => array_merge(
                            array(
                                array(
                                    'icon'        => 'home white',
                                    'label'       => Yii::t('YupeModule.yupe', 'На сайт'),
                                    'linkOptions' => array('target' => '_blank'),
                                    'url'         => array('/' . Yii::app()->defaultController . '/index/'),
                                ),
                            ), Yii::app()->getModule('yupe')->languageSelectorArray
                        ),
                    ),
                ),
            )
        );
        ?>
        <!-- /mainmenu -->
        <!-- content -->
        <div class="container-fluid" id="page">
            <?php echo $content; ?>
        </div>
        <!-- /content -->
    </div>
    <footer>
        Copyright &copy; 2009-<?php echo date('Y'); ?>
        <a href='<?php echo Yii::app()->getModule('yupe')->brandUrl; ?>'>
            <?php echo CHtml::encode(Yii::app()->name); ?>
        </a> 
        <small class="label label-info"><?php echo Yii::app()->getModule('yupe')->getVersion(); ?></small>
        <br/>
        <a href="http://yupe.ru/feedback/contact?from=engine">
            <?php echo Yii::t('YupeModule.yupe', 'Разработка и поддержка'); ?></a> - <a href="mailto:team@yupe.ru">yupe team
        </a>
        <br/>
        <?php echo Yii::powered(); ?>
        <?php $this->widget('YPerformanceStatistic'); ?>
    </footer>
</body>
</html>