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
    Yii::t('SocialModule.social', 'Аккаунты')      => ['/social/socialBackend/index'],
    $model->id,
];

$this->pageTitle = Yii::t('social', 'Аккаунты - просмотр');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('SocialModule.social', 'Управление аккаунтами'),
        'url'   => ['/social/socialBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('SocialModule.social', 'Просмотреть аккаунт'),
        'url'   => [
            '/social/socialBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('SocialModule.social', 'Удалить аккаунт'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => ['/social/socialBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('SocialModule.social', 'Вы уверены, что хотите удалить аккаунт?'),
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('SocialModule.social', 'Просмотр') . ' ' . Yii::t('SocialModule.social', 'аккаунта'); ?><br/>
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
