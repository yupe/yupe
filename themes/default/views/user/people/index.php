<?php
$this->title = [Yii::t('UserModule.user', 'Users'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [
    Yii::t('UserModule.user', 'Users'),
];
?>

<h1><?= Yii::t('UserModule.user', 'Users'); ?></h1>

<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'method' => 'get',
        'type'   => 'vertical'
    ]
);
?>

<div class="row">
    <div class="col-sm-12">
        <div class="input-group">
            <?= $form->textField(
                $users,
                'nick_name',
                ['class' => 'form-control', 'placeholder' => 'поиск по нику',]
            ); ?>
            <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Найти</button>
                  </span>
        </div>
    </div>
</div>


<?php $this->endWidget(); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbGridView',
    [
        'dataProvider' => $provider,
        'type'         => 'condensed striped',
        'template'     => "{items}\n{pager}",
        'columns'      => [
            [
                'header' => false,
                'value'  => 'CHtml::link(CHtml::image($data->getAvatar(90), $data->getFullName(), array("width" => 90, "height" => 90)), array("/user/people/userInfo","username" => $data->nick_name))',
                'type'   => 'html'
            ],
            [
                'name'   => 'nick_name',
                'header' => 'Пользователь',
                'type'   => 'html',
                'value'  => 'CHtml::link($data->nick_name, array("/user/people/userInfo","username" => $data->nick_name))'
            ],
            [
                'name'   => 'location',
                'header' => 'Откуда'
            ],
            [
                'header' => 'Был на сайте',
                'name'   => 'visit_time',
                'value'  => 'Yii::app()->getDateFormatter()->formatDateTime($data->visit_time, "long", false)'
            ],
            [
                'header' => 'Присоеденился',
                'name'   => 'create_time',
                'value'  => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_time, "long", false)'
            ]
        ]
    ]
);
?>
