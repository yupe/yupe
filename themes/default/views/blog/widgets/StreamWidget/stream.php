<?php
$this->beginWidget(
    'bootstrap.widgets.TbPanel',
    [
        'title'      => Yii::t('BlogModule.blog', 'Discuss'),
        'headerIcon' => 'glyphicon glyphicon-pencil',
    ]
);
?>
<ul class="list-unstyled">
    <?php foreach ($data as $model): ?>
        <li>
            <?php echo CHtml::link(
                CHtml::encode($model['title']),
                ['/blog/post/show/', 'slug' => CHtml::encode($model['slug'])]
            ); ?>
            <i class="glyphicon glyphicon-comment"></i>
            <?php echo $model['commentsCount']; ?>
        </li>
        <hr>
    <?php endforeach; ?>
</ul>
<?php $this->endWidget(); ?>
