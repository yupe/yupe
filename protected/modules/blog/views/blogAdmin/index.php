<?php
    $this->pageTitle = Yii::t('blog', 'Блоги');

    $this->breadcrumbs = array(
        $this->getModule('blog')->getCategory() => array(''),
        Yii::t('page', 'Блоги'),
    );

    $this->menu = array(
        array('label'=>Yii::t('blog', 'Добавить блог'), 'url'=>array('create')),
        array('label'=>Yii::t('bog', 'Управление блогами'), 'url'=>array('admin')),
    );
?>

<h1><?php echo Yii::t('page', 'Блоги'); ?></h1>

<?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'_view',
    ));
?>
