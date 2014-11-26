<div class="row">
    <div class="col-sm-12">
        <h4><strong><?php echo CHtml::link(
                    CHtml::encode($data->title),
                    ['/news/news/show/', 'alias' => $data->alias]
                ); ?></strong></h4>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <p> <?php echo $data->short_text; ?></p>

        <p><?php echo CHtml::link(
                Yii::t('NewsModule.news', 'read...'),
                ['/news/news/show/', 'alias' => $data->alias],
                ['class' => 'btn']
            ); ?></p>
    </div>
</div>

<hr>
