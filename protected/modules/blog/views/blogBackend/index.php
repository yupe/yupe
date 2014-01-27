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
        'type'             => 'condensed',
        /**
         *  headlinePosition:
         *      YCustomGridView::HP_RIGHT - for default right position
         *      YCustomGridView::HP_LEFT  - for left position
         **/
        //'headlinePosition' => YCustomGridView::HP_RIGHT,
        'dataProvider'     => $model->search(),
        'filter'           => $model,
        /**
        *   Можно указать количество прямо из вызова виджета:
        **/
        //'pageSizes'      => array(1, 3, 5, 10),
        'bulkActions'      => array(
            /* Массив кнопок действий: */
            'actionButtons' => array(
                array(
                    'id'         => 'delete-post',
                    'buttonType' => 'button',
                    'type'       => 'danger',
                    'size'       => 'small',
                    'label'      => Yii::t('BlogModule.blog', 'Remove'),
                    /**
                     *   Логика следующая - получаем массив выбранных эллементов в переменную values,
                     *   далее передаём в функцию multiaction - необходимое действие и эллементы.
                     *   Multiaction - делает ajax-запрос на actionMultiaction, где уже происходит
                     *   обработка данных (указывая собственные действия - необходимо создавать их
                     *   обработчики в actionMultiaction):
                     **/
                    'click'      => 'js:function(values){ if(!confirm("' . Yii::t('BlogModule.blog', 'Do you really want to delete selected items?') . '")) return false; multiaction("delete", values); }',
                ),
            ),
            // if grid doesn't have a checkbox column type, it will attach
            // one and this configuration will be part of it
            'checkBoxColumnConfig' => array(
                'name' => 'id'
            ),
        ),
        'columns'      => array(
            array(
                'name'   => 'icon',
                'header' => false,
                'type'   => 'raw',
                'value'  => 'CHtml::image($data->getImageUrl(), $data->name, array("width"  => 64, "height" => 64))',
                'filter' => false
            ),         
            array(
                'name'  => 'name',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->name, array("/blog/blogBackend/update", "id" => $data->id))',
            ),
            array(
                'name'  => 'slug',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->slug, array("/blog/blogBackend/update", "id" => $data->id))',
            ),
            array(
                'name'  => 'type',
                'type'  => 'raw',
                'value'  => '$this->grid->returnBootstrapStatusHtml($data, "type", "Type", array(1 => "globe", 2 => "home"))',
                'filter' => $model->getTypeList()
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
                'name'  => 'status',
                'type'  => 'raw',
                'value'  => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("lock", "ok-sign", "remove"))',
                'filter' => $model->getStatusList()
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