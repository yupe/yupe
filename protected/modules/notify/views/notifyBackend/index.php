<?php
/**
 * Отображение для index:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->breadcrumbs = [
    Yii::app()->getModule('notify')->getCategory() => [],
    Yii::t('NotifyModule.notify', 'Notify') => ['/notify/notifyBackend/index'],
    Yii::t('NotifyModule.notify', 'Manage'),
];

$this->pageTitle = Yii::t('NotifyModule.notify', 'Notify - manage');

$this->menu = [
    [
        'icon' => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('NotifyModule.notify', 'Manage notify'),
        'url' => ['/notify/notifyBackend/index']
    ],
    [
        'icon' => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('NotifyModule.notify', 'Create notify'),
        'url' => ['/notify/notifyBackend/create']
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('NotifyModule.notify', 'Notify'); ?>
        <small><?php echo Yii::t('NotifyModule.notify', 'manage'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('NotifyModule.notify', 'Search notify'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
           $('.search-form form').submit(function () {
               $.fn.yiiGridView.update('notify-settings-grid', {
                   data: $(this).serialize()
               });

               return false;
           });
       "
    );
    $this->renderPartial('_search', ['model' => $model]);
    ?>
</div>

<br/>

<p> <?php echo Yii::t('NotifyModule.notify', 'This section presents notification management tools.'); ?>
</p>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'notify-settings-grid',
        'type' => 'striped condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'actionsButtons'    => [
            CHtml::link(
                Yii::t('NotifyModule.notify', 'Add'),
                ['/notify/notifyBackend/create'],
                ['class' => 'btn btn-success pull-right btn-sm']
            )
        ],
        'columns' => [
            [
                'name'  => 'user_id',
                'value' => function($data) {
                        return $data->user->getFullName();
                    },
                'filter' => CHtml::listData(User::model()->findAll(), 'id', 'fullName')
            ],
            [
                'name'  => 'my_post',
                'value' => function($data) {
                        return $data->my_post ? Yii::t('YupeModule.yupe', 'yes') : Yii::t('YupeModule.yupe', 'no');
                    },
                'filter' => $this->module->getChoice()
            ],
            [
                'name'  => 'my_comment',
                'value' => function($data) {
                        return $data->my_comment ? Yii::t('YupeModule.yupe', 'yes') : Yii::t('YupeModule.yupe', 'no');
                    },
                'filter' => $this->module->getChoice()
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
