<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('blog')->getCategory() => array(),
        Yii::t('blog', 'Записи') => array('/blog/PostAdmin/index'),
        Yii::t('blog', 'Управление'),
    );

    $this->pageTitle = Yii::t('blog', 'Записи - управление');

    $this->menu = array(
        array('icon' => 'list-alt white', 'label' => Yii::t('blog', 'Управление записьями'), 'url' => array('/blog/PostAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить запись'), 'url' => array('/blog/PostAdmin/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('blog', 'Записи'); ?>
        <small><?php echo Yii::t('blog', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('blog', 'Поиск записей'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('post-grid', {
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
    <?php echo Yii::t('blog', 'записьями'); ?>.
</p>


<?php
$this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'post-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        array(
            'name'  => 'title',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->title, array("/blog/postAdmin/update/", "id" => $data->id))',
        ),
        'slug',
        'link',
        array(
            'name'  => 'blog_id',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->blog->name, array("/blog/blogAdmin/view/", "id" => $data->blog->id))',
        ),
        array(
            'name'  => 'access_type',
            'value' => '$data->getAccessType()',
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
        array(
            'name'  => 'publish_date',
            'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->publish_date, "short", null)',
        ),
        array(
            'name'  => 'create_date',
            'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_date, "short", "short")',
        ),
        array(
            'name'  => 'update_date',
            'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->update_date, "short", "short")',
        ),
        array(
            'name'  => 'status',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data)',
        ),
        array(
            'name'  => 'comment_status',
            'value' => '$data->getCommentStatus()',
        ),
        //'quote',
        //'content',
        //'keywords',
        //'description',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>