<?php
    $module = Yii::app()-> getModule('yupe');
    $this->beginContent($module-> getBackendLayoutAlias("main"));
?>
  <div class="row-fluid">
    <div class="span9">
        <?php
        if ( count($this->breadcrumbs) )
        $this->widget('bootstrap.widgets.BootBreadcrumbs', array(
                                                         'homeLink' => array('label'=>Yii::t('yupe', 'Главная'), 'url'=>'/yupe/backend/'),
                                                         'links' => $this->breadcrumbs,
                                                    )); ?><!-- breadcrumbs -->

        <?php $this->widget('YFlashMessages');?>
        <div id="content">
            <?php echo $content; ?>
        </div>
        <!-- content -->
    </div>
    <div class="span3">
        <?php
        if ( count($this->menu) )
        {
            $items=array();
            foreach ( $this->menu as $mid=>$mi )
            {
                if ( isset($mi['items']) && is_array($mi['items']) )
                {
                    $items+=$mi['items'];
                    unset($mi['items']);
                }
                $items[]=$mi;
            }
        ?>
        <div class="well" style="padding: 8px 0;">
        <?php $this->widget('bootstrap.widgets.BootMenu', array(
            'type'=>'list',
            'items' => $items,
        ));

            ?>
        </div>
        <?php
        }
        ?>
        <div class="well" style="padding: 8px;">
            <?php $this->widget('YModuleInfo'); ?>
        </div>
    </div>

  </div>
<?php $this->endContent(); ?>
