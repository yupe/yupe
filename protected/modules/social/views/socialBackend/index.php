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
    Yii::app()->getModule('social')->getCategory() => [],
    Yii::t('SocialModule.social', 'Accounts')      => ['/social/socialBackend/index'],
    Yii::t('SocialModule.social', 'Manage'),
];

$this->pageTitle = Yii::t('SocialModule.social', 'Accounts - manage');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('SocialModule.social', 'Manage social accounts'),
        'url'   => ['/social/socialBackend/index']
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('SocialModule.social', 'Accounts'); ?>
        <small><?php echo Yii::t('SocialModule.social', 'manage'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('SocialModule.social', 'Account search'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('social-user-grid', {
            data: $(this).serialize()
        });

        return false;
    });
    "
    );
    $this->renderPartial('_search', ['model' => $model]);
    ?>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'           => 'social-user-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'bulkActions'  => [false],
        'actionsButtons' => false,
        'columns'      => [
            [
                'name'   => 'user_id',
                'value'  => '$data->user->getFullName()',
                'filter' => CHtml::listData(User::model()->findAll(), 'id', 'fullName')
            ],
            'provider',
            'uid',
            [
                'class'    => 'yupe\widgets\CustomButtonColumn',
                'template' => '{view}{delete}'
            ],
        ],
    ]
); ?>
