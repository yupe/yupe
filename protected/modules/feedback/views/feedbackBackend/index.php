<?php
$this->breadcrumbs = array(   
    Yii::t('FeedbackModule.feedback', 'Messages ') => array('/feedback/feedbackBackend/index'),
    Yii::t('FeedbackModule.feedback', 'Management'),
);

$this->pageTitle = Yii::t('FeedbackModule.feedback', 'Messages - manage');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('FeedbackModule.feedback', 'Messages management'), 'url' => array('/feedback/feedbackBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('FeedbackModule.feedback', 'Create message '), 'url' => array('/feedback/feedbackBackend/create')),
);
$assets = Yii::app()->getAssetManager()->publish(
    Yii::getPathOfAlias('feedback.views.assets')
);
Yii::app()->getClientScript()->registerScriptFile($assets . '/js/feedback.js');
Yii::app()->getClientScript()->registerCssFile($assets . '/css/feedback.css');
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('FeedbackModule.feedback', 'Messages '); ?>
        <small><?php echo Yii::t('FeedbackModule.feedback', 'management'); ?></small>
    </h1>
</div>

<div class="row-fluid">
    <button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="icon-search">&nbsp;</i>
        <?php echo CHtml::link(Yii::t('FeedbackModule.feedback', 'Find messages'), '#', array('class' => 'search-button')); ?>
        <span class="caret">&nbsp;</span>
    </button>

    <div id="search-toggle" class="collapse out search-form">
        <?php
            Yii::app()->clientScript->registerScript('search', "
                $('.search-form form').submit(function() {
                    $.fn.yiiListView.update('feed-back-list', {
                        data: $(this).serialize()
                    });
                    return false;
                });
                $('.search-form form [type=reset]').click(function() {
                    $.fn.yiiListView.update('feed-back-list', {
                        data: $(this).serialize()
                    });
                    return false;
                });
            ");
            $this->renderPartial('_search', array('model' => $model));
        ?>
    </div>
</div>

<!-- <p><?php echo Yii::t('FeedbackModule.feedback', 'This section represent feedback management'); ?></p> -->

<?php $this->widget(
    'yupe\widgets\CustomListView', array(
        'id'           => 'feed-back-list',
        'dataProvider' => $model->search(),
        'itemView'     => '_view',
        'sortableAttributes'=>array(
            'creation_date',
            'status',
            'theme',
            'category_id',
            'is_faq'
         ),
    )
); ?>

