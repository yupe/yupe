DGSphinxSearch Extension
===============


The 'DGSphinxSearch' is a Yii Framework Plugin that provides a Wrapper for SphinxClient interface. Contains all methods of SphinxClient for full text searching and usefull SQL-like interface.

Sphinx is an open source full text search server, designed from the ground up with performance, relevance (aka search quality), and integration simplicity in mind. It's written in C++ and works on Linux (RedHat, Ubuntu, etc), Windows, MacOS, Solaris, FreeBSD, and a few other systems.


Requirements
------------

- Yii 1.1.*
- Sphinx Client PECL extension (http://pecl.php.net/package/sphinx)


Installation
------------

 -   Unpack all files under your project 'component' folder
 -   Include your new exteniosn into your project main.php configuration file:

    'components' => array(
            ...
            'search' => array(
                'class' => 'application.components.DGSphinxSearch',
                'server' => '127.0.0.1',
                'port' => 9312,
                'maxQueryTime' => 3000,
                'enableProfiling'=>0,
                'enableResultTrace'=>0,
                'fieldWeights' => array(
                    'name' => 10000,
                    'keywords' => 100,
                ),
            ),
            ...
          )

 -   Enjoy!

 
 
Usage:
-------

Search by criteria Object:

    $searchCriteria = new stdClass();
    $pages = new CPagination();
    $pages->pageSize = Yii::app()->params['firmPerPage'];
    $searchCriteria->select = 'project_id';
    $searchCriteria->filters = array('project_id' => $project_id);
    $searchCriteria->query = '@name '.$query.'*';
    $searchCriteria->paginator = $pages;
    $searchCriteria->groupby = $groupby;
    $searchCriteria->orders = array('f_name' => 'ASC');
    $searchCriteria->from = 'firm';
    $resIterator = Yii::App()->search->search($searchCriteria); // interator result
    /* OR */
    $resArray = Yii::App()->search->searchRaw($searchCriteria); // array result

Search by SQL-like syntax:

    $search->select('*')->
        from($indexName)->
        where($expression)->
        filters(array('project_id' => $this->_city->id))->
        groupby($groupby)->
        orderby(array('f_name' => 'ASC'))->
        limit(0, 30);
    $resIterator = $search->search(); // interator result
    /* OR */
    $resArray = $search->searchRaw(); // array result

Search by SphinxClient syntax:

    $search = Yii::App()->search;
    $search->setSelect('*');
    $search->setArrayResult(false);
    $search->setMatchMode(SPH_MATCH_EXTENDED);
    $search->setFieldWeights($fieldWeights)
    $resArray = $search->query( $query, $indexName);

Combined Method:

    $search = Yii::App()->search->
        setArrayResult(false)->
        setMatchMode(SPH_MATCH_EXTENDED);
    $resIterator = $search->select('field_1, field_2')->search($searchCriteria);


Changelog:
-------

1.0.1 
 - SPH_MATCH_FULLSCAN support added 
 - SPH_RANK_TOTAL support added
 - Some bugs fixed

1.0   
 - Initial release
