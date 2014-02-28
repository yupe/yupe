<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>" xmlns="http://www.w3.org/1999/html">
<head prefix="og: http://ogp.me/ns#
    fb: http://ogp.me/ns/fb#
    article: http://ogp.me/ns/article#">
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1">
    <meta charset="<?php echo Yii::app()->charset; ?>"/>
    <meta name="keywords" content="<?php echo $this->keywords; ?>"/>
    <meta name="description" content="<?php echo $this->description; ?>"/>
    <meta property="og:title" content="<?php echo CHtml::encode($this->pageTitle); ?>"/>
    <meta property="og:description" content="<?php echo $this->description; ?>"/>
    <?php
    $mainAssets = Yii::app()->AssetManager->publish(
        Yii::app()->theme->basePath . "/web/"
    );

    Yii::app()->clientScript->registerCssFile($mainAssets . '/css/yupe.css');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/blog.js');
    ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>

<?php $this->widget('application.modules.menu.widgets.MenuWidget', array('name' => 'top-menu')); ?>

<div class="container">

    <div class="jumbotron">
        <h1>Юпи!</h1>

        <p class="lead">Простая, легкая и удобная CMS! Работаем на Yiiframework, Twitter Bootstrap и jQuery!</p>
        <a class="btn btn-large btn-success" href="https://github.com/yupe/yupe/releases">Скачать
            Юпи! <?php echo $this->yupe->getVersion(); ?></a>
        <a class="btn btn-large btn-info" href="<?php echo Yii::app()->createUrl('/feedback/contact/index');?>">Хочу проект!</a>    
        <br/><br/>

        <p>
            <iframe src="http://ghbtns.com/github-btn.html?user=yupe&repo=yupe&type=watch&count=true&size=large"
                    allowtransparency="true" frameborder="0" scrolling="0" width="170" height="30"></iframe>
            <iframe src="http://ghbtns.com/github-btn.html?user=yupe&repo=yupe&type=fork&count=true&size=large"
                    allowtransparency="true" frameborder="0" scrolling="0" width="170" height="30"></iframe>
            <iframe src="http://ghbtns.com/github-btn.html?user=yupe&repo=yupe&type=follow&count=true&size=large"
                    allowtransparency="true" frameborder="0" scrolling="0" width="170" height="30"></iframe>
        </p>
        <span id="contributors"></span>
    </div>
    <p>
        <a href="https://scrutinizer-ci.com/g/yupe/yupe/"><img
                src="https://scrutinizer-ci.com/g/yupe/yupe/badges/quality-score.png?s=7530a908ed160af10407a051474a9064325510cc"
                alt="Scrutinizer Quality Score" style="max-width:100%;"></a>
        <a href="https://packagist.org/packages/yupe/yupe"><img
                src="https://poser.pugx.org/yupe/yupe/downloads.png"
                alt="Total Downloads" style="max-width:100%;"></a>
        <a href='https://www.versioneye.com/user/projects/52fc8213ec1375edd50002b8'><img
                src='https://www.versioneye.com/user/projects/52fc8213ec1375edd50002b8/badge.png'
                alt="Dependency Status"/></a>
        <a href="https://bitdeli.com/free" title="Bitdeli Badge"><img
                src="https://d2weczhvl823v0.cloudfront.net/yupe/yupe/trend.png" alt="Bitdeli Badge"
                style="max-width:100%;"></a>
        <a><img src="https://insight.sensiolabs.com/projects/bc6a0620-0bc7-4bb8-9e80-02e586fd1b87/mini.png"></a>        
        <a href="https://gitter.im/yupe/yupe" title="Чат пользователей Юпи!"><img
                src="https://badges.gitter.im/yupe/yupe.png"></a>

    </p>
    <hr/>

    <!-- Example row of columns -->
    <div class="row">
        <div class="span4 module-info">
            <h3><i class="fa fa-user"></i> Пользователи</h3>

            <p class="muted">
                Регистрация, авторизация, восстановление пароля через эл.почту, профили пользователей.
            </p>

            <p>
                Модуль предоставляет удобный интерфейс для управления пользователями и их данными.
            </p>
        </div>

        <div class="span4 module-info">
            <h3><i class="fa fa-file"></i> Страницы</h3>

            <p class="muted">
                Просто и быстро создавайте страницы "О нас", "Контакты" и прочие "статические" странички.
            </p>

            <p>
                Настройки модуля позволяют выбрать удобный для вас WYSIWYG-редактор или добавить свой.
            </p>
        </div>

        <div class="span4 module-info">
            <h3><i class="fa fa-bullhorn"></i> Новости</h3>

            <p class="muted">
                Публикуйте новости, делитесь интересной информацией.
            </p>

            <p>
                Структурируйте новости по категориям, пишите тексты на разных языках.
            </p>
        </div>
    </div>

    <div class="row">
        <div class="span4 module-info">
            <h3><i class="fa fa-pencil"></i> Блоги</h3>

            <p class="muted">Создавайте индивидуальные и коллективные блоги.</p>

            <p>
                Модуль позволяет вести собственный блог или создавать коллективные блоги/сообщества.
                Настраивайте премодерацию постов и участников блога.
            </p>
        </div>
        <div class="span4 module-info">
            <h3><i class="fa fa-comment"></i> Комментариии</h3>

            <p class="muted">
                Модуль позволяет комментировать любую сущность с выстраиванием древовидных комментариев.
            </p>

            <p>
                С помощью этого модуля пользователи смогут активно участвовать в обсуждении контента вашего сайта:
                комментировать статьи и новости, обсуждать фото- и видео-материалы.
            </p>
        </div>
        <div class="span4 module-info">
            <h3><i class="fa fa-shopping-cart"></i> Каталог</h3>

            <p class="muted">Модуль позволит быстро и легко создать простой каталог товаров.</p>

            <p>Для более удобной навигации по каталогу возможно разбивать его на категории и подкатегории, использовать
                сортировку и постраничную разбивку. </p>
        </div>
    </div>


     <div class="row">
        <div class="span4 module-info">
            <h3><i class="fa fa-list"></i> Меню</h3>

            <p class="muted">Управляйте меню вашего сайта из панели управления.</p>

            <p>
                Создавайте меню с пунктами неограниченной вложенности, управляйте их видимостью, упорядочивайте и сортируйте.
                Удобный вывод меню через виджеты.
            </p>
        </div>
        <div class="span4 module-info">
            <h3><i class="fa fa-picture-o"></i> Изображения</h3>

            <p class="muted">
               Хранение всех изображений в одном месте.
            </p>

            <p>
                Используйте единую базу изабражений при создании новостей, страниц, постов и остального контента.
                Группируйте изображения в альбомы и галереи.
            </p>
        </div>
        <div class="span4 module-info">
            <h3><i class="fa fa-envelope"></i> Обратная связь</h3>

            <p class="muted">Простая форма контактов для ваших клиентов.</p>

            <p>Получайте обратную связь, формируйте FAQ по вашему проекту, отвечайте клиентам прямо из панели управления.</p>
        </div>
    </div>


    <div class="row">
        <div class="span6">
            <h2>
                <small>Преимущества</small>
            </h2>
            <div class="alert alert-notice">
                <strong>Первое место</strong> на <strong><a
                        href="https://github.com/search?o=desc&q=Yii+CMS&ref=cmdform&s=stars&type=Repositories"
                        target="_blank">Github</a></strong> среди CMS на Yiiframework!
            </div>
            <?php
            $this->widget(
                'bootstrap.widgets.TbTabs',
                array(
                    'type' => 'tabs', // 'tabs' or 'pills'
                    'tabs' => array(
                        array(
                            'label' => 'Для всех',
                            'content' => $this->renderPartial('//_partial/_all', array(), true),
                            'active' => true
                        ),
                        array(
                            'label' => 'Для разработчика',
                            'content' => $this->renderPartial('//_partial/_dev', array(), true),
                        ),
                        array(
                            'label' => 'Для заказчика',
                            'content' => $this->renderPartial('//_partial/_cus', array(), true),
                        )
                    ),
                )
            );
            ?>
            <h2>
                <small>Документация</small>
            </h2>
            <div class="posts-list-block-header">
                <a href="http://yupe.ru/docs/install.html">Установка</a>
            </div>
            <hr/>
            <div class="posts-list-block-header">
                <a href="http://yupe.ru/docs/module.create.html">Создание модуля</a>
            </div>
            <hr/>
            <div class="posts-list-block-header">
                <a href="http://yupe.ru/docs/yupe/userspace.config.html">Использование настроек в userspace</a>
            </div>
            <hr/>
            <div class="posts-list-block-header">
                <a href="http://yupe.ru/docs/testing.html">Настройка тестового окружения</a>
            </div>

        </div>
        <div class="span6">
            <h2>
                <small>Последнее в блогах</small>
            </h2>
            <div class="alert alert-notice">
                <a href="/albums/4">Галерея</a> проектов на Юпи! <strong>Добавьте свою работу!</strong>
            </div>
            <?php $this->widget(
                'application.modules.blog.widgets.LastPostsWidget',
                array('limit' => 3, 'view' => 'lastposts-index')
            ); ?>
            <hr/>
        </div>
    </div>

    <?php $this->widget(
        'application.modules.gallery.widgets.GalleryWidget',
        array('limit' => 4, 'galleryId' => 4, 'view' => 'gallery-index')
    ); ?>

    <?php $this->renderPartial('//layouts/_footer'); ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $.ajax({
            type: 'GET',
            url: 'https://api.github.com/repos/yupe/yupe/contributors',
            dataType: 'jsonp',
            success: function (data, status) {
                $.each(data.data, function (key, contributor) {
                    var image = "<img class=\"img-circle\" src=\"" + contributor.avatar_url + "\" width=\"48\" height=\"48\">";
                    var link = $(document.createElement('a'));
                    link.attr('href', 'https://github.com/' + contributor.login);
                    link.attr('target', "_blank");
                    link.attr('rel', 'tooltip');
                    link.attr('title', contributor.login);
                    link.html(image);
                    $('#contributors').append(link);
                });
            }
        });
    })
</script>

</body>
</html>