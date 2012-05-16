<?php
    $module = Yii::app()-> getModule('yupe');
    $this->beginContent($module-> getBackendLayoutAlias("main"));
?>
  <div class="row-fluid">
    <div class="span9">
        <?php $this->widget('YFlashMessages');?>
        <?php
        if ( count($this->breadcrumbs) )
        $this->widget('bootstrap.widgets.BootBreadcrumbs', array(
                                                         'homeLink' => CHtml::link(Yii::t('yupe', 'Главная'), array('/yupe/backend/')),
                                                         'links' => $this->breadcrumbs,
                                                    )); ?><!-- breadcrumbs -->
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

            // Преобразование пунктов, содержащих сабменю в заголовки групп
            foreach ( $this->menu as $mid=>$mi )
            {
                if ( isset($mi['items']) && is_array($mi['items']) )
                {
                    $it=$mi['items'];
                    unset($mi['items']);
                    unset($mi['icon']);
                    unset($mi['url']);
                    array_push($items,$mi);
                    $items=array_merge($items,$it);
                    array_push($items,"---");
                } else $items[]=$mi;

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
