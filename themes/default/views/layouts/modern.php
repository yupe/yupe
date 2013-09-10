<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
<head>
    <meta charset="<?php echo Yii::app()->charset; ?>">
    <title><?php echo Yii::app()->name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/main.css"/>
    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
    </style>
</head>

<body>

<?php $this->widget('application.modules.menu.widgets.MenuWidget', array('name' => 'top-menu')); ?>

<div class="container">

<!-- Main hero unit for a primary marketing message or call to action -->
<div class="row">
    <div class="hero-unit">
        <h1>Юпи!</h1>

        <p>Простая, легкая и удобная CMS</p>
        <p>Работаем на Yiiframework, Twitter Bootstrap и jQuery!</p>

        <p>
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'label' => 'Скачать Юпи!',
                'type' => 'primary',
                'size' => 'large',
                'url' => 'https://github.com/yupe/yupe/releases'
            ));
            ?>
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'htmlOptions' => array(
                    'class' => 'btn btn-success'
                ),
                'label' => 'Документация',
                'type' => 'primary',
                'size' => 'large',
                'url' => 'http://yupe.ru/docs/'
            ));
            ?>
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'htmlOptions' => array(
                    'class' => 'btn btn-info'
                ),
                'label' => 'Скриншоты',
                'type' => 'primary',
                'size' => 'large',
                'url' => 'http://yupe.ru/gallery/gallery/list'
            ));
            ?>


        </p>
        <br/>

        <p>
            <iframe src="http://ghbtns.com/github-btn.html?user=yupe&repo=yupe&type=watch&count=true&size=large"
                    allowtransparency="true" frameborder="0" scrolling="0" width="170" height="30"></iframe>
            <iframe src="http://ghbtns.com/github-btn.html?user=yupe&repo=yupe&type=fork&count=true&size=large"
                    allowtransparency="true" frameborder="0" scrolling="0" width="170" height="30"></iframe>
            <iframe src="http://ghbtns.com/github-btn.html?user=yupe&repo=yupe&type=follow&count=true&size=large"
                    allowtransparency="true" frameborder="0" scrolling="0" width="170" height="30"></iframe>

            <a href="https://twitter.com/share" class="twitter-share-button" data-via="YupeCms" data-lang="ru" data-size="large" data-hashtags="yupe">Твитнуть</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

            <iframe frameborder="0" allowtransparency="true" scrolling="no"
                    src="https://money.yandex.ru/embed/small.xml?uid=41001846363811&amp;button-text=05&amp;button-size=m&amp;button-color=orange&amp;targets=%D0%9D%D0%B0+%D1%80%D0%B0%D0%B7%D0%B2%D0%B8%D1%82%D0%B8%D0%B5+%D0%AE%D0%BF%D0%B8!&amp;default-sum=100&amp;mail=on"
                    width="auto" height="42"></iframe>


        </p>
    </div>
</div>

<!-- Example row of columns -->
<div class="row">
    <div class="span4 module-info">
        <h3><i class="icon icon-user"></i> Пользователи</h3>

        <p class="muted">
            Регистрация, авторизация, восстановление пароля через эл.почту, профили пользователей.
        </p>

        <p>
            Модуль предоставляет удобный интерфейс для управления пользователями и их данными.
        </p>
    </div>

    <div class="span4 module-info">
        <h3><i class="icon icon-file-text"></i> Страницы</h3>

        <p class="muted">
            Просто и быстро создавайте страницы "О нас", "Контакты" и прочие "статические" странички.
        </p>

        <p>
            Настройки модуля позволяют выбрать удобный для вас WYSIWYG редактор или добавить свой.
        </p>
    </div>

    <div class="span4 module-info">
        <h3><i class="icon icon-bullhorn"></i> Новости</h3>

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
        <h3><i class="icon icon-pencil"></i> Блоги</h3>

        <p class="muted">Создавайте индивидуальные и коллективные блоги.</p>

        <p>Модуль позволяет каждому зарегистрированному пользователю вести свой собственный блог, что в свою очередь
            способствует повышению интерактивности вашего ресурса.</p>
    </div>
    <div class="span4 module-info">
        <h3><i class="icon icon-comment"></i> Комментариии</h3>

        <p class="muted">
            Можно комментировать любую сущность с выстраиванием древовидных комментариев.
        </p>

        <p>
            С помощью этого модуля пользователи смогут активно участвовать в обсуждении контента вашего сайта:
            комментировать статьи и новости, обсуждать фото- и видео-материалы.
        </p>
    </div>
    <div class="span4 module-info">
        <h3><i class="icon icon-shopping-cart"></i> Каталог</h3>

        <p class="muted">Модуль позволит быстро и просто создать простой каталог продукции.</p>

        <p>Для более удобной навигации по каталогу возможно разбивать его на категории и подкатегории, использовать
            сортировку и постраничную разбивку. </p>
    </div>
