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
    Yii::t('BlogModule.blog', 'Members') => array('/blog/userToBlogBackend/index'),
    Yii::t('BlogModule.blog', 'Administration'),
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Members - administration');

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
        <?php echo Yii::t('BlogModule.blog', 'Members'); ?>
        <small><?php echo Yii::t('BlogModule.blog', 'administration'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('BlogModule.blog', 'Find members'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript(
    'search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('user-to-blog-grid', {
            data: $(this).serialize()
        });
        return false;
    });"
);
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('BlogModule.blog', 'In this category located member administration functions'); ?></p>

<?php $this->widget(
    'yupe\widgets\CustomGridView', array(
        'id'           => 'user-to-blog-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
			array(
				'name'        => 'id',
				'type'        => 'raw',
				'value'       => 'CHtml::link($data->id, array("/blog/userToBlogBackend/update", "id" => $data->id))',
				'htmlOptions' => array(
					'style' => 'width:10px;'
				)
			),
            array(
                'name'   => 'user_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->user->getFullName(), array("/user/userBackend/view", "id" => $data->user->id))',
                'filter' => CHtml::listData(User::model()->cache($this->yupe->coreCacheTime)->findAll(),'id','nick_name')
            ),
            array(
                'name'   => 'blog_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->blog->name, array("/blog/blogBackend/view", "id" => $data->blog->id))',
                'filter' => CHtml::listData(Blog::model()->cache($this->yupe->coreCacheTime)->findAll(),'id','name')
            ),
            array(
                'class'  => 'bootstrap.widgets.TbEditableColumn',
				'editable' => array(
					'url'    => $this->createUrl('/blog/userToBlogBackend/inline'),
					'mode'   => 'popup',
					'type'   => 'select',
					'title'  => Yii::t('BlogModule.blog', 'Select {field}', array('{field}' => mb_strtolower($model->getAttributeLabel('role')))),
					'source' => $model->getRoleList(),
					'params' => array(
						Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
					)
				),
                'name'   => 'role',
                'type'   => 'raw',
                'value'  => '$data->getRole()',
                'filter' => $model->getRoleList()
            ),
            array(
                'class'  => 'bootstrap.widgets.TbEditableColumn',
				'editable' => array(
					'url'    => $this->createUrl('/blog/userToBlogBackend/inline'),
					'mode'   => 'popup',
					'type'   => 'select',
					'title'  => Yii::t('BlogModule.blog', 'Select {field}', array('{field}' => mb_strtolower($model->getAttributeLabel('status')))),
					'source' => $model->getStatusList(),
					'params' => array(
						Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
					)
				),
                'name'   => 'status',
                'type'   => 'raw',
                'value'  => '$data->getStatus()',
                'filter' => $model->getStatusList()
            ),
			array(
				'class'    => 'bootstrap.widgets.TbEditableColumn',
				'editable' => array(
					'url'    => $this->createUrl('/blog/userToBlogBackend/inline'),
					'mode'   => 'inline',
					'title'  => Yii::t('BlogModule.blog', 'Select {field}', array('{field}' => mb_strtolower($model->getAttributeLabel('note')))),
					'params' => array(
						Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
					)
				),
				'name'     => 'note',
				'type'     => 'raw',
			),
            array(
                'name'  => 'create_date',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_date, "medium", "short")',
            ),
            array(
                'name'  => 'update_date',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->update_date, "short", "short")',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>