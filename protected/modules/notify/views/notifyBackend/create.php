<?php
/**
 * Отображение для create:
 *
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <support@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     https://yupe.ru
 **/
    $this->breadcrumbs = [
        Yii::app()->getModule('notify')->getCategory() => [],
        Yii::t('NotifyModule.notify', 'Notify') => ['/notify/notifyBackend/index'],
        Yii::t('NotifyModule.notify', 'Creating'),
    ];

    $this->pageTitle = Yii::t('NotifyModule.notify', 'Notify - creating');

    $this->menu = [
        ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('NotifyModule.notify', 'Manage notify'), 'url' => ['/notify/notifyBackend/index']],
        ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('NotifyModule.notify', 'Create notify'), 'url' => ['/notify/notifyBackend/create']],
    ];
?>
<div class="page-header">
    <h1>
        <?=  Yii::t('NotifyModule.notify', 'Notify'); ?>
        <small><?=  Yii::t('NotifyModule.notify', 'creating'); ?></small>
    </h1>
</div>

<?=  $this->renderPartial('_form', ['model' => $model]); ?>