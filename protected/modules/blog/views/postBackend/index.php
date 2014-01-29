<?php
/**
 * Отображение для postBackend/index:
 * 
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->breadcrumbs = array(   
    Yii::t('BlogModule.blog', 'Posts') => array('/blog/postBackend/index'),
    Yii::t('BlogModule.blog', 'Administration'),
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Posts - administration');

$this->menu = array(
    array('label' => Yii::t('BlogModule.blog', 'Blogs'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage blogs'), 'url' => array('/blog/blogBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add a blog'), 'url' => array('/blog/blogBackend/create')),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Posts'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage posts'), 'url' => array('/blog/postBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add a post'), 'url' => array('/blog/postBackend/create')),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Members'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage members'), 'url' => array('/blog/userToBlogBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add a member'), 'url' => array('/blog/userToBlogBackend/create')),
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

<p><?php echo Yii::t('BlogModule.blog', 'In this category located post administration functions'); ?></p>

<?php $this->widget(
    'yupe\widgets\CustomGridView', array(
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
                    'click'      => 'js:function(values){ if(!confirm("' . Yii::t('BlogModule.blog', 'Do you really want to delete selected items?') . '")) return false; multiaction("delete", values); }',
                ),
            ),
            'checkBoxColumnConfig' => array(
                'name' => 'id'
            ),
        ),
        'columns' => array( 
            array(
                'name'  => 'id',
                'value' => 'CHtml::link($data->id, array("/blog/postBackend/update","id" => $data->id))',
                'type'  => 'html',
                'htmlOptions' => array(
                    'style' => 'width:10px;'
                )
            ),
            array(
                'name'   => 'blog_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->blog->name, array("/blog/blogBackend/view", "id" => $data->blog->id))',
                'filter' => CHtml::listData(Blog::model()->findAll(),'id','name')
            ),
            array(
                'class' => 'bootstrap.widgets.TbEditableColumn',                
                'name'  => 'title',               
                'editable' => array(   
                    'url' => $this->createUrl('/blog/postBackend/inline'),                 
                    'mode' => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )                    
                )                
            ),
            array(
                'class' => 'bootstrap.widgets.TbEditableColumn',                
                'name'  => 'slug',
                'editable' => array(   
                    'url'  => $this->createUrl('/blog/postBackend/inline'),
                    'mode' => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )                                 
                )                           
            ),
            array(
                'class' => 'bootstrap.widgets.TbEditableColumn',                
                'name'  => 'publish_date',
                'editable' => array(   
                    'url'  => $this->createUrl('/blog/postBackend/inline'),
                    'mode' => 'inline',
                    'type' => 'datetime',
                    'options' => array(
                        'datetimepicker' => array(
                           'format' => 'dd-mm-yyyy hh:ii'
                        ),
                        'datepicker' => array(
                            'format' => 'dd-mm-yyyy hh:ii'
                        ),
                    ),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )                                 
                )                           
            ),
            array(
                'name'   => 'category_id',
                'value'  => 'empty($data->category) ? "---" : $data->category->name',
                'filter' => Category::model()->getFormattedList((int)Yii::app()->getModule('blog')->mainPostCategory)
            ),
            array(
                'name'   => 'create_user_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->createUser->getFullName(), array("/user/userBackend/view", "id" => $data->createUser->id))',
                'filter' => CHtml::listData(User::model()->cache($this->yupe->coreCacheTime)->findAll(),'id','nick_name')
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
                'value' => 'CHtml::link(($data->commentsCount>0) ? $data->commentsCount-1 : 0,array("/comment/commentBackend/index/","Comment[model]" => "Post","Comment[model_id]" => $data->id))',
                'type'  => 'raw',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>