<?php 
    $module = Yii::app()-> getModule('yupe');
    $this->beginContent($module-> getBackendLayoutAlias("main"));
?>
  <div class="row-fluid">
    <div class="span10">
        <?php $this->widget('YBSBreadcrumbs', array(
                                                         'homeLink' => CHtml::link(Yii::t('yupe', 'Главная'), array('/yupe/backend/')),
                                                         'links' => $this->breadcrumbs,
                                                    )); ?><!-- breadcrumbs -->

        <?php $this->widget('YFlashMessages');?>
        <div id="content">
            <?php echo $content; ?>
        </div>
        <!-- content -->
    </div>
    <div class="span2">
        <?php
        if ( count($this->menu) )
        {
        ?>
        <div class="well" style="padding: 8px 0;">
            <?php
              if ( count($this->menu) )
              {
                  foreach ( $this->menu as $mid => $m)
                  {
                      if (!isset($m['url']) || "#" == $m['url'])
                      {
                          if (isset($m['url'])) unset($this->menu[$mid]['url']);
                          $this->menu[$mid]['itemOptions'] = array("class"=>"nav-header");
                      }
                  }


                  $this->menu = array_merge(array(array('label'=> Yii::t('yupe', 'Основное меню'), 'itemOptions'=>array("class"=>"nav-header") )) , $this-> menu );
                  $this->widget('zii.widgets.CMenu', array(
                                                          'items' => $this->menu,
                                                          'htmlOptions' => array('class' => 'nav nav-list'),
                                                     ));
              }
            ?>
        </div>
        <?php
        }
        ?>
    </div>
  </div>  
<?php $this->endContent(); ?>
