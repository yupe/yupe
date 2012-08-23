<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('blog')->getCategory() => array(),
        Yii::t('blog', 'Записи') => array('/blog/PostAdmin/index'),
        Yii::t('blog', 'Добавление'),
    );

    $this->pageTitle = Yii::t('blog', 'Записи - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление записьями'), 'url' => array('/blog/PostAdmin/index')),
        array('icon' => 'plus-sign white', 'label' => Yii::t('blog', 'Добавить запись'), 'url' => array('/blog/PostAdmin/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('blog', 'Записи'); ?>
        <small><?php echo Yii::t('blog', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>