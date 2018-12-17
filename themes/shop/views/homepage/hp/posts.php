<?php
$this->title = Yii::t('HomepageModule.homepage', 'Records');
$this->breadcrumbs = [Yii::t('HomepageModule.homepage', 'Records')];
?>

<div class="main__catalog grid">
    <?php $this->widget(
        'zii.widgets.CListView',
        [
            'dataProvider' => $dataProvider,
            'itemView' => '_post',
            'template' => "{items}\n{pager}",
        ]
    ); ?>
</div>