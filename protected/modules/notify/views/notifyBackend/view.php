<?php
/**
 * Отображение для view:
 *
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
    $this->breadcrumbs = [
        Yii::app()->getModule('notify')->getCategory() => [],
        Yii::t('notify', 'Уведомления') => ['/notify/notifyBackend/index'],
        $model->id,
    ];

    $this->pageTitle = Yii::t('notify', 'Уведомления - просмотр');

    $this->menu = [
        ['icon' => 'list-alt', 'label' => Yii::t('notify', 'Управление уведомлением'), 'url' => ['/notify/notifyBackend/index']],
        ['icon' => 'plus-sign', 'label' => Yii::t('notify', 'Добавить уведомление'), 'url' => ['/notify/notifyBackend/create']],
        ['label' => Yii::t('notify', 'Уведомление') . ' «' . mb_substr($model->id, 0, 32) . '»'],
        ['icon' => 'pencil', 'label' => Yii::t('notify', 'Редактирование уведомления'), 'url' => [
            '/notify/notifyBackend/update',
            'id' => $model->id
        ]],
        ['icon' => 'eye-open', 'label' => Yii::t('notify', 'Просмотреть уведомление'), 'url' => [
            '/notify/notifyBackend/view',
            'id' => $model->id
        ]],
        ['icon' => 'trash', 'label' => Yii::t('notify', 'Удалить уведомление'), 'url' => '#', 'linkOptions' => [
            'submit' => ['/notify/notifyBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('notify', 'Вы уверены, что хотите удалить уведомление?'),
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
        ]],
    ];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('notify', 'Просмотр') . ' ' . Yii::t('notify', 'уведомления'); ?>        <br/>
        <small>&laquo;<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', [
'data'       => $model,
'attributes' => [
    [
        'name'  => 'user_id',
        'value' => function($model) {
                return $model->user->getFullName();
            }
    ],
    [
        'name'  => 'my_post',
        'value' => function($model) {
                return $model->my_post ? Yii::t('YupeModule.yupe', 'yes') : Yii::t('YupeModule.yupe', 'no');
            },
    ],
    [
        'name'  => 'my_comment',
        'value' => function($model) {
                return $model->my_comment ? Yii::t('YupeModule.yupe', 'yes') : Yii::t('YupeModule.yupe', 'no');
            },
    ],
],
]); ?>
