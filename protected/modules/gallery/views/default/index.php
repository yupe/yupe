<?php
/**
 * Отображение для default/index:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/

$this->breadcrumbs = array(
    Yii::app()->getModule('gallery')->getCategory() => array(),
    Yii::t('GalleryModule.gallery', 'Galleries') => array('/gallery/default/index'),
    Yii::t('GalleryModule.gallery', 'Management'),
);

$this->pageTitle = Yii::t('GalleryModule.gallery', 'Galleries - manage');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('GalleryModule.gallery', 'Gallery management'), 'url' => array('/gallery/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('GalleryModule.gallery', 'Create gallery'), 'url' => array('/gallery/default/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('GalleryModule.gallery', 'Galleries'); ?>
        <small><?php echo Yii::t('GalleryModule.gallery', 'management'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('GalleryModule.gallery', 'Find galleries'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript(
    'search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('gallery-grid', {
            data: $(this).serialize()
        });
        return false;
    });"
);
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('GalleryModule.gallery', 'This section describes image gallery management'); ?></p>

<?php $this->widget(
    'yupe\widgets\CustomGridView', array(
        'id'           => 'gallery-grid',
        'type'         => 'condensed',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            'id',
            'name',
            array(
                'name'   => 'owner',
                'filter' => $model->usersList,
                'value'  => '$data->ownerName',
            ),
            array(
                'type' => 'html',
                'name'  => 'description',
            ),
            array(
                'name'  => 'status',
                'value' => '$data->getStatus()'
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{images}{view}{update}{delete}',
                'buttons'  => array(
                    'images' => array(
                        'icon'     => 'picture',
                        'label'    => Yii::t('GalleryModule.gallery', 'Gallery images'),
                        'url'      => 'array("/gallery/default/images", "id" => $data->id)',
                    ),
                ),
                'htmlOptions' => array(
                    'style'   => 'width: 60px; text-align: right;'
                )
            ),
        ),
    )
); ?>