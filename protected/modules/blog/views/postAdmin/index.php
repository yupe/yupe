<?php
    $this->pageTitle = Yii::t('blog', 'Записи');

    $this->breadcrumbs = array(
        $this->getModule('blog')->getCategory()=>array(''),
        Yii::t('page', 'Записи'),
    );

    $this->menu = array(
        array('label'=>Yii::t('blog', 'Добавить запись'), 'url'=>array('create')),
        array('label'=>Yii::t('bog', 'Управление записями'), 'url'=>array('admin')),
    );
?>

<h1><?php echo Yii::t('page', 'Записи'); ?></h1>

<?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'_view',
    ));
?>