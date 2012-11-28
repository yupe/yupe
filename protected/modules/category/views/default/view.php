<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('category')->getCategory() => array(),
        Yii::t('category', 'Категории') => array('index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('category', 'Категории - просмотр');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('category', 'Управление категориями'), 'url' => array('/category/default/index')),
        array('icon' => 'plus-sign', 'label' =>  Yii::t('category', 'Добавить категорию'), 'url' => array('/category/default/create')),
        array('label' => Yii::t('catalog', 'Категория') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('category', 'Редактирование категории'), 'url' => array(
            'category/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('category', 'Просмотреть категорию'), 'url' => array(
            '/category/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('category', 'Удалить категорию'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/category/default/delete', 'id' => $model->id),
            'confirm' => Yii::t('catalog', 'Вы уверены, что хотите удалить категорию?'),
        )),
    );
?>
<div class="page-header">
     <h1>
         <?php echo Yii::t('category', 'Просмотр категории'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
     </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        array(
            'name'  => 'parent_id',
            'value' => $model->getParentName(),
        ),
        'name',
        'alias',
        array(
            'name'  => 'image',
            'type'  => 'raw',
            'value' => $model->image
                ? CHtml::image($model->imageSrc, $model->name, array('width' => 300, 'height' => 300))
                : '---',
        ),
        'description',
        'short_description',
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
    ),
)); ?>