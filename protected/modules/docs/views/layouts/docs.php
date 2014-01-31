<?php
/**
 * Отображение для layouts/docs:
 * 
 *   @category YupeLayout
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
?>
<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language;?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CHtml::encode(Yii::app()->name); ?> <?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="icon" type="image/png" href="<?php echo Yii::app()->baseUrl;?>/web/images/favicon.png" />
    <?php
    $docsAssets = Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('application.modules.docs.views.assets')
    );
    $mainAssets = Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('application.modules.yupe.views.assets')
    );
    Yii::app()->clientScript->registerCssFile($mainAssets . '/css/styles.css');
    Yii::app()->clientScript->registerCssFile($docsAssets . '/css/main.css');
    if (($langs = $this->yupe->languageSelectorArray) != array())
        Yii::app()->clientScript->registerCssFile($mainAssets. '/css/flags.css');

    if(Yii::app()->hasComponent('highlightjs'))
        Yii::app()->highlightjs->loadClientScripts();
    ?>
</head>
<body>
    <div id="overall-wrap">
        <!-- mainmenu -->
        <?php
        $this->widget(
            'bootstrap.widgets.TbNavbar', array(                
                'fluid'       => true,
                'brand'       => CHtml::image(
                         Yii::app()->baseUrl.'/web/images/logo.png',
                         Yii::t('DocsModule.docs', 'Yupe! Documentation'),
                         array(
                            'width'  => '38',
                            'height' => '38',
                            'title'  => Yii::t('DocsModule.docs', 'Yupe! Documentation'),
                         )
                ),
                'brandUrl'    => CHtml::normalizeUrl(array("index")),
                'items'       => array(
                    array(
                        'class' => 'bootstrap.widgets.TbMenu',
                        'items' => $this->module->getArticles(),
                    ),
                    array(
                        'class'       => 'bootstrap.widgets.TbMenu',
                        'htmlOptions' => array('class' => 'pull-right'),
                        'encodeLabel' => false,
                        'items'       => array_merge(
                            array(
                                array(
                                    'icon'        => 'home',
                                    'label'       => Yii::t('DocsModule.docs', 'Go home'),
                                    'linkOptions' => array('target' => '_blank'),
                                    'url'         => array('/' . Yii::app()->defaultController . '/index/'),
                                ),
                                array(
                                    'label' => $this->yupe->getVersion(),
                                    'icon'  => 'icon-thumbs-up',
                                    'url'   => 'http://yupe.ru/?from=doc-navbar'
                                ),
                            ), $this->yupe->languageSelectorArray
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
        <?php echo $this->yupe->poweredBy();?>
        <small class="label label-info"><?php echo $this->yupe->getVersion(); ?></small>
        <br/>
        <a href="http://amylabs.ru?from=yupe-docs">
            <?php echo Yii::t('DocsModule.docs', 'Development and support'); ?></a> - <a href="http://amylabs.ru?from=yupe-docs">amyLabs
        </a>
        <br/>
            <a href="http://api.yupe.ru" target="_blank">API</a>
        <br/>
        <?php echo Yii::powered(); ?>
    </footer>
    <?php $this->widget("application.modules.contentblock.widgets.ContentBlockWidget", array("code" => "DISQUS_JS","silent" => true)); ?>
</body>
</html>