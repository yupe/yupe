Юпи!- CMS на Yii
=================

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/yupe/yupe/badges/quality-score.png?s=7530a908ed160af10407a051474a9064325510cc)](https://scrutinizer-ci.com/g/yupe/yupe/)
[![Total Downloads](https://poser.pugx.org/yupe/yupe/downloads.png)](https://packagist.org/packages/yupe/yupe)
[![Daily Downloads](https://poser.pugx.org/yupe/yupe/d/daily.png)](https://packagist.org/packages/yupe/yupe)
[![Gitter chat](https://badges.gitter.im/yupe/yupe.png)](https://gitter.im/yupe/yupe)
[![Dependency Status](https://www.versioneye.com/user/projects/52fc8213ec1375edd50002b8/badge.png)](https://www.versioneye.com/user/projects/52fc8213ec1375edd50002b8)
[![Code Climate](https://codeclimate.com/github/yupe/yupe.png)](https://codeclimate.com/github/yupe/yupe)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/bc6a0620-0bc7-4bb8-9e80-02e586fd1b87/mini.png)](https://insight.sensiolabs.com/projects/bc6a0620-0bc7-4bb8-9e80-02e586fd1b87)
[![project status](http://stillmaintained.com/yupe/yupe.png)](http://stillmaintained.com/yupe/yupe)
[![Issue Stats Issues](http://issuestats.com/github/yupe/yupe/badge/issue)](http://issuestats.com/github/yupe/yupe)
![Юпи!](http://amylabs.ru/assets/196fa697/images/Head_browser.png)

Юпи! позволяет быстро и легко создавать проекты следующих типов:

* [интернет-магазины](http://yupe-project.ru/ecommerce)
* сайты-визитки
* корпоративные порталы
* [блоги / сообщества](http://yupe-project.ru/community)


На Юпи! работает более 1500 проектов, среди которых около 300 интернет-магазинов, Юпи! активно используют [студии и команды разработчиков](http://yupe-project.ru/partners).

Прежде всего Юпи! рассчитан на PHP-разработчиков, знакомых с Yiiframework 1.x.

[Процесс установки](http://yupe.ru/docs/install.html) очень прост и занимает не более 5 минут!

Для успешной работы проекта на Юпи! вполне достаточно самого простого и дешевого хостинга, минимальные требования:


* PHP >= 5.4
* Composer
* MySQL 5.x
* Apaсhe/Nginx

![Юпи!](http://amylabs.ru/web/images/shop/yupe-shop.png)


Ссылки
------
* [Сообщество](http://yupe.ru/)
* [Официальный сайт](http://yupe-project.ru/)
* [Юпи! Market](http://yupe.ru/marketplace)
* [Чат](http://gitter.im/yupe/yupe)
* [Блог Юпи!](http://yupe.ru/blogs/yupe-mini-cms-yii)
* [Репозиторий модулей](https://github.com/yupe/yupe-ext)
* [Руководство](http://guides-v1.yupe-project.ru/)
* [Документация](http://yupe.ru/docs/index.html)
* [API](http://api.yupe.ru/)
* [Подробнее о проекте](http://yupe-project.ru/about)
* [Команда](http://yupe.ru/docs/yupe/team.html)
* [Форум](http://yupe.ru/talk/)
* [Контакты](http://yupe.ru/contacts)
* [Как помочь проекту](http://yupe.ru/docs/yupe/assistance.project.html)
* [twitter](https://twitter.com/#!/YupeCms)
* [Группа Вконтакте](https://vk.com/yupecms)
* [Разработка](http://yupe-project.ru/service/development) и [поддержка](http://yupe-project.ru/service/support)

[![Юпи! Market](http://yupe.ru/uploads/blogs/a0301fdec876e23050ff3d312d97ee88.png)](http://yupe.ru/marketplace)

Возможности
-----------

Из коробки Вы получаете каркас Yii-приложения, со следующим функционалом (всё разделено на модули - используйте только то, что необходимо):

* [Регистрация](http://yupe.ru/registration), [аутентификация](http://yupe.ru/login), [восстановление пароля](http://yupe.ru/recovery) ([модуль user](https://github.com/yupe/yupe/tree/master/protected/modules/user)).
* Управление пользователями (блокировка, активация, редактирование и т.д.) через административный интерфейс ([модуль user](https://github.com/yupe/yupe/tree/master/protected/modules/user)).
* Модуль для ведения блогов ([как индивидуальных, так и коллективных](http://yupe.ru/blogs/yupe-mini-cms-yii)) ([модуль blog](https://github.com/yupe/yupe/tree/master/protected/modules/blog)).
* [Создание и публикация новостей](http://yupe.ru/story/ocherednoy-sayt-na-yupi) ([модуль news](https://github.com/yupe/yupe/tree/master/protected/modules/news)).
* Создание и управление страницами сайта ([модуль page](https://github.com/yupe/yupe/tree/master/protected/modules/page)).
* Создание и управление категориями сайта (разделами) ([модуль category](https://github.com/yupe/yupe/tree/master/protected/modules/category)).
* Создание и редактирование меню сайта ([модуль menu](https://github.com/yupe/yupe/tree/master/protected/modules/menu)).
* Древовидные комментарии (можно комментировать любую сущность, пример [http://yupe.ru/post/yupe-053.html#comments](http://yupe.ru/post/yupe-053.html#comments)).
* Модуль простых справочников (хранение и управление справочной информацией) ([модуль dictionary](https://github.com/yupe/yupe/tree/master/protected/modules/dictionary)).
* Модуль для "Обратной связи" + [раздел FAQ](http://yupe.ru/faq) ([модуль feedback](https://github.com/yupe/yupe/tree/master/protected/modules/feedback)).
* Модуль для работы с блоками контента ([модуль contentblock](https://github.com/yupe/yupe/tree/master/protected/modules/contentblock)).
* Wiki - работает через [модуль yeeki](http://rmcreative.ru/blog/post/yeeki).
* Удобная админка на Twitter Bootstrap  ([Выглядит вот так](http://yupe.ru/albums/5)).
* [Возможность генерировать CRUD в стиле Twitter Bootstrap](https://github.com/yupe/yupe/tree/master/protected/modules/yupe/extensions/yupe).
* Авторизация через социальные сети (с использованием nodge/yii-eauth)
* [Интернет-магазин (каталог, корзина, заказы, купоны, платежные системы)](http://yupe-project.ru/ecommerce)

**Если вам не хватает какой-то функциональности - [напишите нам](http://amylabs.ru/contact) и мы Вам обязательно поможем!**


Лицензия
--------

Исходный код, макеты дизайна и вёрстка распространяются по [лицензии BSD](http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD).

Сообщество будет благодарно если на сайте будет присутствовать ссылка на [http://yupe-project.ru](http://yupe-project.ru)


[![amylabs](http://yupe-project.ru/web/images/yupe/amylabs.jpg)](http://amylabs.ru)

![amyLabs](http://amylabs.ru/assets/196fa697/images/logo1.png)


(c) 2012 - 2015 [amylabs](http://amylabs.ru) && [Yupe! team](http://yupe.ru/)  ![Юпи!](http://yupe.ru/web/images/logo.png)
