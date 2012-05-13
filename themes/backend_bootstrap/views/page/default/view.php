<?php $this->pageTitle = Yii::t('page', 'Просмотр страницы'); ?>

<?php
$this->breadcrumbs = array(
    $this->getModule('page')->getCategory() => array(''),
    Yii::t('page', 'Страницы') => array('admin'),
    $model->title,
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('page', 'Управление страницами'), 'url' => array('/page/default/admin')),
    array('icon' => 'file', 'label' => Yii::t('page', 'Добавить страницу'), 'url' => array('/page/default/create')),
    array('icon' => 'pencil', 'label' => Yii::t('page', 'Редактировать эту страницу'), 'url' => array('/page/default/update','id'=> $model-> id)),
    array('icon' => 'eye-open white', 'encodeLabel'=> false, 'label' => Yii::t('page', 'Просмотр страницы')."<br /><span class='label' style='font-size: 80%;'>".$model-> name."</span>", 'url' => array('/page/default/view','id'=> $model-> id)),
    array('icon' => 'remove', 'label' => Yii::t('page', 'Удалить эту страницу'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('page', 'Подтверждаете удаление страницы ?'))),

);
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('page', 'Просмотр страницы');?>
        <br /><small style="margin-left:-10px;">&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>


<h2><?=$model->title;?></h2>
<small>Автор: <?=$model->changeAuthor->getFullName();?></small>
<br /><br />
<p>
    <?=$model->body;?>

</p>
<?php /* $this->widget('zii.widgets.CDetailView', array(
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
                                               ));
*/
 ?>

<br>

<?php echo CHtml::link(Yii::t('page', 'Просмотреть на сайте'), array('/page/page/show', 'slug' => $model->slug, 'preview' => 1)); ?>
<?php echo CHtml::link(Yii::t('page', 'Редактировать эту страницу'), array('update', 'id' => $model->id)); ?>

<?php echo CHtml::link(Yii::t('page', 'Удалить эту страницу'), array('update', 'id' => $model->id), array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('page', 'Подтверждаете удаление страницы ?'))); ?>
