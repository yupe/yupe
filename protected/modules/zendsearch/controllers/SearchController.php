<?php

/**
 * Class SearchController
 */
class SearchController extends \yupe\components\controllers\FrontController
{
    /**
     * @throws CException
     */
    public function init()
    {
        parent::init();
        Yii::import('application.modules.zendsearch.vendors.*');
        require_once 'Zend/Search/Lucene.php';
    }

    /**
     * @throws Zend_Search_Lucene_Exception
     */
    public function actionSearch()
    {
        $indexFiles = Yii::app()->getModule('zendsearch')->indexFiles;
        SetLocale(LC_ALL, 'ru_RU.UTF-8');
        Zend_Search_Lucene_Analysis_Analyzer::setDefault(
            new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive()
        );
        Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('UTF-8');

        if (($term = Yii::app()->getRequest()->getQuery('q', null)) !== null) {
            $index = new Zend_Search_Lucene(Yii::getPathOfAlias('application.' . $indexFiles));
            $results = $index->find($term);
            $query = Zend_Search_Lucene_Search_QueryParser::parse($term);
            $this->render('search', compact('results', 'term', 'query'));
        }
    }
}
