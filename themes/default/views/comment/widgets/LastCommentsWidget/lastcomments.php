<?php Yii::import('application.modules.comment.CommentModule'); ?>
<div class='portlet'>
    <div class='portlet-decoration'>
        <div class='portlet-title'><?php echo Yii::t('CommentModule.comment','Last comments');?></div>
    </div>
    <div class='portlet-content'>
        <?php if(isset($models) && $models != array()): ?>
            <ul>
                <?php foreach ($models as $model): ?>
                    <li><?php echo CHtml::link($model->text);?></li>
                <?php endforeach;?>
            </ul>
        <?php endif; ?>
    </div>
</div>
