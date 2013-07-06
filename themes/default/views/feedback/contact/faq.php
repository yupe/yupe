<?php $this->pageTitle = Yii::t('feedback', 'Вопросы и ответы'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('feedback', 'Вопросы и ответы'),
);
?>

<h1>
    <?php echo Yii::t('feedback', 'Вопросы и ответы')?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'htmlOptions' => array(
                'class' => 'btn btn-info'
            ),
            'buttonType' => 'link',
            'label' => Yii::t('UserModule.user', 'Задайте вопрос ?!'),
            'url' => Yii::app()->createUrl('/feedback/contact/index/'),
        )
    ); ?>
</h1>


<?php $this->widget('bootstrap.widgets.TbListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>