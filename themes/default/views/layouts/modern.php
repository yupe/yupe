
<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language;?>">
<head>
    <meta charset="<?php echo Yii::app()->charset;?>">
    <title><?php echo Yii::app()->name;?></title>
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

<?php $this->widget('application.modules.menu.widgets.MenuWidget', array('name' => 'top-menu' ));?>

<div class="container">

    <!-- Main hero unit for a primary marketing message or call to action -->
    <div class="row">
            <div class="hero-unit">
                <h1>Юпи!</h1>
                <p>Простая, легкая и удобная CMS на Yiiframework</p>
                <p>
                    <?php
                        $this->widget('bootstrap.widgets.TbButton',array(
                            'label' => 'Загрузить v0.5.3',
                            'type' => 'primary',
                            'size' => 'large',
                            'url'  => 'http://yupe.ru/get/'
                        ));
                    ?>
                    <?php
                        $this->widget('bootstrap.widgets.TbButton',array(
                            'htmlOptions' => array(
                                'class' => 'btn btn-success'
                            ),
                            'label' => 'Документация',
                            'type' => 'primary',
                            'size' => 'large',
                            'url'  => 'http://yupe.ru/docs/'
                        ));
                    ?>
                    <?php
                    $this->widget('bootstrap.widgets.TbButton',array(
                            'htmlOptions' => array(
                                'class' => 'btn btn-info'
                            ),
                            'label' => 'Скриншоты',
                            'type' => 'primary',
                            'size' => 'large',
                            'url'  => 'http://yupe.ru/gallery/gallery/list'
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
                </p>
            </div>
    </div>

    <!-- Example row of columns -->
    <div class="row">
        <div class="span4 module-info">
            <h3><i class="icon icon-user"></i> Пользователи</h3>
            <p class="muted">
                Регистрация, восстановление пароля через эл.почту, профили пользователей.
            </p>
            <p>
                Модуль является инструментом контроля аудитории вашего сайта и предоставляет удобный интерфейс для управления пользователями.
            </p>
        </div>

        <div class="span4 module-info">
            <h3><i class="icon icon-file-text"></i> Страницы</h3>
            <p class="muted">
                Модуль предназначен для создания на сайте неограниченного числа статических станиц.
            </p>
            <p>
                Настройки модуля позволят подобрать удобный для вас WYSIWYG редактор или добавить свой если его нет в наборе.
            </p>
        </div>

        <div class="span4 module-info">
            <h3><i class="icon icon-bullhorn"></i> Новости</h3>
            <p class="muted">
                Используя этот модуль, вы можете поделиться на сайте любой информацией.
            </p>
            <p>
                Возможно указывать срок публикации и отображать публикуемый материал в хронологической последовательности на нескольких языках.
            </p>
        </div>
    </div>

    <div class="row">
        <div class="span4 module-info">
            <h3><i class="icon icon-pencil"></i> Блоги</h3>
            <p class="muted">Модуль даст возможность вести как индивидуальные, так и коллективные блоги.</p>
            <p>Данный модуль позволяет каждому зарегистрированному пользователю сайта вести свой собственный блог, что в свою очередь способствует повышению интерактивности вашего ресурса.</p>


        </div>
        <div class="span4 module-info">
            <h3><i class="icon icon-comment"></i> Комментариии</h3>
            <p class="muted">
                Можно комментировать любую сущность с выстраиванием древовидных комментариев.
            </p>
            <p>
                С помощью этого модуля пользователи смогут активно участвовать в обсуждении материалов вашего сайта: анализировать статьи, оценивать фото- и видеоматериалы.
            </p>
        </div>
        <div class="span4 module-info">
            <h3><i class="icon icon-shopping-cart"></i> Каталог</h3>
            <p class="muted">Модуль для создания каталога позволит составлять на сайте неограниченный список продукции.</p>
            <p>Для более удобной навигации по каталогу продукции возможно разбивать его на категории и подкатегории, использовать сортировку и постраничную разбивку(пагинацию). </p>
        </div>
    </div>


    <hr>
  <div class="row-fluid">
        <div class="span12">
            <div class="span3">
                <ul class="unstyled">
                    <li>Ресурсы<li>
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
                        <a href="https://plus.google.com/u/0/b/111468098477631231532/111468098477631231532/posts" target="_blank">Google+</a>
                    </li>
                    <li><a href="http://yupe.ru/blog/yupe-mini-cms-yii" target="_blank">Блог</a></li>
                    <li><a href="http://yupe.ru/" target="_blank">Сайт</a></li>
                </ul>
            </div>
            <div class="span3">
                <ul class="unstyled">
                    <li>Поддержка<li>
                    <li><a href="http://yupe.ru/feedback/index/" target="_blank">Контакты</a></li>
                    <li><a href="http://yupe.ru/talk/" target="_blank">Форум</a></li>
                    <li><a href="http://yupe.ru/wiki/default/pageIndex" target="_blank">Wiki</a></li>
                    <li><a href="http://yupe.ru/docs/index.html" target="_blank">Документация</a></li>
                    <li><a href="http://yupe.ru/feedback/faq/" target="_blank">FAQ</a></li>
                    <li><a href="http://amylabs.ru/contact?from=yupe" target="_blank">Коммерческая поддержка</a></li>
                </ul>
            </div>
            <div class="span3">
                <ul class="unstyled">
                    <li>Юпи!<li>
                    <li><a href="http://yupe.ru/pages/about/" target="_blank">О проекте</a></li>
                    <li><a href="http://yupe.ru/docs/yupe/team.html" target="_blank">Команда</a></li>
                    <li><a href="https://github.com/yupe/yupe/" target="_blank">Github</a></li>
                    <li><a href="https://github.com/yupe/yupe-ext/" target="_blank">Доп. модули</a></li>
                    <li><a href="http://yupe.ru/docs/yupe/capability.html" target="_blank">Возможности</a></li>
                    <li><a href="http://yupe.ru/docs/yupe/assistance.project.html" target="_blank">Помощь проекту</a></li>
                </ul>
            </div>
            <div class="span3">
                <ul class="unstyled">
                    <li>Наши друзья<li>
                    <li><a href="http://allframeworks.ru" target="_blank">allframeworks</a></li>
                    <li><a href="http://amylabs.ru" target="_blank">amylabs</a></li>
                    <li><a href="http://yupe.ru/feedback/index/" target="_blank">Хочешь в друзья?</a></li>
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
