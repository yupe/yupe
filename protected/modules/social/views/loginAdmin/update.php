<?php
    $this->breadcrumbs = array(
        $this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType()),
        Yii::t('social', 'Социализация') => array('/social/defaultAdmin/index'),
        Yii::t('social', 'Авторизационные данные') => array('/social/defaultAdmin/index'),
        $model->id => array('/social/defaultAdmin/view', 'id' => $model->id),
        Yii::t('social', 'Редактирование'),
    );
    
    $this->menu = array(
        array('label' => Yii::t('social', 'Управление'), 'url' => array('/social/defaultAdmin/index')),
        array('label' => Yii::t('social', 'Просмотреть'), 'url' => array('/social/defaultAdmin/view', 'id' => $model->id)),
        array('label' => Yii::t('social', 'Редактировать'), 'url' => array('/social/defaultAdmin/update', 'id' => $model->id)),
        array('label' => Yii::t('social', 'Удалить'), 'url' => '#', 'linkOptions' => array(
            'submit'  => array('/social/defaultAdmin/delete', 'id' => $model->id),
            'confirm' => Yii::t('Social.social', 'Подтверждаете удаление ?'),
        )),
    );
?>

<h1><?php echo Yii::t('social', 'Редактирование'); ?> #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>