<?php
/**
 * Отображение для postBackend/index:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Posts') => array('/blog/postBackend/index'),
    Yii::t('BlogModule.blog', 'Administration'),
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Posts - administration');

$this->menu = array(
    array(
        'label' => Yii::t('BlogModule.blog', 'Blogs'),
        'items' => array(
            array(
                'icon'  => 'glyphicon glyphicon-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Manage blogs'),
                'url'   => array('/blog/blogBackend/index')
            ),
            array(
                'icon'  => 'glyphicon glyphicon-plus-sign',
                'label' => Yii::t('BlogModule.blog', 'Add a blog'),
                'url'   => array('/blog/blogBackend/create')
            ),
        )
    ),
    array(
        'label' => Yii::t('BlogModule.blog', 'Posts'),
        'items' => array(
            array(
                'icon'  => 'glyphicon glyphicon-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Manage posts'),
                'url'   => array('/blog/postBackend/index')
            ),
            array(
                'icon'  => 'glyphicon glyphicon-plus-sign',
                'label' => Yii::t('BlogModule.blog', 'Add a post'),
                'url'   => array('/blog/postBackend/create')
            ),
        )
    ),
    array(
        'label' => Yii::t('BlogModule.blog', 'Members'),
        'items' => array(
            array(
                'icon'  => 'glyphicon glyphicon-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Manage members'),
                'url'   => array('/blog/userToBlogBackend/index')
            ),
            array(
                'icon'  => 'glyphicon glyphicon-plus-sign',
                'label' => Yii::t('BlogModule.blog', 'Add a member'),
                'url'   => array('/blog/userToBlogBackend/create')
            ),
        )
    ),
);
?>

<?php
$this->beginWidget(
    'booster.widgets.TbPanel',
    ['title' => Yii::t('BlogModule.blog', 'Posts'), 'headerIcon' => $this->module->getIcon()]
);
?>

<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="glyphicon glyphicon-search">&nbsp;</i>
    <?php echo Yii::t('BlogModule.blog', 'Find posts'); ?>
    <span class="caret">&nbsp;</span>
</a>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('post-grid', {
            data: $(this).serialize()
        });

        return false;
    });"
    );
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'post-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/blog/postBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                            'BlogModule.blog',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('blog_id')))
                        ),
                    'source' => CHtml::listData(Blog::model()->findAll(), 'id', 'name'),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'     => 'blog_id',
                'type'     => 'raw',
                'filter'   => CHtml::activeDropDownList(
                        $model,
                        'blog_id',
                        CHtml::listData(Blog::model()->findAll(), 'id', 'name'),
                        array('class' => 'form-control', 'empty' => '')
                    ),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'title',
                'editable' => array(
                    'url'    => $this->createUrl('/blog/postBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'title', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'slug',
                'editable' => array(
                    'url'    => $this->createUrl('/blog/postBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'slug', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'publish_date',
                'editable' => array(
                    'url'        => $this->createUrl('/blog/postBackend/inline'),
                    //'mode' => 'inline',
                    'type'       => 'datetime',
                    'options'    => array(
                        'datetimepicker' => array(
                            'format'   => 'dd-mm-yyyy hh:ii',
                            'language' => Yii::app()->language,
                        ),
                        'datepicker'     => array(
                            'format' => 'dd-mm-yyyy',
                        ),

                    ),
                    'viewformat' => 'dd-mm-yyyy hh:ii',
                    'params'     => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'value'    => '$data->publish_date',
                'filter'   => CHtml::activeTextField($model, 'publish_date', array('class' => 'form-control')),
            ),
            array(
                'name'   => 'create_user_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->createUser->getFullName(), array("/user/userBackend/view", "id" => $data->createUser->id))',
                'filter' => CHtml::activeDropDownList(
                        $model,
                        'create_user_id',
                        CHtml::listData(User::model()->cache($this->yupe->coreCacheTime)->findAll(), 'id', 'nick_name'),
                        array('class' => 'form-control', 'empty' => '')
                    ),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/blog/postBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                            'BlogModule.blog',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('status')))
                        ),
                    'source' => $model->getStatusList(),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'     => 'status',
                'type'     => 'raw',
                'value'    => '$data->getStatus()',
                'filter'   => CHtml::activeDropDownList(
                        $model,
                        'status',
                        $model->getStatusList(),
                        array('class' => 'form-control', 'empty' => '')
                    ),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/blog/postBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                            'BlogModule.blog',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('comment_status')))
                        ),
                    'source' => array_merge(array('' => '---'), $model->getCommentStatusList()),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'     => 'comment_status',
                'type'     => 'raw',
                'value'    => '$data->getCommentStatus()',
                'filter'   => CHtml::activeDropDownList(
                        $model,
                        'comment_status',
                        $model->getCommentStatusList(),
                        array('class' => 'form-control', 'empty' => '')
                    ),
            ),
            array(
                'header' => Yii::t('BlogModule.blog', 'Tags'),
                'value'  => 'implode(", ", $data->getTags())'
            ),
            array(
                'header' => "<i class=\"glyphicon glyphicon-comment\"></i>",
                'value'  => 'CHtml::link(($data->commentsCount>0) ? $data->commentsCount-1 : 0,array("/comment/commentBackend/index/","Comment[model]" => "Post","Comment[model_id]" => $data->id))',
                'type'   => 'raw',
            ),
            array(
                'value' => 'yupe\helpers\Html::label($data->status, $data->getStatus(), [Post::STATUS_DRAFT => "default", Post::STATUS_PUBLISHED => "success", Post::STATUS_SHEDULED => "info", Post::STATUS_MODERATED => "warning"])',
                'type'  => 'raw'
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>

<?php $this->endWidget(); ?>
