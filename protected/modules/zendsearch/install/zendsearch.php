<?php
return array(
    'module' => array(
        'class' => 'application.modules.zendsearch.ZendSearchModule',
        // Указание здесь layout'a портит отображение на фронтенде:
        //'layout' => '//layouts/column2',
        'searchModels' => array(
            'Page' => array(
                'path' => 'application.modules.page.models.Page',
                'titleColumn' => 'title',
                'linkColumn' => 'slug',
                'linkPattern' => '/page/page/show?slug={slug}',
                'textColumns' => 'body,title_short,keywords,description',
            ),
            'News' => array(
                'path' => 'application.modules.news.models.News',
                'titleColumn' => 'title',
                'linkColumn' => 'alias',
                'linkPattern' => '/news/news/show?title={alias}',
                'textColumns' => 'full_text,short_text,keywords,description',
            ),
        ),
    ),
    'import' => array(
        'application.modules.zendsearch.models.*',
    ),
    'component' => array(),
    'rules' => array(
        '/search' => 'zendsearch/search/search',
    ),
);
?>