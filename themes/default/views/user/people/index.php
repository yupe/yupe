<?php
    $this->pageTitle = Yii::t('user', 'Пользователи');
    $this->breadcrumbs = array(
        Yii::t('user', 'Пользователи'),
    );
?>

<h1><?php echo Yii::t('user', 'Пользователи'); ?></h1>

<?php
    $this->widget('bootstrap.widgets.TbListView', array(
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
    ));
?>