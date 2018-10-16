<html>

<head>
    <title><?= Yii::t(
            'UserModule.user',
            'You was successfully registered on "{site}" !',
            [
                '{site}' => CHtml::encode(
                    Yii::app()->getModule('yupe')->siteName
                ),
            ]
        ); ?></title>
</head>

<body>
<?= Yii::t(
    'UserModule.user',
    'You was successfully registered on "{site}" !',
    [
        '{site}' => CHtml::encode(
            Yii::app()->getModule('yupe')->siteName
        ),
    ]
); ?>

<br/><br/>

<?= Yii::t(
    'UserModule.user',
    'Truly yours, administration of "{site}" !',
    [
        '{site}' => CHtml::encode(
            Yii::app()->getModule('yupe')->siteName
        ),
    ]
); ?>

</body>

</html>
