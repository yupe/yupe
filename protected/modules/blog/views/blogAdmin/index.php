<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('blog')->getCategory() => array(),
        Yii::t('blog', 'Блоги') => array('/blog/BlogAdmin/index'),
        Yii::t('blog', 'Управление'),
    );

    $this->pageTitle = Yii::t('blog', 'Блоги - управление');

    $this->menu = array(
        array('icon' => 'list-alt white', 'label' => Yii::t('blog', 'Управление блогами'), 'url' => array('/blog/BlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить блог'), 'url' => array('/blog/BlogAdmin/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('blog', 'Блоги'); ?>
        <small><?php echo Yii::t('blog', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('blog', 'Поиск блогов'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('blog-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p>
    <?php echo Yii::t('blog', 'В данном разделе представлены средства управления'); ?> 
    <?php echo Yii::t('blog', 'блогами'); ?>.
</p>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id'           => 'blog-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        array(
            'name'  => 'name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->name, array("/blog/blogAdmin/update/", "id" => $data->id))',
        ),
        array(
            'header'  => Yii::t('blog', 'Записей'),
            'value' => '$data->postsCount',
        ),
        array(
            'header'  => Yii::t('blog', 'Участников'),
            'value' => '$data->membersCount',
        ),
        'icon',
        'slug',
        array(
            'name'  => 'type',
            'value' => '$data->getType()',
        ),
        array(
            'name'  => 'status',
            'type'  => 'raw',
            //'value' => '$this->grid->returnBootstrapStatusHtml($data)',
        ),
        array(
            'name'  => 'create_user_id',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->createUser->getFullName(), array("/user/default/view/", "id" => $data->createUser->id))',
        ),
        array(
            'name'  => 'update_user_id',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->updateUser->getFullName(), array("/user/default/view/", "id" => $data->updateUser->id))',
        ),
        'create_date',
        'update_date',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>