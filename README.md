ЮПИ! - CMS на Yii
=================

Юпи! — мини CMS, написанная на замечательном MVC-фреймворке Yii (http://www.yiiframework.com/),
на которой работает уже более 150 проектов.


Требования к хостингу
---------------------

* PHP >= 5.3
* Yiiframework >= 1.1.13
* MySQL/PostgreSQL
* Apaсhe/Nginx

Ссылки
------
* [Официальный сайт](http://yupe.ru/)
* [Официальная документация](http://yupe.ru/docs/index.html)
* [Подробнее о проекте](http://yupe.ru/pages/help)
* [Команда](http://yupe.ru/pages/team)
* [twitter](https://twitter.com/#!/YupeCms)
* [Форум](http://yupe.ru/talk/)
* [Блог проекта](http://yupe.ru/index.php/blog/yupe-mini-cms-yii)
* [wiki](http://yupe.ru/wiki/default/pageIndex)
* [Контакты](http://yupe.ru/feedback/index)
* [Как помочь проекту](http://yupe.ru/pages/help)
* [Репозиторий модулей](https://github.com/yupe/yupe-ext)

Возможности
-----------

Из коробки Вы получаете каркас приложения, со следующим уже готовым
функционалом (всё разделено на модули - используйте только то, что необходимо):

* [Регистрация](http://yupe.ru/registration), [аутентификация](http://yupe.ru/login), [восстановление пароля](http://yupe.ru/recovery) ([модуль user](https://github.com/yupe/yupe/tree/master/protected/modules/user))
* Модуль пользователей, для управление пользователями сайта (блокировка, активация, редактирование и т.д.) через административный интерфейс ([модуль user](https://github.com/yupe/yupe/tree/master/protected/modules/user))
* Модуль новостей для [создания и публикация новостей на сайте](http://yupe.ru/story/ocherednoy-sayt-na-yupi) ([модуль news](https://github.com/yupe/yupe/tree/master/protected/modules/news))
* Модуль статических страниц, для создания и управление статическими страницами сайта ([модуль page](https://github.com/yupe/yupe/tree/master/protected/modules/page))
* Модуль категорий, для создания и управление категориями вашего сайта (разделами) ([модуль category](https://github.com/yupe/yupe/tree/master/protected/modules/category))
* Модуль меню, для создания и редактирование меню вашего сайта ([модуль menu](https://github.com/yupe/yupe/tree/master/protected/modules/menu))
* Модуль комментариев (можно комментировать любую сущность с выстраиванием древовидных комментариев, пример [http://yupe.ru/post/logotip-dlya-yupi.html](http://yupe.ru/post/logotip-dlya-yupi.html) ([модуль comment](https://github.com/yupe/yupe/tree/master/protected/modules/comment))
* Модуль простых справочников (хранение и управление справочной информацией) ([модуль dictionary](https://github.com/yupe/yupe/tree/master/protected/modules/dictionary))
* Модуль для ведения блогов ([как индивидуальных, так и коллективных](http://yupe.ru/blog/yupe-mini-cms-yii)) ([модуль blog](https://github.com/yupe/yupe/tree/master/protected/modules/blog))
* Модуль для "Обратной связи" + [раздел FAQ](http://yupe.ru/faq) ([модуль feedback](https://github.com/yupe/yupe/tree/master/protected/modules/feedback))
* Модуль для работы с Wiki - работает через [модуль yeeki](http://rmcreative.ru/blog/post/yeeki)
* Модуль документации, который позволяет создавать документацию для вашего сайта ([модуль docs](https://github.com/yupe/yupe/tree/master/protected/modules/docs))
* Модуль изображений ([модуль image](https://github.com/yupe/yupe/tree/master/protected/modules/image))
* Модуль галерея изображений, позволяющий организовать галереи изображений на вашем сайте ([модуль gallery](https://github.com/yupe/yupe/tree/master/protected/modules/gallery))
* Модуль для создания и редактирования произвольных блоков контента ([модуль contentblock](https://github.com/yupe/yupe/tree/master/protected/modules/contentblock))
* Модуль для создания заданий ([модуль queue](https://github.com/yupe/yupe/tree/master/protected/modules/queue))
* Модуль управления почтовыми сообщениями ([модуль mail](https://github.com/yupe/yupe/tree/master/protected/modules/mail))
* Модуль для установки системы ([модуль install](https://github.com/yupe/yupe/tree/master/protected/modules/install))
* Удобная админ панель в стиле Twitter Bootstrap  ([Выглядит вот так](http://yupe.ru/gallery/gallery/show/1))
* [Возможность генерировать CRUD в стиле Twitter Bootstrap](https://github.com/yupe/yupe/tree/master/protected/modules/yupe/extensions/yupe)

Установка
---------

Инструкции по установке можно [почитать здесь](http://yupe.ru/wiki/default/view?uid=%D0%A3%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0), либо в файле `install_ru.txt`.

Лицензия
--------

Исходный код, макеты дизайна и вёрстка распространяются по [лицензии BSD](http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD).
Сообщество будет благодарно если на сайте будет присутствовать ссылка на [http://yupe.ru/](http://yupe.ru/)
