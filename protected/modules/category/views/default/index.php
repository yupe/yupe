<?php
    $this->breadcrumbs = array(
        $this->getModule('category')->getCategory()=>array(''),
        Yii::t('category', 'Категории'),
    );

    $this->menu = array(
        array('label'=>Yii::t('category', 'Добавить категорию'), 'url'=>array('create')),
        array('label'=>Yii::t('category', 'Управление категориями'), 'url'=>array('admin')),
    );
?>

<h1><?php echo  Yii::t('category', 'Категории'); ?></h1>

<?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'_view',
    ));
 ?>
