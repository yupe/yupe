<div class="yupe-widget-header">
     <h3><?php echo Yii::t('YupeModule.yupe','Tags cloud');?></h3>
</div>

<div class="yupe-widget-content" id="tags">	
    <?php foreach ($tags as $tag): ?>  
       <div class="row-fluid">   
          <div class="span6">
            <?php echo CHtml::link($tag['name'], array('/blog/post/list/', 'tag' => $tag['name']));?> 
          </div>
          <div class="span6">
            <span class="badge pull-right"><?php echo $tag['count'];?></span>
          </div>          
       </div>         
    <?php endforeach;?>	
</div>

