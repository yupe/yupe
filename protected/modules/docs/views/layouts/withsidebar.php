<?php
/**
 * Отображение для layouts/withsidebar:
 *
 * @category YupeLayout
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$mainAssets = Yii::app()->getTheme()->getAssetsUrl();

$this->beginContent("docs.views.layouts.docs");
?>
<div class="row">
    <div class="col-lg-10 col-md-9">
        <!-- breadcrumbs -->
        <?php $this->widget(
            'bootstrap.widgets.TbBreadcrumbs',
            ['links' => $this->breadcrumbs, 'homeLink' => false]
        ); ?>
        <!-- /breadcrumbs -->
        <?php $this->widget('yupe\widgets\YFlashMessages'); ?>
        <div id="content">
            <?php echo $content; ?>
        </div>

        <br/>

        <div class="alert alert-warning">
            Документация не полная? Устарела ? вы нашли ошибку ? Хотите добавить свою статью ?
            <a href="https://github.com/yupe/yupe">Помогите нам !</a>
        </div>

        <br/>

        <div>
            <?php $this->widget('application.modules.blog.widgets.ShareWidget'); ?>
        </div>

        <!-- content -->
        <div id="footer-guard"><!-- --></div>
    </div>
    <div class="col-lg-2 col-md-3">
        <div class="panel panel-default" style="padding: 8px 0;">
            <?php
            $this->widget(
                'bootstrap.widgets.TbMenu',
                [
                    'type'  => 'list',
                    'items' => $this->module->getArticles(false)
                ]
            ); ?>
        </div>
        <div>
            <?php $this->widget(
                'yupe\widgets\RandomDataWidget',
                [
                    'data' => [
                        CHtml::link(
                            CHtml::image(
                                $mainAssets . '/images/amylabs.png',
                                'amylabs - разработка на Юпи! и Yii !',
                                ['style' => 'width: 100%']
                            ),
                            'http://amylabs.ru?from=yupe-rb',
                            ['title' => 'amylabs - разработка на Юпи! и Yii !', 'target' => '_blank']
                        ),
                        CHtml::link(
                            CHtml::image(
                                $mainAssets . '/images/yupe-business.jpg',
                                'Разработка и запуск интернет магазина на Yii и "Юпи!"',
                                ['style' => 'width: 100%']
                            ),
                            'http://yupe.ru/ecommerce?from=yupe-business',
                            [
                                'title' => 'Разработка и запуск интернет магазина на Yii и "Юпи!"',
                                'target' => '_blank'
                            ]
                        )
                    ]
                ]
            ); ?>
        </div>
        <div class="panel panel-default" style="padding: 8px;"><?php $this->widget('yupe\widgets\YModuleInfo'); ?></div>
        <div class="alert alert-warning">
            <strong><?php echo Yii::app()->name; ?></strong> разрабатывается <a
                href="https://github.com/yupe/yupe/graphs/contributors" target="_blank">сообществом</a> при моральной
            поддержке <?php echo CHtml::link('amyLabs', 'http://amylabs.ru', ['target' => '_blank']); ?>!
            <strong><?php echo CHtml::link('Напишите нам', 'http://amylabs.ru/contact') ?></strong> при возникновении
            проблем!
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
