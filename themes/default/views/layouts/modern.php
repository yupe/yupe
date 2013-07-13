
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
    <div class="row">
            <div class="hero-unit">
                <h1>Юпи!</h1>
                <p>Простая, легкая и удобная CMS на Yiiframework</p>
                <p>
                    <a href="http://yupe.ru/downloads/" class="btn btn-primary btn-large">ЗАГРУЗИТЬ v0.5.3</a>
                    <a href="http://yupe.ru/docs/" class="btn btn-success btn-large">ДОКУМЕНТАЦИЯ</a>            
                </p>        
            </div>
    </div>

    <!-- Example row of columns -->
    <div class="row">
        <div class='span12'>
            <p>
            <iframe src="http://ghbtns.com/github-btn.html?user=yupe&repo=yupe&type=watch&count=true&size=large"
  allowtransparency="true" frameborder="0" scrolling="0" width="170" height="30"></iframe>
   <iframe src="http://ghbtns.com/github-btn.html?user=yupe&repo=yupe&type=fork&count=true&size=large"
  allowtransparency="true" frameborder="0" scrolling="0" width="170" height="30"></iframe>
  <iframe src="http://ghbtns.com/github-btn.html?user=yupe&repo=yupe&type=follow&count=true&size=large"
  allowtransparency="true" frameborder="0" scrolling="0" width="170" height="30"></iframe>
        </p>
        </div> 
        <div class="span4">
            <h2><i class="icon icon-user"></i> Пользователи</h2>
            <p>Регистрация, авторизация, восстановление пароля, управление и блокировка пользователей</p>
        </div>
        <div class="span4">
            <h2><i class="icon icon-file"></i> Страницы</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        </div>
        <div class="span4">
            <h2><i class="icon icon-leaf"></i> Новости</h2>
            <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        </div>
    </div>

    <div class="row">
        <div class="span4">
            <h2><i class="icon icon-pencil"></i> Блоги</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        </div>
        <div class="span4">
            <h2><i class="icon icon-comment"></i> Комментариии</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        </div>
        <div class="span4">            
            <h2><i class="icon icon-shopping-cart"></i> Каталог</h2>
            <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        </div>
    </div>

    <div class="row">
        <div class="span6">
            <div class='alert alert-warning'>
                <p><b>По вопросам разработки и поддержки - <a href='http://yupe.ru/feedback/index/?from=mainpage-support' target='_blank'>напишите нам</a> !</b></p>
                <p>Читайте нас в <a href='http://twitter.com/yupecms' target='_blank'>twitter</a>, <a href='http://vk.com/amylabs' target='_blank'>Вконтакте</a>, <a href="https://www.facebook.com/amylabs.ru" target='_blank'>Facebook</a> или в <a href="https://plus.google.com/u/0/b/111468098477631231532/111468098477631231532/posts" target='_blank'>Google+</a></p>
                <p>&nbsp;</p>
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

  <div class="row-fluid">
        <div class="span12">
            <div class="span3">
                <ul class="unstyled">
                    <li>Ресурсы<li>
                    <li><a href="http://yupe.ru/?from=help">Сайт</a></li>
                    <li><a href="http://yupe.ru/blog/yupe-mini-cms-yii">Блог</a></li>
                    <li><a href="http://yupe.ru/docs/index.html?from=login">Документация</a></li>
                    <li><a href="http://yupe.ru/talk/">Форум</a></li>
                    <li><a href="https://twitter.com/yupecms">Twitter</a></li>
                </ul>
            </div>
            <div class="span3">
                <ul class="unstyled">
                    <li>Applications<li>
                    <li><a href="#">Product for Mac</a></li>
                    <li><a href="#">Product for Windows</a></li>
                    <li><a href="#">Product for Eclipse</a></li>
                    <li><a href="#">Product mobile apps</a></li>
                </ul>
            </div>
            <div class="span3">
                <ul class="unstyled">
                    <li>Services<li>
                    <li><a href="#">Web analytics</a></li>
                    <li><a href="#">Presentations</a></li>
                    <li><a href="#">Code snippets</a></li>
                    <li><a href="#">Job board</a></li>
                </ul>
            </div>
            <div class="span3">
                <ul class="unstyled">
                    <li>Documentation<li>
                    <li><a href="#">Product Help</a></li>
                    <li><a href="#">Developer API</a></li>
                    <li><a href="#">Product Markdown</a></li>
                    <li><a href="#">Product Pages</a></li>
                </ul>
            </div>                  
        </div>
    </div>
    <hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="span8">
                <?php echo CHtml::link('Разработка и поддержка интернет-проектов', 'http://amylabs.ru?from=yupe');?>
            </div>
            <div class="span4">
                <p class="muted pull-right">© 2009 - <?php echo date('Y');?> <?php echo CHtml::link('amyLabs','http://amylabs.ru?from=yupe');?> && Юпи! team <?php echo Yii::app()->getModule('yupe')->poweredBy();?></p>
            </div>
        </div>
    </div>
</div>

</div> <!-- /container -->
</body>
</html>
