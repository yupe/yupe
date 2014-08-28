<?php
$this->breadcrumbs = array(
    Yii::t('MailModule.mail', 'Mail events')    => array('/mail/eventBackend/index'),
    Yii::t('MailModule.mail', 'Mail templates') => array('index'),
    Yii::t('MailModule.mail', 'Management'),
);
$this->pageTitle = Yii::t('MailModule.mail', 'Mail templates list');

$this->menu = array(
    array('label' => Yii::t('MailModule.mail', 'Mail templates')),
    array(
        'icon'  => 'glyphicon glyphicon-list-alt',
        'label' => Yii::t('MailModule.mail', 'Templates list'),
        'url'   => array('/mail/templateBackend/index')
    ),
    array(
        'icon'  => 'glyphicon glyphicon-plus-sign',
        'label' => Yii::t('MailModule.mail', 'Create template'),
        'url'   => array('/mail/templateBackend/create')
    ),
    array('label' => Yii::t('MailModule.mail', 'Mail events')),
    array(
        'icon'  => 'glyphicon glyphicon-list-alt',
        'label' => Yii::t('MailModule.mail', 'Messages list'),
        'url'   => array('/mail/eventBackend/index')
    ),
    array(
        'icon'  => 'glyphicon glyphicon-plus-sign',
        'label' => Yii::t('MailModule.mail', 'Create event'),
        'url'   => array('/mail/eventBackend/create')
    ),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'Mail templates'); ?>
        <small><?php echo Yii::t('MailModule.mail', 'management'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="glyphicon glyphicon-search">&nbsp;</i>
        <?php echo Yii::t('MailModule.mail', 'Find mail templates'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out">
    <?php Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form').submit(function () {
        $.fn.yiiGridView.update('mail-template-grid', {
            data: $(this).serialize()
        });

        return false;
    });
"
    );

    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<p>
    <?php echo Yii::t('MailModule.mail', 'This section contain mail message templates management'); ?>
</p>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'mail-template-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'actionsButtons' => [
            CHtml::link(
                Yii::t('YupeModule.yupe', 'Add'),
                ['/mail/templateBackend/create'],
                ['class' => 'btn btn-success pull-right btn-sm']
            )
        ],
        'columns'      => array(
            array(
                'name'        => 'id',
                'type'        => 'raw',
                'value'       => 'Chtml::link($data->id, array("/mail/templateBackend/update", "id" => $data->id))',
                'htmlOptions' => array('style' => 'width:20px'),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => array(
                    'url'    => $this->createUrl('/mail/templateBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'name', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'code',
                'editable' => array(
                    'url'    => $this->createUrl('/mail/templateBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'code', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/mail/templateBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                            'MailModule.mail',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('event_id')))
                        ),
                    'source' => CHtml::listData(MailEvent::model()->findAll(), 'id', 'name'),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'     => 'event_id',
                'type'     => 'raw',
                'value'    => '$data->event->name',
                'filter'   => CHtml::activeDropDownList(
                        $model,
                        'event_id',
                        CHtml::listData(MailEvent::model()->findAll(), 'id', 'name'),
                        array('class' => 'form-control', 'empty' => '')
                    ),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'theme',
                'editable' => array(
                    'url'    => $this->createUrl('/mail/templateBackend/inline'),
                    'mode'   => 'inline',
                    'type'   => 'text',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'theme', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'from',
                'editable' => array(
                    'url'    => $this->createUrl('/mail/templateBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'from', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'to',
                'editable' => array(
                    'url'    => $this->createUrl('/mail/templateBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'to', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/mail/templateBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                            'MailModule.mail',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('status')))
                        ),
                    'source' => $model->getStatusList(),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'     => 'status',
                'type'     => 'raw',
                'value'    => '$data->getStatus()',
                'filter'   => CHtml::activeDropDownList(
                        $model,
                        'status',
                        $model->getStatusList(),
                        array('class' => 'form-control', 'empty' => '')
                    ),
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
