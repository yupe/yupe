Установка Юпи! на Linux
========================

За пример взят дистрибутив **Ubuntu 12.04**

P.S. Данный пример установки вебсервера "В слепую" большинство операций и настроек система делает за вас автоматически, пример не расчитан на "тонкую настройку" apache2 сервера, а приведен как пример быстрого начала работы с CMS Yupe!

Установка без веб сервера ("С нуля")
====================================

Устанавливаем пакет tasksel. Открываем терминал пишем:

**sudo apt-get install tasksel**


После чего ставим сборку apache2+mysql+php

**sudo tasksel install lamp-server либо sudo apt-get install lamp-server**

В процессе установки указываем пароль и пользователя для базы данных.
Проверяем работу apache2

**http://localhost/**

Должна открыться страница с заголовком "It works!"

Ставим phpmyadmin


**sudo apt-get install phpmyadmin**

Переходим по ссылке:
http://localhost/phpmyadmin.

Для входа используем указанный выше логин и пароль.
Создаем базу анных для Yupe
К примеру с помошью ранее установленного phpmyadmin.
Подключаем mod_rewrite к Apache2

**sudo a2enmod rewrite**


Редактируем конфигурацию хостов:

**sudo nano /etc/apache2/sites-available/default**

А именно, изменяем параметр

 **AllowOverride None на AllowOverride All**

Перезагружаем Apache2

 **sudo service apache2 restart**

Приступаем к установке Юпи!

Из корневого каталога переходим в /var/www/ ,
Создаем папку для Yupe! к примеру "myblog".
Копируем в нее все файлы cms.

При открытиии ссылки **http://localhost/myblog** у Вас должно открываться дерево файлов.

Раздаем права на папку с Yupe!

**chmod -R 755 /var/www/myblog/**

Начинаем установку Yupe!
Переходим по ссылке **http://localhost/myblog/public** , должна открыться начальная страница установки.
Следуем по пунктам установщика и вносим необходимые данные.


Решение проблем с mod_rewrite

Если при переходе по ссылке http://localhost/myblog/public возникает ошибка 500, делаем следующее:
Переходим в файл дирректив который мы уже правили

**sudo nano /etc/apache2/sites-available/default**

меняем правила в Directory /var/www/ на следующие:


Options Indexes FollowSymLinks

AllowOverride None

Allow from all

Под Directory /var/www/ пишем диррективу для нашего сайта:

<Directory /var/www/myblog/>

Options FollowSymLinks

**AllowOverride All**

</Directory>

Переходим по ссылке http://localhost/myblog/public

Автор [https://github.com/hitakiri](https://github.com/hitakiri)