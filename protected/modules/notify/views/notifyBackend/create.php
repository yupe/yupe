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
    $this->breadcrumbs = array(
        Yii::app()->getModule('notify')->getCategory() => array(),
        Yii::t('notify', 'Уведомления') => array('/notify/notifyBackend/index'),
        Yii::t('notify', 'Добавление'),
    );

    $this->pageTitle = Yii::t('notify', 'Уведомления - добавление');

    $this->menu = array(
        array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('notify', 'Управление уведомлением'), 'url' => array('/notify/notifyBackend/index')),
        array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('notify', 'Добавить уведомление'), 'url' => array('/notify/notifyBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('notify', 'Уведомления'); ?>
        <small><?php echo Yii::t('notify', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>