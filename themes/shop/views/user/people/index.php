<?php
/**
 * @var CActiveForm $form
 */
$this->title = [Yii::t('UserModule.user', 'Users'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [
    Yii::t('UserModule.user', 'Users'),
];
?>
<div class="main__title grid">
    <h1 class="h2"><?= Yii::t('UserModule.user', 'Users'); ?></h1>
</div>
<div class="main__cart-box grid">
    <?php
    $form = $this->beginWidget('CActiveForm', ['method' => 'get']);
    ?>

    <div class="fast-order__inputs grid-module-5">
        <div class="column grid-module-3">
            <?= $form->textField($users, 'nick_name', [
                'class' => 'input input_big',
                'placeholder' => 'поиск по нику'
            ]); ?>
        </div>
        <div class="column grid-module-2 pull-right">
            <button class="btn btn_big btn_white" type="submit">Найти</button>
        </div>
    </div>


    <?php $this->endWidget(); ?>

    <?php
    $this->widget(
        'zii.widgets.grid.CGridView',
        [
            'dataProvider' => $provider,
            'template' => "{items}\n{pager}",
            'columns' => [
                [
                    'header' => false,
                    'value' => 'CHtml::link(CHtml::image($data->getAvatar(90), $data->getFullName(), array("width" => 90, "height" => 90)), array("/user/people/userInfo","username" => $data->nick_name))',
                    'type' => 'html'
                ],
                [
                    'name' => 'nick_name',
                    'header' => 'Пользователь',
                    'type' => 'html',
                    'value' => 'CHtml::link($data->nick_name, array("/user/people/userInfo","username" => $data->nick_name))'
                ],
                [
                    'name' => 'location',
                    'header' => 'Откуда'
                ],
                [
                    'header' => 'Был на сайте',
                    'name' => 'visit_time',
                    'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->visit_time, "long", false)'
                ],
                [
                    'header' => 'Присоеденился',
                    'name' => 'create_time',
                    'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_time, "long", false)'
                ]
            ]
        ]
    );
    ?>
</div>