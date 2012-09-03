<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('blog')->getCategory() => array(),
        Yii::t('blog', 'Записи') => array('/blog/PostAdmin/index'),
        $model->title => array('/blog/PostAdmin/view', 'id' => $model->id),
        Yii::t('blog', 'Редактирование'),
    );
    $this->pageTitle = Yii::t('blog', 'Записи - редактирование');
    $this->menu = array(
        array('label' => Yii::t('blog', 'Блоги'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление блогами'), 'url' => array('/blog/BlogAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить блог'), 'url' => array('/blog/BlogAdmin/create')),
        )),
        array('label' => Yii::t('blog', 'Записи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление записьями'), 'url' => array('/blog/PostAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить запись'), 'url' => array('/blog/PostAdmin/create')),
            array('label' => Yii::t('blog', 'Запись') . ' «' . $model->title . '»'),
            array('icon' => 'pencil white', 'encodeLabel' => false, 'label' => Yii::t('blog', 'Редактирование записи'), 'url' => array(
                '/blog/PostAdmin/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'encodeLabel' => false, 'label' => Yii::t('blog', 'Просмотреть запись'), 'url' => array(
                '/blog/PostAdmin/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('blog', 'Удалить запись'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('delete', 'id' => $model->id),
                'confirm' => Yii::t('blog', 'Вы уверены, что хотите удалить запись?')
            )),
        )),
        array('label' => Yii::t('blog', 'Участники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление участниками'), 'url' => array('/blog/UserToBlogAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить участника'), 'url' => array('/blog/UserToBlogAdmin/create')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('blog', 'Редактирование') . ' ' . Yii::t('blog', 'записи'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>