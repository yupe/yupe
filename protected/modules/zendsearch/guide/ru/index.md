Модуль поиска на основе Zend Lucene
===================================

Установка:

- Распаковать в модули Юпи!
- Включить модуль в админке сайта
- Открыть файл /protected/config/modules/zendsearch.php
- В нем есть описание переменной searchModels:

<pre><code class="php">
'searchModels' => array(
    // индексируем страницы
    'Page' => array(
        'path' => 'application.modules.page.models.Page',
        'titleColumn' => 'title',
        'linkColumn'	=> 'slug',
        'linkPattern'	=> '/page/page/view?slug={slug}',
        'textColumns' => 'body,title_short,keywords,description',
   ),
   // индексируем новости
   'News' => array(
        'path' => 'application.modules.news.models.News',
        'titleColumn' => 'title',
        'linkColumn'	=> 'alias',
        'linkPattern'	=> '/news/news/view?title={alias}',
        'textColumns' => 'full_text,short_text,keywords,description',
   ),
   // индексируем посты
   'Post' => array(
         'path' => 'application.modules.blog.models.Post',
         'titleColumn' => 'title',
         'linkColumn' => 'slug',
         'linkPattern' => '/blog/post/view?slug={slug}',
         'textColumns' => 'slug,title,quote,content',
   ),
),
</code></pre>


Это описание моделей, которые нужно включить в индекс:

- Page - название модели со следующими параметрами:
- path - алиас пути до модели (для уточнения где лежит эта модель)
- titleColumn - заголовок, который будет выводиться в списке результатов поиска
- linkColumn - поле таблицы, где хранится ссылка на модель
- linkPattern - паттерн ссылки на страницу модели
- textColumns - здесь через запятую нужно перечислить все поля таблицы, которые нужно загнать в индекс Важно! первым нужно указать поле, которое будет выводиться в качестве сниппета для страниц результатов поиска (сниппет формируется путем обрезки текста до 600 знаков, правильнее вывести это значение в свойства модуля, но руки не дошли до этого)

Далее перейти на страницу модуля **http://site.ru/zendsearch/default/index** и обновить индекс поиска.

Индекс поиска по умолчанию хранится в папке **/protected/runtime/search**


После этого можно добавлять виджет формы поиска на страницы сайта:
<pre><code class="php">
    $this->widget('application.modules.zendsearch.widgets.SearchBlockWidget');
</code></pre>
