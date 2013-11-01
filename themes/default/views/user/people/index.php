<?php
    $this->pageTitle = Yii::t('UserModule.user','Users');
    $this->breadcrumbs = array(
        Yii::t('UserModule.user','Users'),
    );
?>

<h1><?php echo Yii::t('UserModule.user','Users'); ?></h1>

<?php
    $this->widget('bootstrap.widgets.TbListView', array(
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
        'template' => "{items}\n{pager}",
    ));
?>

<hr/>