</div>

<div class="row">
    <div class="span6">
        <h2><small>Последнее в блогах</small></h2>
        <?php $this->widget('application.modules.blog.widgets.LastPostsWidget', array('limit' => 3,'view' => 'lastposts-index'));?>
    </div>
    <div class="span6">
        <h2><small>Наш твиттер</small></h2>
        <div class="widget twitter-widget">
            <a class="twitter-timeline" href="https://twitter.com/YupeCms" data-widget-id="342373817932451841" height="550">
                Твиты пользователя @YupeCms
            </a>
        </div>
    </div>
</div>

<?php $this->widget('application.modules.gallery.widgets.GalleryWidget', array('limit' => 4, 'galleryId' => 4, 'view' => 'gallery-index'));?>

<hr>
<div class="row-fluid">
    <div class="span12">
        <div class="span3">
            <ul class="unstyled">
                <li>Ресурсы</li>
                <li>
                    <!--                        <i class="icon-twitter">-->
                    <a href="https://twitter.com/yupecms" target="_blank"></i> Twitter</a>
                </li>
                <li>
                    <!--                        <i class="icon-vk"></i>-->
                    <a href="http://vk.com/amylabs" target="_blank"> Вконтакте</a>
                </li>
                <li>
                    <!--                        <i class="icon-facebook"></i>-->
                    <a href="https://www.facebook.com/amylabs.ru" target="_blank"> Facebook</a>
                </li>
                <li>
                    <!--                        <i class="icon-google-plus"></i>-->
                    <a href="https://plus.google.com/u/0/b/111468098477631231532/111468098477631231532/posts"
                       target="_blank">Google+</a>
                </li>
                <li><a href="http://yupe.ru/blog/yupe-mini-cms-yii" target="_blank">Блог</a></li>
                <li><a href="http://yupe.ru/" target="_blank">Сайт</a></li>
            </ul>
        </div>
        <div class="span3">
            <ul class="unstyled">
                <li>Поддержка</li>
                <li><a href="http://yupe.ru/docs/index.html" target="_blank">Документация</a></li>
                <li><a href="http://api.yupe.ru/" target="_blank">API</a></li>
                <li><a href="http://yupe.ru/talk/" target="_blank">Форум</a></li>
                <li><a href="http://yupe.ru/wiki/default/pageIndex" target="_blank">Wiki</a></li>
                <li><a href="http://yupe.ru/feedback/faq/" target="_blank">FAQ</a></li>
                <li><a href="http://yupe.ru/feedback/index/" target="_blank">Контакты</a></li>
            </ul>
        </div>
        <div class="span3">
            <ul class="unstyled">
                <li>Юпи!</li>
                <li><a href="http://yupe.ru/pages/about/" target="_blank">О проекте</a></li>
                <li><a href="http://yupe.ru/docs/yupe/team.html" target="_blank">Команда</a></li>
                <li><a href="https://github.com/yupe/yupe/" target="_blank">Github</a></li>
                <li><a href="https://github.com/yupe/yupe-ext/" target="_blank">Доп. модули</a></li>
                <li><a href="http://yupe.ru/docs/yupe/capability.html" target="_blank">Возможности</a></li>
                <li><a href="http://yupe.ru/docs/yupe/assistance.project.html" target="_blank">Помощь проекту</a>
                </li>
            </ul>
        </div>
        <div class="span3">
            <ul class="unstyled">
                <li>Друзья</li>
                <li><a href="http://allframeworks.ru" target="_blank">allframeworks</a></li>
                <li><a href="http://amylabs.ru" target="_blank">amylabs</a></li>
                <li><a href="http://yupe.ru/feedback/index/" target="_blank">Хочешь в друзья?</a></li>
                <li><a href="http://amylabs.ru/contact?from=yupe" target="_blank">Коммерческая поддержка</a></li>
            </ul>
        </div>
    </div>
</div>
<hr>
<div class="row-fluid">
    <div class="span12">
        <div class="span8">
            <?php echo CHtml::link('Разработка и поддержка интернет-проектов', 'http://amylabs.ru?from=yupe'); ?>
        </div>
        <div class="span4">
            <p class="muted pull-right">© 2009
                - <?php echo date('Y'); ?> <?php echo CHtml::link('amyLabs', 'http://amylabs.ru?from=yupe'); ?> &&
                Юпи! team <?php echo Yii::app()->getModule('yupe')->poweredBy(); ?></p>
        </div>
    </div>
</div>
</div>

</div> <!-- /container -->

<script type="text/javascript">
    !function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
        if (!d.getElementById(id)) {
            js = d.createElement(s);
            js.id = id;
            js.src = p + "://platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js, fjs);
        }
    }(document, "script", "twitter-wjs");
</script>
</body>
</html>