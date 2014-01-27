<?php
/**
 * Отображение для layouts/withsidebar:
 * 
 *   @category YupeLayout
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->beginContent("docs.views.layouts.docs");
?>
  <div class="row-fluid">
    <div class="span9">
        <!-- breadcrumbs -->
        <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links' => $this->breadcrumbs, 'homeLink' => false)); ?>
        <!-- /breadcrumbs -->
        <?php $this->widget('yupe\widgets\YFlashMessages');?>
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
            <?php $this->widget('application.modules.blog.widgets.ShareWidget');?>
        </div>

        <!-- content -->
        <div id="footer-guard"><!-- --></div>
    </div>
    <div class="span3">
        <div class="well" style="padding: 8px 0;">
            <?php
            $this->widget(
                'bootstrap.widgets.TbMenu', array(
                    'type'=>'list',
                    'items' => $this->module->getArticles(false)
                )
            ); ?>
        </div>
        <div class="well" style="padding: 8px;"><?php $this->widget('yupe\widgets\YModuleInfo'); ?></div>
        <div class="alert alert-notice">
            <strong><?php echo Yii::app()->name;?></strong> разрабатывается <a href="https://github.com/yupe/yupe/graphs/contributors" target="_blank">сообществом</a> при моральной поддержке <?php echo CHtml::link('amyLabs','http://amylabs.ru', array('target' => '_blank'));?>!
            <strong><?php echo CHtml::link('Напишите нам', 'http://amylabs.ru/contact')?></strong> при возникновении проблем!
        </div>
    </div>
  </div>
<?php $this->endContent(); ?>