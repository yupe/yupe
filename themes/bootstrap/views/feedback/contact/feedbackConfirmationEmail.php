<html>
    <head>
        <title><?php echo Yii::t('feedback', 'Обратная связь на сайте {site} !', array('{site}' => CHtml::encode(Yii::app()->name))); ?></title>
    </head>
    <body>

        <?php echo Yii::t('feedback', 'Сообщение #{id} получено, спасибо!.', array('{id}' => $model->id)); ?>

        <br/><br/>

        <?php echo Yii::t('user', 'С уважением, администрация сайта {site} !', array('{site}' => CHtml::encode(Yii::app()->name))); ?>
    </body>
</html>