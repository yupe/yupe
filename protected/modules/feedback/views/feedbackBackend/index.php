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
    'yupe\widgets\CustomGridView', array(
        'id'           => 'feed-back-list',
        'dataProvider' => $model->search(),
        'filter'  => $model,
        'columns' => array(
            array(
                'name' => 'id',
                'htmlOptions' => array('style' => 'width:20px'),
                'type' => 'raw',
                'value' => 'CHtml::link($data->id, array("/feedback/feedbackBackend/update", "id" => $data->id))'
            ),
            array(
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name'  => 'theme',
                'editable' => array(
                    'url' => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode' => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                )
            ),
            array(
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name'  => 'name',
                'editable' => array(
                    'url' => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode' => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                )
            ),
            array(
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name'  => 'email',
                'editable' => array(
                    'url' => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode' => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                )
            ),
            array(
                'class'  => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'  => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode' => 'popup',
                    'type' => 'select',
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
                    'url'  => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode' => 'popup',
                    'type' => 'select',
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
                'class'  => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'  => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode' => 'popup',
                    'type' => 'select',
                    'source' => $model->getIsFaqList(),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'   => 'is_faq',
                'type'   => 'raw',
                'value'  => '$data->getIsFaq()',
                'filter' => $model->getIsFaqList()
            ),
            'creation_date',
            'answer_date',
            array(
                'class'    => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{answer}{view}{update}{delete}',
                'buttons'  => array(
                    'answer' => array(
                        'label'   => false,
                        'url'     => 'Yii::app()->createUrl("/feedback/feedbackBackend/answer", array("id" => $data->id))',
                        'options' => array(
                            'class' => 'icon-envelope',
                            'title' => Yii::t('FeedbackModule.feedback', 'Messages - answer'),
                        ),
                    )
                )
            ),
        )
    )
); ?>

