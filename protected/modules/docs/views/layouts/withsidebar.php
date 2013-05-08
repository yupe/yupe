<?php
/**
 * Отображение для layouts/withsidebar:
 * 
 *   @category YupeLayout
 *   @package  YupeCMS
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
        <?php $this->widget('YFlashMessages');?>
        <div id="content">
            <?php echo $content; ?>
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
        <div class="well" style="padding: 8px;"><?php $this->widget('YModuleInfo'); ?></div>
    </div>
  </div>
<?php $this->endContent(); ?>