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
$this->breadcrumbs = array(
    Yii::app()->getModule('notify')->getCategory() => array(),
    Yii::t('notify', 'Уведомления') => array('/notify/notifyBackend/index'),
    Yii::t('notify', 'Управление'),
);

$this->pageTitle = Yii::t('notify', 'Уведомления - управление');

$this->menu = array(
    array(
        'icon' => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('notify', 'Управление уведомлением'),
        'url' => array('/notify/notifyBackend/index')
    ),
    array(
        'icon' => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('notify', 'Добавить уведомление'),
        'url' => array('/notify/notifyBackend/create')
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('notify', 'Уведомления'); ?>
        <small><?php echo Yii::t('notify', 'управление'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('notify', 'Поиск увеломления'); ?>
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
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<br/>

<p> <?php echo Yii::t('notify', 'В данном разделе представлены средства управления уведомлением'); ?>
</p>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    array(
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
        'columns' => array(
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
            array(
                'class' => 'yupe\widgets\CustomButtonColumn',
            ),
        ),
    )
); ?>
