<?php
/**
 * Отображение для create:
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
        Yii::t('notify', 'Добавление'),
    ];

    $this->pageTitle = Yii::t('notify', 'Уведомления - добавление');

    $this->menu = [
        ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('notify', 'Управление уведомлением'), 'url' => ['/notify/notifyBackend/index']],
        ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('notify', 'Добавить уведомление'), 'url' => ['/notify/notifyBackend/create']],
    ];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('notify', 'Уведомления'); ?>
        <small><?php echo Yii::t('notify', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>