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
    Yii::t('MailModule.mail', 'Mail events') => array('index'),
    Yii::t('MailModule.mail', 'List'),
);
$this->pageTitle = Yii::t('MailModule.mail', 'Events list');

$this->menu = array(
    array('label' => Yii::t('MailModule.mail', 'Mail events')),
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('MailModule.mail', 'Messages list'),
        'url'   => array('/mail/eventBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('MailModule.mail', 'Create event'),
        'url'   => array('/mail/eventBackend/create')
    ),
    array('label' => Yii::t('MailModule.mail', 'Mail templates')),
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('MailModule.mail', 'Templates list'),
        'url'   => array('/mail/templateBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('MailModule.mail', 'Create template'),
        'url'   => array('/mail/templateBackend/create')
    ),
);

Yii::app()->clientScript->registerScript(
    'search',
    "
    $('.search-button').click(function () {
    	$('.search-form').toggle();
    	return false;
    });
    $('.search-form').submit(function () {
    	$.fn.yiiGridView.update('mail-event-grid', {
    		data: $(this).serialize()
    	});
    	return false;
    });"
);

?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'Mail events'); ?>
        <small><?php echo Yii::t('MailModule.mail', 'management'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('MailModule.mail', 'Find mail messages'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form').submit(function () {
        $.fn.yiiGridView.update('mail-event-grid', {
            data: $(this).serialize()
        });

        return false;
    });"
    );

    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'             => 'mail-event-grid',
        'dataProvider'   => $model->search(),
        'filter'         => $model,
        'actionsButtons' => [
            CHtml::link(
                Yii::t('YupeModule.yupe', 'Add'),
                ['/mail/eventBackend/create'],
                ['class' => 'btn btn-success pull-right btn-sm']
            )
        ],
        'columns'        => array(
            array(
                'name'        => 'id',
                'type'        => 'raw',
                'value'       => 'CHtml::link($data->id, array("/mail/eventBackend/update", "id" => $data->id))',
                'htmlOptions' => array('style' => 'width:20px'),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'code',
                'editable' => array(
                    'url'    => $this->createUrl('/mail/eventBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'code', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => array(
                    'url'    => $this->createUrl('/mail/eventBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'name', array('class' => 'form-control')),
            ),
            array(
                'class'       => 'bootstrap.widgets.TbEditableColumn',
                'name'        => 'description',
                'value'       => '$data->shortDescription;',
                'editable'    => array(
                    'url'    => $this->createUrl('/mail/eventBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'textarea',
                    'title'  => Yii::t(
                        'MailModule.mail',
                        'Select {field}',
                        array('{field}' => mb_strtolower($model->getAttributeLabel('description')))
                    ),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'htmlOptions' => array(
                    'style' => 'width: 20%;'
                ),
                'filter'      => CHtml::activeTextField($model, 'description', array('class' => 'form-control')),
            ),
            array(
                'header' => Yii::t('MailModule.mail', 'Templates'),
                'type'   => 'raw',
                'value'  => 'CHtml::link(count($data->templates), array("/mail/templateBackend/index/", "event" => $data->id))',
            ),
            array(
                'class'    => 'yupe\widgets\CustomButtonColumn',
                'template' => '{view}{update}{delete}{add}',
                'buttons'  => array(
                    'add' => array(
                        'icon'  => 'fa fa-fw fa-plus-square',
                        'label' => Yii::t('MailModule.mail', 'Create mail template'),
                        'url'   => 'Yii::app()->createUrl("/mail/templateBackend/create/", array("eid" => $data->id))',
                    )
                )
            ),
        ),
    )
); ?>
