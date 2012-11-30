<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('blog')->getCategory() => array(),
        Yii::t('blog', 'Участники') => array('/blog/UserToBlogAdmin/index'),
        $model->user->nick_name => array('/blog/UserToBlogAdmin/view', 'id' => $model->id),
        Yii::t('blog', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('blog', 'Участники - редактирование');

    $this->menu = array(
        array('label' => Yii::t('blog', 'Блоги'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление блогами'), 'url' => array('/blog/BlogAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить блог'), 'url' => array('/blog/BlogAdmin/create')),
        )),
        array('label' => Yii::t('blog', 'Записи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление записями'), 'url' => array('/blog/PostAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить запись'), 'url' => array('/blog/PostAdmin/create')),
        )),
        array('label' => Yii::t('blog', 'Участники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление участниками'), 'url' => array('/blog/UserToBlogAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить участника'), 'url' => array('/blog/UserToBlogAdmin/create')),
            array('label' => Yii::t('blog', 'Участник') . ' «' . mb_substr($model->id, 0, 32) . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('blog', 'Редактирование участника'), 'url' => array(
                '/blog/UserToBlogAdmin/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('blog', 'Просмотреть участника'), 'url' => array(
                '/blog/UserToBlogAdmin/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('blog', 'Удалить участника'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/blog/UserToBlogAdmin/delete', 'id' => $model->id),
                'confirm' => Yii::t('blog', 'Вы уверены, что хотите удалить участника?'),
            )),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('menu', 'Редактирование участника');?><br />
        <small>&laquo;<?php echo $model->user->nick_name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>