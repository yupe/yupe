<?php $this->pageTitle = Yii::t('default', 'Галереи изображений!'); ?>

<?php $this->breadcrumbs = array(Yii::t('default', 'Галереи изображений!'));?>

<h1><?php echo Yii::t('default', 'Галереи изображений!');?></h1>


<?php
$this->widget(
    'zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
        'itemsTagName' => 'li',
        'tagName' => 'ul',
        'htmlOptions' => array(
            'class' => 'thumbnails unstyled'
        )
    )
); ?>

