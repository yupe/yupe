<?php
/**
 * Отображение для blogBackend/index:
 * 
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
    $this->breadcrumbs = array(       
        Yii::t('BlogModule.blog', 'Blogs') => array('/blog/blogBackend/index'),
        Yii::t('BlogModule.blog', 'Administration'),
    );

    $this->pageTitle = Yii::t('BlogModule.blog', 'Blogs - administration');

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
        <?php echo Yii::t('BlogModule.blog', 'Blogs'); ?>
        <small><?php echo Yii::t('BlogModule.blog', 'Administration'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('BlogModule.blog', 'Find a blog'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript(
    'search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('blog-grid', {
            data: $(this).serialize()
        });
        return false;
    });"
);
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('BlogModule.blog', 'This category contains blog management functions.'); ?></p>
<?php $this->widget(
    'yupe\widgets\CustomGridView', array(
        'id'               => 'blog-grid',
        'dataProvider'     => $model->search(),
        'filter'           => $model,
        'columns' => array(
            array(
                'name'  => 'id',
                'value' => 'CHtml::link($data->id, array("/blog/blogBackend/update","id" => $data->id))',
                'type'  => 'html',
                'htmlOptions' => array('style' => 'width:10px'),
            ),
            array(
                'name'   => 'icon',
                'header' => false,
                'type'   => 'raw',
                'value'  => 'CHtml::image($data->getImageUrl(), $data->name, array("width"  => 64, "height" => 64))',
                'filter' => false
            ),
            array(
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name'  => 'name',
                'editable' => array(
                    'url' => $this->createUrl('/blog/blogBackend/inline'),
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
                    'url' => $this->createUrl('/blog/blogBackend/inline'),
                    'mode' => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                )
            ),
            array(
                'class'  => 'bootstrap.widgets.TbEditableColumn',
				'editable' => array(
					'url'    => $this->createUrl('/blog/blogBackend/inline'),
					'mode'   => 'popup',
					'type'   => 'select',
					'title'  => Yii::t('BlogModule.blog', 'Select {field}', array('{field}' => mb_strtolower($model->getAttributeLabel('type')))),
					'source' => $model->getTypeList(),
					'params' => array(
						Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
					)
				),
                'name'   => 'type',
                'type'   => 'raw',
                'value'  => '$data->getType()',
                'filter' => $model->getTypeList()
            ),
            array(
                'class'  => 'bootstrap.widgets.TbEditableColumn',
				'editable' => array(
					'url'    => $this->createUrl('/blog/blogBackend/inline'),
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
                'name'  => 'category_id',
                'value'  => 'empty($data->category) ? "---" : $data->category->name',
				'filter' => CHtml::activeDropDownList($model, 'category_id', Category::model()->getFormattedList(Yii::app()->getModule('blog')->mainCategory), array('encode' => false, 'empty' => ''))
            ),
            array(
                'name'   => 'create_user_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->createUser->getFullName(), array("/user/userBackend/view", "id" => $data->createUser->id))',
                'filter' => CHtml::listData(User::model()->findAll(),'id','nick_name')
            ),
            array(
                'name'   => 'create_date',
                'value'  => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_date, "short", "short")',
                'filter' => false
            ),
            array(
                'header' => Yii::t('BlogModule.blog', 'Posts'),
                'value'  => 'CHtml::link($data->postsCount, array("/blog/postBackend/index","Post[blog_id]" => $data->id ))',
                'type'   => 'html'
            ),
            array(
                'header' => Yii::t('BlogModule.blog', 'Members'),
                'value'  => 'CHtml::link($data->membersCount, array("/blog/userToBlogBackend/index","UserToBlog[blog_id]" => $data->id ))',
                'type'   => 'html'
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>