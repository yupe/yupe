<?php
    $this->breadcrumbs = array(
        Yii::t('blog', 'Блоги')=>array('admin'),
        Yii::t('blog', 'Добавление'),
    );

    $this->menu = array(
        array('label' => Yii::t('blog', 'Блоги')),
        array('icon' => 'th-large', 'label' => Yii::t('blog', 'Управление блогами'), 'url' => array('/blog/blogAdmin/admin/')),
        array('icon' => 'th-list', 'label' => Yii::t('blog', 'Список блогов'), 'url' => array('/blog/blogAdmin/index/')),
        array('icon' => 'plus-sign white', 'label' => Yii::t('blog', 'Добавить блог'), 'url' => array('/blog/blogAdmin/create/')),

        array('label' => Yii::t('blog', 'Записи')),
        array('icon' => 'th-large', 'label' => Yii::t('blog', 'Управление записями'), 'url' => array('/blog/postAdmin/admin/')),
        array('icon' => 'th-list', 'label' => Yii::t('blog', 'Список записей'), 'url' => array('/blog/postAdmin/index/')),
        array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить запись'), 'url' => array('/blog/postAdmin/create/')),

        array('label' => Yii::t('blog', 'Участники')),
        array('icon' => 'th-large', 'label' => Yii::t('blog', 'Управление участниками'), 'url' => array('/blog/userToBlogAdmin/admin/')),
        array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить участника'), 'url' => array('/blog/userToBlogAdmin/create/')),
    );
?>

<h1><?php echo Yii::t('blog','Добавление блога'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>