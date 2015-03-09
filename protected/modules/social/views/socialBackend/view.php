<?php
/**
 * Отображение для view:
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
    $model->id,
];

$this->pageTitle = Yii::t('social', 'Accounts - view');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('SocialModule.social', 'Manage social accounts'),
        'url'   => ['/social/socialBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('SocialModule.social', 'Viewing social account'),
        'url'   => [
            '/social/socialBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('SocialModule.social', 'Removing social account'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => ['/social/socialBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('SocialModule.social', 'Do you really want to remove this account?'),
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('SocialModule.social', 'Viewing social account'); ?><br/>
        <small>&laquo;<?php echo $model->provider; ?>&raquo; <?php echo $model->user->getFullName(); ?></small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'id',
            [
                'name'  => 'user_id',
                'value' => $model->user->getFullName()
            ],
            'provider',
            'uid',
        ],
    ]
); ?>
