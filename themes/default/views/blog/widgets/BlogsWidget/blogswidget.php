<div class="yupe-widget-header">
    <i class="icon-pencil"></i>
    <h3><?php echo Yii::t('BlogModule.blog', 'Blogs'); ?></h3>
</div>

<div class="yupe-widget-content">
    <ul class="unstyled">
        <?php foreach ($models as $model): ?>
            <li>
                <p>
                    <?php echo CHtml::link(
                        CHtml::encode($model->name),
                        array('/blog/blog/show/', 'slug' => CHtml::encode($model->slug))
                    ); ?>
                    &rarr;
                    <i class="fa fa-user"></i>
                    <?php echo CHtml::link(
                        $model->membersCount,
                        array('/blog/blog/members', 'slug' => CHtml::encode($model->slug))
                    ); ?>
                    &rarr;
                    <i class="fa fa-file"></i>
                    <?php echo CHtml::link(
                        $model->postsCount,
                        array('/blog/post/blog/', 'slug' => CHtml::encode($model->slug))
                    ); ?>
                </p>
            </li>
            <hr/>
        <?php endforeach; ?>
    </ul>
</div>
