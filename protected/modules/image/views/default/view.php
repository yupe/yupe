<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('image')->getCategory() => array(),
        Yii::t('image', 'Изображения') => array('/image/default/index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('image', 'Изображения - просмотр');

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
    <h1><?php echo Yii::t('image', 'Просмотр изображения'); ?><br />
    <small>&laquo;<?php echo $model->name; ?>&raquo;</small></h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'category_id',
        'parent_id',
        'name',
        'description',
         array(
             'name'  => 'file',
             'type'  => 'raw',
             'value' => CHtml::image($model->file, $model->alt),
         ),
        'creation_date',
        array(
            'name'  => 'user_id',
            'value' => $model->user->getFullName(),
        ),
        'alt',
        array(
            'name'  => 'type',
            'value' => $model->getType(),
        ),
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        )
    ),
)); ?>