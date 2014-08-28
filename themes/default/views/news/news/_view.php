<div class="row">
    <div class="col-sm-12">
        <h4><strong><?php echo CHtml::link(
                    CHtml::encode($data->title),
                    array('/news/news/show/', 'alias' => $data->alias)
                ); ?></strong></h4>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <p> <?php echo $data->short_text; ?></p>

        <p><?php echo CHtml::link(
                Yii::t('NewsModule.news', 'read...'),
                array('/news/news/show/', 'alias' => $data->alias),
                array('class' => 'btn')
            ); ?></p>
    </div>
</div>

<hr>
