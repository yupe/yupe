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
    Yii::app()->getModule('social')->getCategory() => array(),
    Yii::t('SocialModule.social', 'Аккаунты')      => array('/social/socialBackend/index'),
    Yii::t('SocialModule.social', 'Управление'),
);

$this->pageTitle = Yii::t('SocialModule.social', 'Аккаунты - управление');

$this->menu = array(
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('SocialModule.social', 'Управление аккаунтами'),
        'url'   => array('/social/socialBackend/index')
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('SocialModule.social', 'Аккаунты'); ?>
        <small><?php echo Yii::t('SocialModule.social', 'управление'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('SocialModule.social', 'Поиск аккаунтов'); ?>
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
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'social-user-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'bulkActions'  => array(false),
        'columns'      => array(
            array(
                'name'   => 'user_id',
                'value'  => '$data->user->getFullName()',
                'filter' => CHtml::listData(User::model()->findAll(), 'id', 'fullName')
            ),
            'provider',
            'uid',
            array(
                'class'    => 'yupe\widgets\CustomButtonColumn',
                'template' => '{view}{delete}'
            ),
        ),
    )
); ?>
