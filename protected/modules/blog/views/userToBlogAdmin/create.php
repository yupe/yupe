<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('blog')->getCategory() => array(),
        Yii::t('blog', 'Участники') => array('/blog/UserToBlogAdmin/index'),
        Yii::t('blog', 'Добавление'),
    );

    $this->pageTitle = Yii::t('blog', 'Участники - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление участниками'), 'url' => array('/blog/UserToBlogAdmin/index')),
        array('icon' => 'plus-sign white', 'label' => Yii::t('blog', 'Добавить участника'), 'url' => array('/blog/UserToBlogAdmin/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('blog', 'Участники'); ?>
        <small><?php echo Yii::t('blog', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>