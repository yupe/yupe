<?php
$this->beginWidget(
    'bootstrap.widgets.TbPanel',
    array(
        'title'      => Yii::t('BlogModule.blog', 'Blogs'),
        'headerIcon' => 'glyphicon glyphicon-pencil',
    )
);
?>
<ul class="list-unstyled">
    <?php foreach ($models as $model): ?>
        <li>
            <p>
                <?php echo CHtml::link(
                    CHtml::encode($model->name),
                    array('/blog/blog/show/', 'slug' => CHtml::encode($model->slug))
                ); ?>
                &rarr;
                <i class="glyphicon glyphicon-user"></i>
                <?php echo CHtml::link(
                    $model->membersCount,
                    array('/blog/blog/members', 'slug' => CHtml::encode($model->slug))
                ); ?>
                &rarr;
                <i class="glyphicon glyphicon-file"></i>
                <?php echo CHtml::link(
                    $model->postsCount,
                    array('/blog/post/blog/', 'slug' => CHtml::encode($model->slug))
                ); ?>
            </p>
        </li>
        <hr/>
    <?php endforeach; ?>
</ul>
<?php $this->endWidget(); ?>
