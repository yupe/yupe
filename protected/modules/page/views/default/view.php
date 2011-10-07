<?php $this->pageTitle = Yii::t('page', 'Просмотр страницы'); ?>

<?php
$this->breadcrumbs = array(
    $this->getModule('page')->getCategory() => array(''),
    Yii::t('page', 'Страницы') => array('admin'),
    $model->title,
);

$this->menu = array(
    array('label' => Yii::t('page', 'Добавить страницу'), 'url' => array('create')),
    array('label' => Yii::t('page', 'Список страниц'), 'url' => array('admin')),
    array('label' => Yii::t('page', 'Редактировать эту страницу'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('page', 'Удалить эту страницу'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('page', 'Подтверждаете удаление страницы ?'))),
);
?>

<h1><?php echo Yii::t('page', 'Просмотр страницы');?>
    "<?php echo $model->title; ?>"</h1>

<?php echo CHtml::link(Yii::t('page', 'Просмотреть на сайте'), array('/page/page/show', 'slug' => $model->slug, 'preview' => 1)); ?>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'id',
                                                        'creation_date',
                                                        'change_date',
                                                        array(
                                                            'name' => 'user_id',
                                                            'value' => $model->author->getFullName()
                                                        ),
                                                        'menu_order',
                                                        array(
                                                            'name' => 'change_user_id',
                                                            'value' => $model->changeAuthor->getFullName()
                                                        ),
                                                        'name',
                                                        'title',
                                                        'slug',
                                                        'body',
                                                        'keywords',
                                                        'description',
                                                        array(
                                                            'name' => 'status',
                                                            'value' => $model->getStatus()
                                                        ),
                                                        array(
                                                            'name' => 'is_protected',
                                                            'value' => $model->getProtectedStatus()
                                                        )
                                                    ),
                                               )); ?>

<br>


<?php echo CHtml::link(Yii::t('page', 'Редактировать эту страницу'), array('update', 'id' => $model->id)); ?>

<?php echo CHtml::link(Yii::t('page', 'Удалить эту страницу'), array('update', 'id' => $model->id), array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('page', 'Подтверждаете удаление страницы ?'))); ?>
