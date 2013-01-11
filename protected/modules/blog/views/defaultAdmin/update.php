<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('blog')->getCategory() => array(),
        Yii::t('BlogModule.blog', 'Блоги') => array('/admin/blog'),
        $model->name => array('/admin/blog/view', 'id' => $model->id),
        Yii::t('BlogModule.blog', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('BlogModule.blog', 'Блоги - редактирование');

    $this->menu = array(
        array('label' => Yii::t('BlogModule.blog', 'Блоги'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление блогами'), 'url' => array('/admin/blog')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить блог'), 'url' => array('/admin/blog/create')),
            array('label' => Yii::t('BlogModule.blog', 'Блог') . ' «' . mb_substr($model->name, 0, 32) . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('BlogModule.blog', 'Редактирование блога'), 'url' => array(
                '/admin/blog/update',
                'id' => $model->id
            ), 'active' => 'true'),
            array('icon' => 'eye-open', 'label' => Yii::t('BlogModule.blog', 'Просмотреть блог'), 'url' => array(
                '/admin/blog/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('BlogModule.blog', 'Удалить блог'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/admin/blog/delete', 'id' => $model->id),
                'confirm' => Yii::t('BlogModule.blog', 'Вы уверены, что хотите удалить блог?'),
            )),
        )),
        array('label' => Yii::t('BlogModule.blog', 'Записи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление записями'), 'url' => array('/admin/blog/post/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить запись'), 'url' => array('/admin/blog/post/create')),
        )),
        array('label' => Yii::t('BlogModule.blog', 'Участники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление участниками'), 'url' => array('/admin/blog/userToBlog/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить участника'), 'url' => array('/admin/blog/userToBlog/create')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'Редактирование блога'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>