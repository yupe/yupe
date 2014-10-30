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
    Yii::t('BlogModule.blog', 'Members') => array('/blog/userToBlogBackend/index'),
    Yii::t('BlogModule.blog', 'Administration'),
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Members - administration');

$this->menu = array(
    array(
        'label' => Yii::t('BlogModule.blog', 'Blogs'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Manage blogs'),
                'url'   => array('/blog/blogBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('BlogModule.blog', 'Add a blog'),
                'url'   => array('/blog/blogBackend/create')
            ),
        )
    ),
    array(
        'label' => Yii::t('BlogModule.blog', 'Posts'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Manage posts'),
                'url'   => array('/blog/postBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('BlogModule.blog', 'Add a post'),
                'url'   => array('/blog/postBackend/create')
            ),
        )
    ),
    array(
        'label' => Yii::t('BlogModule.blog', 'Members'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Manage members'),
                'url'   => array('/blog/userToBlogBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('BlogModule.blog', 'Add a member'),
                'url'   => array('/blog/userToBlogBackend/create')
            ),
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'Members'); ?>
        <small><?php echo Yii::t('BlogModule.blog', 'administration'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('BlogModule.blog', 'Find members'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('user-to-blog-grid', {
            data: $(this).serialize()
        });

        return false;
    });"
    );
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<p>
    <?php echo Yii::t('BlogModule.blog', 'In this category located member administration functions'); ?>
</p>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'user-to-blog-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'name'   => 'user_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->user->getFullName(), array("/user/userBackend/view", "id" => $data->user->id))',
                'filter' => CHtml::listData(
                    User::model()->cache($this->yupe->coreCacheTime)->findAll(),
                    'id',
                    'nick_name'
                )
            ),
            array(
                'name'   => 'blog_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->blog->name, array("/blog/blogBackend/view", "id" => $data->blog->id))',
                'filter' => CHtml::listData(Blog::model()->cache($this->yupe->coreCacheTime)->findAll(), 'id', 'name')
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/blog/userToBlogBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                        'BlogModule.blog',
                        'Select {field}',
                        array('{field}' => mb_strtolower($model->getAttributeLabel('role')))
                    ),
                    'source' => $model->getRoleList(),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'     => 'role',
                'type'     => 'raw',
                'value'    => '$data->getRole()',
                'filter'   => CHtml::activeDropDownList(
                    $model,
                    'role',
                    $model->getRoleList(),
                    array('class' => 'form-control', 'empty' => '')
                ),
            ),
            array(
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/blog/userToBlogBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    UserToBlog::STATUS_ACTIVE       => ['class' => 'label-success'],
                    UserToBlog::STATUS_BLOCK        => ['class' => 'label-default'],
                    UserToBlog::STATUS_CONFIRMATION => ['class' => 'label-info'],
                    UserToBlog::STATUS_DELETED      => ['class' => 'label-danger'],

                ],
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/blog/userToBlogBackend/inline'),
                    'mode'   => 'inline',
                    'title'  => Yii::t(
                        'BlogModule.blog',
                        'Select {field}',
                        array('{field}' => mb_strtolower($model->getAttributeLabel('note')))
                    ),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'     => 'note',
                'type'     => 'raw',
                'filter'   => CHtml::activeTextField($model, 'note', array('class' => 'form-control')),
            ),
            array(
                'name'  => 'create_date',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_date, "medium", "short")',
            ),
            array(
                'name'  => 'update_date',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->update_date, "medium", "short")',
            ),
            array(
                'class' => 'yupe\widgets\CustomButtonColumn',
            ),
        ),
    )
); ?>
