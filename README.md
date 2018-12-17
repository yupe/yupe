Юпи!- CMS на Yiiframework 1.x
=============================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yupe/yupe/badges/quality-score.png?b=dev)](https://scrutinizer-ci.com/g/yupe/yupe/?branch=dev)
[![Gitter chat](https://badges.gitter.im/yupe/yupe.png)](https://gitter.im/yupe/yupe)
[![Code Climate](https://codeclimate.com/github/yupe/yupe.png)](https://codeclimate.com/github/yupe/yupe)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/bc6a0620-0bc7-4bb8-9e80-02e586fd1b87/mini.png)](https://insight.sensiolabs.com/projects/bc6a0620-0bc7-4bb8-9e80-02e586fd1b87)

Юпи! позволяет быстро и легко создавать проекты следующих типов:

* [интернет-магазины](https://yupe.ru/ecommerce)
* [блоги / сообщества](https://yupe.ru/site/blog)
* [бизнес сайты](https://yupe.ru/site)


На Юпи! работает более 3000 проектов, среди которых более 500 интернет-магазинов, Юпи! активно используют [студии и команды разработчиков](https://yupe.ru/partners).

Прежде всего Юпи! рассчитан на PHP-разработчиков, знакомых с Yiiframework 1.x.

[Процесс установки](http://docs.yupe.ru/install/) очень прост и занимает не более 5 минут!

Для успешной работы проекта на Юпи! вполне достаточно самого простого и [дешевого хостинга](https://yupe.ru/service/hosting), минимальные требования:

* PHP >= 5.6
* Composer
* MySQL 5.x
* Apaсhe/Nginx
* Yiiframework 1.x

Рекомендуем хостинг от [timeweb](http://timeweb.com/ru/services/hosting/?i=28284) или виртуальные сервера от [firstvds](https://firstvds.ru/?from=442205)

![Юпи!](http://amylabs.ru/web/images/shop/yupe-shop.png)

Ссылки
------
* [Официальный сайт](https://yupe.ru/)
* [Юпи! Market](https://yupe.ru/store)
* [Чат](https://t.me/joinchat/BuTSV0K8j5lPBSIoQk0fuA)
* [Блог Юпи!](https://yupe.ru/blogs/yupe-mini-cms-yii)
* [Репозиторий модулей](https://github.com/yupe/yupe-ext)
* [Документация](https://docs.yupe.ru/)
* [API](https://api.yupe.ru/)
* [Подробнее о проекте](https://yupe.ru/about)
* [Команда](https://docs.yupe.ru/team/)
* [Форум](https://talk.yupe.ru/)
* [Контакты](https://yupe.ru/contacts)
* [Как помочь проекту](http://docs.yupe.ru/assistance.project/)
* [twitter](https://twitter.com/#!/YupeCms)
* [Группа Вконтакте](https://vk.com/yupecms)
* [Разработка](https://yupe.ru/service/development) и [поддержка](https://yupe.ru/service/support)


Возможности
-----------

Из коробки Вы получаете каркас Yii-приложения, со следующим функционалом (всё разделено на модули - используйте только то, что необходимо):

* [Интернет-магазин (каталог, корзина, заказы, купоны, платежные системы)](https://yupe.ru/ecommerce)
* [Регистрация](https://yupe.ru/registration), [аутентификация](https://yupe.ru/login), [восстановление пароля](https://yupe.ru/recovery) ([модуль user](https://github.com/yupe/yupe/tree/master/protected/modules/user)).
* Управление пользователями (блокировка, активация, редактирование и т.д.) через административный интерфейс ([модуль user](https://github.com/yupe/yupe/tree/master/protected/modules/user)).
* Модуль для ведения блогов ([как индивидуальных, так и коллективных](https://yupe.ru/blogs/yupe-mini-cms-yii)) ([модуль blog](https://github.com/yupe/yupe/tree/master/protected/modules/blog)).
* [Создание и публикация новостей](https://yupe.ru/story/ocherednoy-sayt-na-yupi) ([модуль news](https://github.com/yupe/yupe/tree/master/protected/modules/news)).
* Создание и управление страницами сайта ([модуль page](https://github.com/yupe/yupe/tree/master/protected/modules/page)).
* Создание и управление категориями сайта (разделами) ([модуль category](https://github.com/yupe/yupe/tree/master/protected/modules/category)).
* Создание и редактирование меню сайта ([модуль menu](https://github.com/yupe/yupe/tree/master/protected/modules/menu)).
* Древовидные комментарии (можно комментировать любую сущность, пример [https://yupe.ru/post/yupe-053.html#comments](https://yupe.ru/post/yupe-053.html#comments)).
* Модуль простых справочников (хранение и управление справочной информацией) ([модуль dictionary](https://github.com/yupe/yupe/tree/master/protected/modules/dictionary)).
* Модуль для "Обратной связи" + [раздел FAQ](https://yupe.ru/faq) ([модуль feedback](https://github.com/yupe/yupe/tree/master/protected/modules/feedback)).
* Модуль для работы с блоками контента ([модуль contentblock](https://github.com/yupe/yupe/tree/master/protected/modules/contentblock)).
* Wiki - работает через [модуль yeeki](http://rmcreative.ru/blog/post/yeeki).
* Удобная админка на Twitter Bootstrap  ([Выглядит вот так](https://yupe.ru/albums/5)).
* [Возможность генерировать CRUD в стиле Twitter Bootstrap](https://github.com/yupe/yupe/tree/master/protected/modules/yupe/extensions/yupe).
* Авторизация через социальные сети (с использованием nodge/yii-eauth)

**Если вам не хватает какой-то функциональности - [напишите нам](https://yupe.ru/contacts) и мы Вам обязательно поможем!**


Лицензия
--------

Исходный код, макеты дизайна и вёрстка распространяются по [лицензии BSD](http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD).

Сообщество будет благодарно если на сайте будет присутствовать ссылка на [https://yupe.ru](https://yupe.ru)


[![amylabs](https://yupe.ru/web/images/yupe/amylabs.jpg)](http://amylabs.ru)

![amyLabs](http://amylabs.ru/assets/6e689601/images/logo1.png)


(c) 2012 - 2018 [amylabs](https://amylabs.ru) && [Yupe! team](https://yupe.ru/)  ![Юпи!](https://yupe.ru/web/images/logo.png)
