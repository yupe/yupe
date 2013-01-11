<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('blog')->getCategory() => array(),
    	Yii::t('BlogModule.blog', 'Блоги') => array('/admin/blog'),
        Yii::t('BlogModule.blog', 'Участники') => array('/admin/blog/userToBlog/index'),
        $model->user->nick_name => array('/admin/blog/userToBlog/view?id='.$model->id),
        Yii::t('BlogModule.blog', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('BlogModule.blog', 'Участники - редактирование');

    $this->menu = array(
        array('label' => Yii::t('BlogModule.blog', 'Блоги'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление блогами'), 'url' => array('/admin/blog')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить блог'), 'url' => array('/admin/blog/create')),
        )),
        array('label' => Yii::t('BlogModule.blog', 'Записи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление записями'), 'url' => array('/admin/blog/post/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить запись'), 'url' => array('/admin/blog/post/create')),
        )),
        array('label' => Yii::t('BlogModule.blog', 'Участники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление участниками'), 'url' => array('/admin/blog/userToBlog/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить участника'), 'url' => array('/admin/blog/userToBlog/create')),
            array('label' => Yii::t('BlogModule.blog', 'Участник') . ' «' . mb_substr($model->id, 0, 32) . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('BlogModule.blog', 'Редактирование участника'), 'url' => array(
                '/admin/blog/userToBlog/update?id='.$model->id
            ), 'active' => true ),
            array('icon' => 'eye-open', 'label' => Yii::t('BlogModule.blog', 'Просмотреть участника'), 'url' => array(
                '/admin/blog/userToBlog/view?id='.$model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('BlogModule.blog', 'Удалить участника'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/admin/blog/userToBlogAdmin/delete?id='.$model->id),
                'confirm' => Yii::t('BlogModule.blog', 'Вы уверены, что хотите удалить участника?'),
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