<?php
    $this->breadcrumbs = array(
        $this->getModule('social')->getCategory() => array(),
        Yii::t('social', 'Социализация') => array('/social/default/index'),
        Yii::t('social', 'Авторизационные данные') => array('/social/default/index'),
        $model->id => array('/social/default/view', 'id' => $model->id),
        Yii::t('social', 'Редактирование'),
    );
    
    $this->menu = array(
        array('label' => Yii::t('social', 'Управление'), 'url' => array('/social/default/index')),
        array('label' => Yii::t('social', 'Просмотреть'), 'url' => array('/social/default/view', 'id' => $model->id)),
        array('label' => Yii::t('social', 'Редактировать'), 'url' => array('/social/default/update', 'id' => $model->id)),
        array('label' => Yii::t('social', 'Удалить'), 'url' => '#', 'linkOptions' => array(
            'submit'  => array('/social/default/delete', 'id' => $model->id),
            'confirm' => Yii::t('Social.social', 'Подтверждаете удаление ?'),
        )),
    );
?>

<h1><?php echo Yii::t('social', 'Редактирование'); ?> #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>