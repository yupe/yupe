<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('blog')->getCategory() => array(),
        Yii::t('blog', 'Участники') => array('/blog/UserToBlogAdmin/index'),
        $model->id,
    );
    $this->pageTitle = Yii::t('blog', 'Участники - просмотр');
    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление участниками'), 'url' => array('/blog/UserToBlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить участника'), 'url' => array('/blog/UserToBlogAdmin/create')),
        array('label' => Yii::t('blog', 'Участник')),
        array('icon' => 'pencil', 'encodeLabel' => false, 'label' => Yii::t('blog', 'Редактирование участника'), 'url' => array(
            '/blog/UserToBlogAdmin/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open white', 'encodeLabel' => false, 'label' => Yii::t('blog', 'Просмотреть участника'), 'url' => array(
            '/blog/UserToBlogAdmin/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('blog', 'Удалить участника'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('delete', 'id' => $model->id),
            'confirm' => Yii::t('blog', 'Вы уверены, что хотите удалить участника?')
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('blog', 'Просмотр') . ' ' . Yii::t('blog', 'участника'); ?><br />
        <small>&laquo;<?php echo $model->id; ?>&raquo;</small>
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
        'create_date',
        'update_date',
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
