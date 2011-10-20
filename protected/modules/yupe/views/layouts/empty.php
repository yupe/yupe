<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"
          media="screen, projection"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
          media="print"/>
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection"/>
    <![endif]-->

    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"/>

    <script type='text/javascript'>
        var arrowimages = {down:['downarrowclass', '<?php echo Yii::app()->request->baseUrl;?>/web/images/down.gif', 23], right:['rightarrowclass', '<?php echo Yii::app()->request->baseUrl;?>/web/images/right.gif']}
    </script>

    <title><?php echo CHtml::encode(Yii::app()->name);?> <?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<script type='text/javascript'>
    $(document).ready(function() {
        $('input:submit').button();        
    });
</script>

<?php echo $content; ?>

</body>
</html>
