<?php $this->pageTitle = Yii::t('page', 'Просмотр страницы'); ?>

<?php
$this->breadcrumbs = array(
    $this->getModule('page')->getCategory() => array(''),
    Yii::t('page', 'Страницы') => array('admin'),
    $model->title,
);

$this->menu = array(
    array('encodeLabel'=> false, 'label' => '<i class="icon-list"></i>'.Yii::t('page', 'Управление страницами'), 'url' => array('/page/default/admin')),
    array('encodeLabel'=> false, 'label' => '<i class="icon-file"></i>'.Yii::t('page', 'Добавить страницу'), 'url' => array('/page/default/create')),
    array('encodeLabel'=> false, 'label' => '<i class="icon-pencil"></i>'.Yii::t('page', 'Редактировать эту страницу'), 'url' => array('/page/default/update','id'=> $model-> id)),
    array('encodeLabel'=> false, 'label' => '<i class="icon-eye-open icon-white"></i>'.Yii::t('page', 'Просмотр страницы')."<br /><span class='label' style='font-size: 80%; margin-left:17px;'>".$model-> name."</span>", 'url' => array('/page/default/view','id'=> $model-> id)),
    array('encodeLabel'=> false, 'label' => '<i class="icon-remove"></i>'.Yii::t('page', 'Удалить эту страницу'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('page', 'Подтверждаете удаление страницы ?'))),

);
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('page', 'Просмотр страницы');?>
        <br /><small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

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
