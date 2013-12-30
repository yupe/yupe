<div class="bootstrap-widget">
   <div class="bootstrap-widget-header">
      <i class="icon-pencil"></i><h3><?php echo Yii::t('BlogModule.blog', 'Discuss');?></h3>
   </div>
   <div class="bootstrap-widget-content" id="yw11">
    <ul class="unstyled">
    <?php foreach ($data as $model): ?>
        <li>
            <?php echo CHtml::link($model['title'], array('/blog/post/show/', 'slug' => $model['slug'])); ?>
            <i class="icon-comment-alt"></i>
            <?php echo $model['commentsCount']; ?>                         
        </li>       
        <hr>
    <?php endforeach; ?>
    </ul>
   </div>
</div>