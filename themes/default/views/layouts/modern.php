
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bootstrap, from Twitter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
    </style>
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="../assets/ico/favicon.png">
</head>

<body>
<?php $this->widget('application.modules.yupe.widgets.YAdminPanel'); ?>

<?php $this->widget('application.modules.menu.widgets.MenuWidget', array('name' => 'top-menu' ));?>

<div class="container">

    <!-- Main hero unit for a primary marketing message or call to action -->
    <div class="hero-unit">
        <h1>Юпи!</h1>
        <p>Простая, легкая и удобная CMS на Yiiframework</p>
        <p><a href="#" class="btn btn-primary btn-large">ЗАГРУЗИТЬ</a></p>
    </div>

    <!-- Example row of columns -->
    <div class="row">
        <div class="span4">
            <h2>Пользователи</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        </div>
        <div class="span4">
            <h2>Страницы</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        </div>
        <div class="span4">
            <h2>Новости</h2>
            <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        </div>
    </div>

    <div class="row">
        <div class="span4">
            <h2>Блоги</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        </div>
        <div class="span4">
            <h2>Комментариии</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        </div>
        <div class="span4">
            <h2>Каталог</h2>
            <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        </div>
    </div>

    <div class="row">
        <div class="span6">
            <div class='alert alert-warning'>
                <p><b>По вопросам разработки и поддержки - <a href='http://yupe.ru/feedback/index/?from=mainpage-support' target='_blank'>напишите нам</a> !</b></p>
                <p>Читайте нас в <a href='http://twitter.com/yupecms' target='_blank'>twitter</a>, <a href='http://vk.com/amylabs' target='_blank'>Вконтакте</a>, <a href="https://www.facebook.com/amylabs.ru" target='_blank'>Facebook</a> или в <a href="https://plus.google.com/u/0/b/111468098477631231532/111468098477631231532/posts" target='_blank'>Google+</a></p>
            </div>
        </div>

        <div class="span6">
            <div class="alert alert-warning">
                <p>Помоги команде!</p>
                <p>Я.Деньгами на <b>41001846363811</b></p>
                <p>Webmoney на <b>R239262659267</b></p>
            </div>
         </div>
    </div>

    <hr>

    <footer>
        <p>
            &copy; <?php echo CHtml::link('amyLabs','http://amylabs.ru/?from=yupe-footer')?> && <strong>Юпи! team</strong> 2009 - <?php echo date('Y');?>
            <?php echo $this->yupe->poweredBy(); ?>
        </p>
    </footer>

</div> <!-- /container -->

</body>
</html>
