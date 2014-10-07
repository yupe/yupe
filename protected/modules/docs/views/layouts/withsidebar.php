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
$this->beginContent("docs.views.layouts.docs");
?>
<div class="row">
    <div class="col-lg-10 col-md-9">
        <!-- breadcrumbs -->
        <?php $this->widget(
            'bootstrap.widgets.TbBreadcrumbs',
            array('links' => $this->breadcrumbs, 'homeLink' => false)
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
                array(
                    'type'  => 'list',
                    'items' => $this->module->getArticles(false)
                )
            ); ?>
        </div>
        <div class="panel panel-default" style="padding: 8px;"><?php $this->widget('yupe\widgets\YModuleInfo'); ?></div>
        <div class="alert alert-warning">
            <strong><?php echo Yii::app()->name; ?></strong> разрабатывается <a
                href="https://github.com/yupe/yupe/graphs/contributors" target="_blank">сообществом</a> при моральной
            поддержке <?php echo CHtml::link('amyLabs', 'http://amylabs.ru', array('target' => '_blank')); ?>!
            <strong><?php echo CHtml::link('Напишите нам', 'http://amylabs.ru/contact') ?></strong> при возникновении
            проблем!
        </div>
        <div>
            <a href="http://amylabs.ru?from=yupe-docs" target="_blank"><?php echo CHtml::image(
                    'http://yupe.ru/web/images/amyLabs.jpg',
                    'amylabs - разработка и поддержка проектов на Юпи! и Yiiframework'
                ); ?></a>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
