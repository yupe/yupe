Установка
=========

Начиная с версии **0.6** Юпи! можно установить через [Composer](http://getcomposer.org/)

Пакет доступен на Packagist [https://packagist.org/packages/yupe/yupe](https://packagist.org/packages/yupe/yupe)

Если по какой-то причине Вы не можете использовать Composer - на [странице загрузки](http://yupe.ru/download) для каждого релиза имеется полная сборка дистрибутива.

Любые вопросы, связанные с установкой платформы можно задать в [специальном разделе форума](http://yupe.ru/talk/viewforum.php?f=10).

**Перед установкой**

* убедитесь, что установленная версия PHP не ниже 5.4

**Установка через Composer**

Для установки Юпи! через Composer вам потребуется сам [Composer](http://getcomposer.org/download/) и установленный [Git](http://git-scm.com/downloads)

Если все это уже установлено - открываем терминал и вводим команду:

~~~
[php]
php composer.phar create-project yupe/yupe:dev-dev yupe-project --no-dev --prefer-dist
~~~

Мы должны увидеть приблизительно вот такой вывод:


~~~
[php]
Installing yupe/yupe (dev-master 809840596f854a3f78b1e5415b0db6c969a6a3f9)
- Installing yupe/yupe (dev-master master)
 Cloning master

 Created project in yupe-project
 Loading composer repositories with package information
 Installing dependencies (including require-dev)
- Installing yiisoft/yii (1.1.14)
 Loading from cache

- Installing clevertech/yii-booster (v2.0.0)
 Loading from cache

- Installing yiiext/nested-set-behavior (dev-master c455cec)
 Cloning c455cec6024b6dcd6550a3894a3a312854943dde

- Installing yiiext/imperavi-redactor-widget (dev-master f8b06d4)
 Cloning f8b06d497d85799a266cd36144e43a551afdb877

- Installing zhuravljov/yii2-debug (dev-master 7a7e016)
 Cloning 7a7e016281f4d6feb8785879d628c23843dc5d68
~~~

Наливаем себе чашечку чая и ждем +)

Если вам необходимо установить ветку отличную от ветки по умолчанию - команда будет вот такой:

~~~
[php]
php composer.phar create-project yupe/yupe:<Номер ветки здесь>.x-dev yupe-project --no-dev --prefer-dist
~~~

Например для установки ветки 0.9:
~~~
[php]
php composer.phar create-project yupe/yupe:0.9.x-dev yupe-project --no-dev --prefer-dist
~~~


После того как все закончилось убеждаемся, что веб-сервер имеет права на запись в следующие каталоги:

/protected/runtime/

/protected/config/

/public/assets/

/public/uploads/
 

**Загрузка полного архива (включая все зависимости)**

Каждый релиз (стабильный и нет) содержит в себе полный архив Юпи!

Если по каким-то причинам Вы не можете воспользоваться composer - этот вариант установки подойдет для Вас.

Скачать Юпи! в архиве очень просто: переходим на страницу загрузки [http://yupe.ru/download](http://yupe.ru/download) и скачиваем последнюю версию.

В результате получаем полный архив готовый к установке!

После того как все сделано переходим по адресу **http://localhost/yupe-project/public/** (поменять на свой) и если все хорошо - мы должны увидеть первый шаг установки:

Если установка не запускается - проверьте наличие файла /protected/config/modules/install.php если этого файла нет - скопируйте его в этот каталог из protected/modules/install/install/install.php

<img src='/yd/install.png'>

Выбираем язык установки и попадаем на шаг проверки окружения, для всех перечисленных папок должны быть права на запись:

<img src='/yd/enviroment.png'>

Если все хорошо - следующий шаг - проверка версии PHP и его расширений:

<img src='/yd/systemcheck.png'>


На следующем шаге необходимо указать праметры соединения с базой данных:

<img src='/yd/dbsettings.png'>

Выбираем модули для установки:

<img src='/yd/modules.png'>


Процесс установки модулей:

<img src='/yd/installprocess.png'>


Создание учетной записи администратора:

<img src='/yd/admincreate.png'>

Настройки сайта:

<img src='/yd/sitesettings.png'>

Окончание установки:

<img src='/yd/finishinstall.png'>


**Установка через Git**

Клонируем проект командой:

~~~
[php]
git clone https://github.com/yupe/yupe yupe-project
~~~

Должны увидеть приблизительног следующее:

~~~
[php]
Cloning into 'yupe-project'...
remote: Counting objects: 50582, done.
remote: Compressing objects: 100% (20396/20396), done.
remote: Total 50582 (delta 30679), reused 46279 (delta 26476)
Receiving objects: 100% (50582/50582), 52.01 MiB | 909.00 KiB/s, done.
Resolving deltas: 100% (30679/30679), done.
Checking connectivity... done
~~~


Переходим в каталог с новеньким проектом и устанавливаем все необходимые зависимости:

~~~
[php]
php composer.phar install
~~~

После зарешения переходим по адресу **http://localhost/yupe-project/public/** и попадаем в уже знакомый нам мастер установки.

При возникновении проблем с установкой - посетите [наш форум](http://yupe.ru/talk) или [чат](https://gitter.im/yupe/yupe).

По вопросам разворачивания Юпи! для "боевых" проектов - [напишите нам](http://amylabs.ru/contact)!
