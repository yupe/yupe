<?php
$this->beginWidget(
    'bootstrap.widgets.TbPanel',
    [
        'title' => Yii::t('BlogModule.blog', 'Latest posts'),
    ]
);
?>
<ul class="list-unstyled">
    <?php foreach ($models as $model): ?>
        <li>
            <?= CHtml::link(
                CHtml::encode($model->title),
                $model->getUrl()
            ); ?>
            <nobr>
                <i class="glyphicon glyphicon-comment"></i> <?= $model->getCommentCount(); ?>
            </nobr>
            <hr/>
        </li>
    <?php endforeach; ?>
</ul>
<?php $this->endWidget(); ?>
