<?php
	$category = Yii::app()->getModule('category');
    $this->breadcrumbs = array(
        $category->getCategory() => array('/yupe/backend/index', 'category' => $category->getCategoryType() ),
        Yii::t('CategoryModule.category', 'Категории') => array('/category/defaultAdmin/index'),
        $model->name => array('/category/defaultAdmin/view', 'id' => $model->id),
        Yii::t('CategoryModule.category', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('CategoryModule.category', 'Категории - редактирование');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CategoryModule.category', 'Управление категориями'), 'url' => array('/category/defaultAdmin/index')),
        array('icon' => 'plus-sign', 'label' =>  Yii::t('CategoryModule.category', 'Добавить категорию'), 'url' => array('/category/defaultAdmin/create')),
        array('label' => Yii::t('catalog', 'Категория') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('CategoryModule.category', 'Редактирование категории'), 'url' => array(
            '/category/defaultAdmin/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('CategoryModule.category', 'Просмотреть категорию'), 'url' => array(
            '/category/defaultAdmin/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('CategoryModule.category', 'Удалить категорию'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/category/defaultAdmin/delete', 'id' => $model->id),
            'confirm' => Yii::t('catalog', 'Вы уверены, что хотите удалить категорию?'),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CategoryModule.category', 'Редактирование категории'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo  $this->renderPartial('_form', array('model' => $model)); ?>