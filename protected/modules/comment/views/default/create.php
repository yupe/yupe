<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('comment')->getCategory() => array(),
        Yii::t('comment', 'Комментарии') => array('/comment/default/index'),
        Yii::t('comment', 'Добавление'),
    );

    $this->pageTitle = Yii::t('category', 'Комментарий - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('comment', 'Список комментариев'), 'url' => array('/comment/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('comment', 'Добавить комментарий'), 'url' => array('/comment/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('comment', 'Комментарии'); ?>
        <small><?php echo Yii::t('comment', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>