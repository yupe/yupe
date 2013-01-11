<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('blog')->getCategory() => array(),
    	Yii::t('BlogModule.blog', 'Блоги') => array('/admin/blog'),
        Yii::t('BlogModule.blog', 'Участники') => array('/admin/blog/userToBlog/index'),
        Yii::t('BlogModule.blog', 'Добавление'),
    );

    $this->pageTitle = Yii::t('BlogModule.blog', 'Участники - добавление');

    $this->menu = array(
        array('label' => Yii::t('BlogModule.blog', 'Блоги'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление блогами'), 'url' => array('/admin/blog/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить блог'), 'url' => array('/admin/blog/create')),
        )),
        array('label' => Yii::t('BlogModule.blog', 'Записи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление записями'), 'url' => array('/admin/blog/post/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить запись'), 'url' => array('/admin/blog/post/create')),
        )),
        array('label' => Yii::t('BlogModule.blog', 'Участники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление участниками'), 'url' => array('/admin/blog/userToBlog/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить участника'), 'url' => array('/admin/blog/userToBlog/create'), 'active' => true),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'Участники'); ?>
        <small><?php echo Yii::t('BlogModule.blog', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>