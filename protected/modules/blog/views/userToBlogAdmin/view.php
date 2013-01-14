<?php
    $blog = Yii::app()->getModule('blog');
    $this->breadcrumbs = array(
        $blog->getCategory() => array('/yupe/backend/index', 'category' => $blog->getCategoryType() ),
    	Yii::t('BlogModule.blog', 'Блоги') => array('/blog/defaultAdmin/index'),
        Yii::t('BlogModule.blog', 'Участники') => array('/blog/userToBlogAdmin/index'),
        $model->user->nick_name,
    );

    $this->pageTitle = Yii::t('BlogModule.blog', 'Участники - просмотр');

    $this->menu = array(
        array('label' => Yii::t('BlogModule.blog', 'Блоги'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление блогами'), 'url' => array('/blog/defaultAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить блог'), 'url' => array('/blog/defaultAdmin/create')),
        )),
        array('label' => Yii::t('BlogModule.blog', 'Записи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление записями'), 'url' => array('/blog/postAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить запись'), 'url' => array('/blog/postAdmin/create')),
        )),
        array('label' => Yii::t('BlogModule.blog', 'Участники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление участниками'), 'url' => array('/blog/userToBlogAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить участника'), 'url' => array('/blog/userToBlogAdmin/create')),
            array('label' => Yii::t('BlogModule.blog', 'Участник') . ' «' . mb_substr($model->id, 0, 32) . '»'),
            array('icon' => 'pencil', 'encodeLabel' => false, 'label' => Yii::t('BlogModule.blog', 'Редактирование участника'), 'url' => array(
                '/blog/userToBlogAdmin/update',
            	'id' => $model->id
            )),
            array('icon' => 'eye-open', 'encodeLabel' => false, 'label' => Yii::t('BlogModule.blog', 'Просмотреть участника'), 'url' => array(
                '/blog/userToBlogAdmin/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('BlogModule.blog', 'Удалить участника'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/blog/userToBlogAdmin/delete', 'id' => $model->id),
                'confirm' => Yii::t('BlogModule.blog', 'Вы уверены, что хотите удалить участника?'),
            )),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'Просмотр участника'); ?><br />
        <small>&laquo;<?php echo $model->user->nick_name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        array(
            'name'  => 'user_id',
            'value' => $model->user->getFullName(),
        ),
        array(
            'name'  => 'blog_id',
            'value' => $model->blog->name,
        ),
        array(
            'name'  => 'create_date',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_date, "short", "short"),
        ),
        array(
            'name'  => 'update_date',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_date, "short", "short"),
        ),
        array(
            'name'  => 'role',
            'value' => $model->getRole(),
        ),
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
        'note',
    ),
)); ?>
