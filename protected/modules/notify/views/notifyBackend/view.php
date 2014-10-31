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
    $this->breadcrumbs = array(
        Yii::app()->getModule('notify')->getCategory() => array(),
        Yii::t('notify', 'Уведомления') => array('/notify/notifyBackend/index'),
        $model->id,
    );

    $this->pageTitle = Yii::t('notify', 'Уведомления - просмотр');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('notify', 'Управление уведомлением'), 'url' => array('/notify/notifyBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('notify', 'Добавить уведомление'), 'url' => array('/notify/notifyBackend/create')),
        array('label' => Yii::t('notify', 'Уведомление') . ' «' . mb_substr($model->id, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('notify', 'Редактирование уведомления'), 'url' => array(
            '/notify/notifyBackend/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('notify', 'Просмотреть уведомление'), 'url' => array(
            '/notify/notifyBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('notify', 'Удалить уведомление'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/notify/notifyBackend/delete', 'id' => $model->id),
            'confirm' => Yii::t('notify', 'Вы уверены, что хотите удалить уведомление?'),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('notify', 'Просмотр') . ' ' . Yii::t('notify', 'уведомления'); ?>        <br/>
        <small>&laquo;<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
'data'       => $model,
'attributes' => array(
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
),
)); ?>
