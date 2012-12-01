<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('image')->getCategory() => array(),
        Yii::t('image', 'Изображения') => array('/image/default/index'),
        $model->name => array('/image/default/view', 'id' => $model->id),
        Yii::t('image', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('image', 'Изображения - редактирование');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('image', 'Управление изображениями'), 'url' => array('/image/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('image', 'Добавить изображение'), 'url' => array('/image/default/create')),
        array('label' => Yii::t('image', 'Изображение') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('image', 'Редактирование изображение'), 'url' => array(
            '/image/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('image', 'Просмотреть изображение'), 'url' => array(
            '/image/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('image', 'Удалить изображение'),'url' => '#', 'linkOptions' => array(
            'submit'  => array('/image/default/delete', 'id' => $model->id),
            'confirm' => Yii::t('yupe', 'Вы уверены, что хотите удалить изображение?'),
        )),
    );
?>
<div class="page-header">
    <h1><?php echo Yii::t('image', 'Редактирование изображения'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>