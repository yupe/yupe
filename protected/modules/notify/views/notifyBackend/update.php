<?php
/**
 * Отображение для update:
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
        $model->id => ['/notify/notifyBackend/view', 'id' => $model->id],
        Yii::t('notify', 'Редактирование'),
    ];

    $this->pageTitle = Yii::t('notify', 'Уведомления - редактирование');

    $this->menu = [
        ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('notify', 'Управление уведомлением'), 'url' => ['/notify/notifyBackend/index']],
        ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('notify', 'Добавить уведомление'), 'url' => ['/notify/notifyBackend/create']],
        ['label' => Yii::t('notify', 'Уведомление') . ' «' . mb_substr($model->id, 0, 32) . '»'],
        ['icon' => 'fa fa-fw fa-pencil', 'label' => Yii::t('notify', 'Редактирование уведомления'), 'url' => [
            '/notify/notifyBackend/update',
            'id' => $model->id
        ]],
        ['icon' => 'fa fa-fw fa-eye', 'label' => Yii::t('notify', 'Просмотреть уведомление'), 'url' => [
            '/notify/notifyBackend/view',
            'id' => $model->id
        ]],
        ['icon' => 'fa fa-fw fa-trash-o', 'label' => Yii::t('notify', 'Удалить уведомление'), 'url' => '#', 'linkOptions' => [
            'submit' => ['/notify/notifyBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('notify', 'Вы уверены, что хотите удалить уведомление?'),
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
        ]],
    ];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('notify', 'Редактирование') . ' ' . Yii::t('notify', 'уведомления'); ?>        <br/>
        <small>&laquo;<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>