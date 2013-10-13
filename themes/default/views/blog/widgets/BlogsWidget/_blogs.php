<?php Yii::import('application.modules.blog.BlogModule'); ?>
<ul class="unstyled">
    <?php $cnt = count($models); $i = 0; ?>
    <?php foreach ($models as $model): ?>
        <li>
            <p>
                <?php echo CHtml::link($model->name, array('/blog/blog/show/', 'slug' => $model->slug)); ?>
            </p>
            <p>
                <i class="icon-user"></i>
                <?php echo Yii::t('BlogModule.blog','Members:'); ?>
                <?php echo $model->membersCount; ?>

                <i class="icon-file-alt"></i>
                <?php echo Yii::t('BlogModule.blog','Posts:'); ?>
                <?php echo CHtml::link($model->postsCount,array('/blog/post/blog/','slug' => $model->slug)); ?>
            </p>
        </li>
        <?php $i++; if ($i != $cnt) echo '<hr>'; ?>
    <?php endforeach; ?>
</ul>
