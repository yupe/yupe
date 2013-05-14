<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('category')->getCategory() => array(),
        Yii::t('CategoryModule.category', 'Категории') => array('index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('CategoryModule.category', 'Категории - просмотр');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CategoryModule.category', 'Управление категориями'), 'url' => array('/category/default/index')),
        array('icon' => 'plus-sign', 'label' =>  Yii::t('CategoryModule.category', 'Добавить категорию'), 'url' => array('/category/default/create')),
        array('label' => Yii::t('CategoryModule.category', 'Категория') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('CategoryModule.category', 'Редактирование категории'), 'url' => array(
            '/category/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('CategoryModule.category', 'Просмотреть категорию'), 'url' => array(
            '/category/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('CategoryModule.category', 'Удалить категорию'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/category/default/delete', 'id' => $model->id),
            'params' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'confirm' => Yii::t('CategoryModule.category', 'Вы уверены, что хотите удалить категорию?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
     <h1>
         <?php echo Yii::t('CategoryModule.category', 'Просмотр категории'); ?><br />
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
        array(
            'name' => 'description',
            'type' => 'raw'
        ),
        array(
            'name' => 'short_description',
            'type' => 'raw'
        ),
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
    ),
)); ?>
