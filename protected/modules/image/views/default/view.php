<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('image')->getCategory() => array(),
        Yii::t('ImageModule.image', 'Изображения') => array('/image/default/index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('ImageModule.image', 'Изображения - просмотр');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ImageModule.image', 'Управление изображениями'), 'url' => array('/image/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ImageModule.image', 'Добавить изображение'), 'url' => array('/image/default/create')),
        array('label' => Yii::t('ImageModule.image', 'Изображение') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('ImageModule.image', 'Редактирование изображение'), 'url' => array(
            '/image/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('ImageModule.image', 'Просмотреть изображение'), 'url' => array(
            '/image/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('ImageModule.image', 'Удалить изображение'),'url' => '#', 'linkOptions' => array(
            'submit'  => array('/image/default/delete', 'id' => $model->id),
            'params' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'confirm' => Yii::t('yupe', 'Вы уверены, что хотите удалить изображение?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
    <h1><?php echo Yii::t('ImageModule.image', 'Просмотр изображения'); ?><br />
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
             'value' => CHtml::image($model->getUrl(100), $model->alt, array("width" => 100, "height" => 100)),
         ),
        'creation_date',
        array(
            'name'  => 'user_id',
            'value' => $model->userName,
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
