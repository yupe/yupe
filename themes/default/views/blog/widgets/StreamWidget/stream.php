<div class="bootstrap-widget">
   <div class="yupe-widget-header">
      <i class="icon-pencil"></i><h3><?php echo Yii::t('BlogModule.blog', 'Discuss');?></h3>
   </div>
   <div class="yupe-widget-content" id="disquss-widget">
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