<?php
/**
 * Отображение для postAdmin/index:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->breadcrumbs = array(
    Yii::app()->getModule('blog')->getCategory() => array(),
    Yii::t('BlogModule.blog', 'Posts') => array('/blog/PostAdmin/index'),
    Yii::t('BlogModule.blog', 'Administration'),
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Posts - administration');

$this->menu = array(
    array('label' => Yii::t('BlogModule.blog', 'Blogs'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage Blogs'), 'url' => array('/blog/BlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add blog'), 'url' => array('/blog/BlogAdmin/create')),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Posts'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage Posts'), 'url' => array('/blog/PostAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add post'), 'url' => array('/blog/PostAdmin/create')),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Members'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage Members'), 'url' => array('/blog/UserToBlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add member'), 'url' => array('/blog/UserToBlogAdmin/create')),
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'Posts'); ?>
        <small><?php echo Yii::t('BlogModule.blog', 'administration'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('BlogModule.blog', 'Find posts'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript(
    'search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('post-grid', {
            data: $(this).serialize()
        });
        return false;
    });"
);
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('BlogModule.blog', 'In this category located posts administration functions'); ?></p>

<?php $this->widget(
    'application.modules.yupe.components.YCustomGridView', array(
        'id'           => 'post-grid',
        'type'         => 'condensed',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'bulkActions'      => array(
            'actionButtons' => array(
                array(
                    'id'         => 'delete-comment',
                    'buttonType' => 'button',
                    'type'       => 'danger',
                    'size'       => 'small',
                    'label'      => Yii::t('BlogModule.blog', 'Remove'),
                    'click'      => 'js:function(values){ if(!confirm("' . Yii::t('BlogModule.blog', 'Are you sure you want to delete selected items?') . '")) return false; multiaction("delete", values); }',
                ),
            ),
            'checkBoxColumnConfig' => array(
                'name' => 'id'
            ),
        ),
        'columns' => array(
            array(
                'name'  => 'id',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->id, array("/blog/postAdmin/update", "id" => $data->id))',
            ),
            array(
                'name'  => 'title',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->title, array("/blog/postAdmin/update", "id" => $data->id))',
            ),
            array(
                'name'   => 'blog_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->blog->name, array("/blog/blogAdmin/view", "id" => $data->blog->id))',
                'filter' => CHtml::listData(Blog::model()->findAll(),'id','name')
            ),
            array(
                'name'  => 'category_id',
                'value'  => 'empty($data->category) ? "---" : $data->category->name',
                'filter' => CHtml::listData($this->module->getCategoryListForPost(),'id','name')
            ),
            array(
                'name'   => 'create_user_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->createUser->getFullName(), array("/user/default/view", "id" => $data->createUser->id))',
                'filter' => CHtml::listData(User::model()->cache($this->yupe->coreCacheTime)->findAll(),'id','nick_name')
            ),
            array(
                'name'  => 'publish_date',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->publish_date, "short", "short")',
            ),
            array(
                'name'  => 'access_type',
                'type'  => 'raw',
                'value' => '$this->grid->returnBootstrapStatusHtml($data, "access_type", "AccessType", array(1 => "globe", 2 => "home"))',
                'filter' => Post::model()->getAccessTypeList()
            ),
            array(
                'name'  => 'status',
                'type'  => 'raw',
                'value'  => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("pencil", "ok-sign", "time"))',
                'filter' => Post::model()->getStatusList()
            ),
            array(
                'name'  => 'comment_status',
                'type'  => 'raw',
                'value' => '$this->grid->returnBootstrapStatusHtml($data, "comment_status", "CommentStatus", array(1 => "ok-sign", 2 => "lock"))',
                'filter' => Post::model()->getCommentStatusList()
            ),
            array(
                'header' => Yii::t('BlogModule.blog','Tags'),
                'value'  => 'implode(", ", $data->getTags())'
            ),
            array(
                'header' => "<i class=\"icon-comment\"></i>",
                'value' => 'CHtml::link($data->commentsCount,array("/comment/default/index/","Comment[model]" => "Post","Comment[model_id]" => $data->id))',
                'type'  => 'raw',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>