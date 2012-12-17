<html>
    <head>
        <title><?php echo Yii::t('feedback', 'Обратная связь на сайте {site} !', array('{site}' => CHtml::encode(Yii::app()->name))); ?></title>
    </head>
    <body>

        <?php echo Yii::t('feedback', '{name}, Ваше сообщение получено, ему присвоен номер {id}, спасибо!', array('{name}' => $model->name,'{id}' => $model->id)); ?>

        <br/><br/>
        
        <?php echo Yii::t('feedback', 'Мы ответим Вам в самое ближайшее время!'); ?>
        
        <br/></br>
        
        <br/></br>

        <?php echo Yii::t('user', 'С уважением, администрация сайта "{site}" !', array('{site}' => CHtml::encode(Yii::app()->name))); ?>
    </body>
</html>