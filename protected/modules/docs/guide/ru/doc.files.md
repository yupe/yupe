# Файлы документации #

**Автор**: [Комманда разработчиков Юпи!](http://yupe.ru/feedback/index?from=docs)

**Версия**: 0.1 (dev)

**Авторское право**:  2009-2013 Yupe!

**Лицензия**: [BSD](https://github.com/yupe/yupe/blob/master/LICENSE)


## Механизм работы ##

Модуль для работы с документациями позволяет теперь обращаться к каталогам модулей.
Если, например, ваша документация находится в одном из модулей (это каталог `application.modules.{module}.guide`),
в таком случае для обращения к данной странице вам потребуется открыть `http://{ваш-сайт}/docs/{модуль}/{файл}.html`.
Если этого файла нет в каталоге - модуль попытается найти его в своём каталоге и в случае нахождения отобразит.

## Что умеет данный модуль ##

Для написания документации рекомендуется использовать `MarkDown` синтаксис или HTML.

## Как писать документацию ##

Особых проблем при написании документации не должно возникнуть, вот небольшой пример того, как необходимо
писать документацию:

~~~
A First Level Header
====================

A Second Level Header
---------------------

Now is the time for all good men to come to
the aid of their country. This is just a
regular paragraph.

The quick brown fox jumped over the lazy
dog's back.

### Header 3

> This is a blockquote.
> 
> This is the second paragraph in the blockquote.
>
> ## This is an H2 in a blockquote
~~~

В результате, на экране будет показано следующее:

~~~
<h1>A First Level Header</h1>

<h2>A Second Level Header</h2>

<p>Now is the time for all good men to come to
the aid of their country. This is just a
regular paragraph.</p>

<p>The quick brown fox jumped over the lazy
dog's back.</p>

<h3>Header 3</h3>

<blockquote>
    <p>This is a blockquote.</p>

    <p>This is the second paragraph in the blockquote.</p>

    <h2>This is an H2 in a blockquote</h2>
</blockquote>
~~~