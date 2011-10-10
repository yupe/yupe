<?php echo $this->pageTitle = Yii::t('user', 'Просмотр профиля'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Профили') => array('admin')
);

$this->menu = array(
    array('label' => Yii::t('user', 'Список профилей'), 'url' => array('index')),
    array('label' => Yii::t('user', 'Изменить профиль'), 'url' => array('update', 'id' => $model->user_id)),
    array('label' => Yii::t('user', 'Управление профилями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('user', 'Просмотр профиля')?>
    #<?php echo $model->user->nick_name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        array(
                                                            'name' => 'user_id',
                                                            'value' => $model->user->nick_name
                                                        ),
                                                        'twitter',
                                                        'livejournal',
                                                        'vkontakte',
                                                        'odnoklassniki',
                                                        'facebook',
                                                        'yandex',
                                                        'google',
                                                        'blog',
                                                        'site',
                                                        'about',
                                                        'location',
                                                        'phone',
                                                    ),
                                               )); ?>
