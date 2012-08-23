<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('blog')->getCategory() => array(),
        Yii::t('blog', 'Блоги') => array('/blog/BlogAdmin/index'),
        Yii::t('blog', 'Добавление'),
    );

    $this->pageTitle = Yii::t('blog', 'Блоги - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление блогами'), 'url' => array('/blog/BlogAdmin/index')),
        array('icon' => 'plus-sign white', 'label' => Yii::t('blog', 'Добавить блог'), 'url' => array('/blog/BlogAdmin/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('blog', 'Блоги'); ?>
        <small><?php echo Yii::t('blog', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>