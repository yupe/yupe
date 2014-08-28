<?php
$this->beginWidget(
    'bootstrap.widgets.TbPanel',
    array(
        'title' => Yii::t('YupeModule.yupe', 'Tags cloud'),
    )
);
?>
<?php foreach ($tags as $tag): ?>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::link($tag['name'], array('/blog/post/list/', 'tag' => $tag['name'])); ?>
        </div>
        <div class="col-sm-6">
            <span class="badge pull-right"><?php echo $tag['count']; ?></span>
        </div>
    </div>
<?php endforeach; ?>

<?php $this->endWidget(); ?>
