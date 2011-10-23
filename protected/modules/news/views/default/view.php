<?php
$this->breadcrumbs = array(
    $this->getModule('news')->getCategory() => array(''),
    Yii::t('news', 'Новости') => array('admin'),
    $model->title,
);

$this->menu = array(
    array('label' => Yii::t('news', 'Добавить новость'), 'url' => array('create')),
    array('label' => Yii::t('news', 'Список новостей'), 'url' => array('index')),
    array('label' => Yii::t('news', 'Редактировать новость'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('news', 'Удалить новость'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')),
    array('label' => Yii::t('news', 'Управление новостями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('news', 'Просмотр новости');?>
    "<?php echo $model->title; ?>"</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'id',
                                                        'creation_date',
                                                        'change_date',
                                                        'date',
                                                        'title',
                                                        'alias',
                                                        'short_text',
                                                        'full_text',
                                                        array(
                                                            'name' => 'user_id',
                                                            'value' => $model->user->getFullName()
                                                        ),
                                                        array(
                                                            'name' => 'status',
                                                            'value' => $model->getStatus()
                                                        ),
                                                        array(
                                                            'name' => 'is_protected',
                                                            'value' => $model->getProtectedStatus()
                                                        ),

                                                    ),
                                               )); ?>
