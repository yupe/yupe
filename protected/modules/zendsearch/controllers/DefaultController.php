<?php
class DefaultController extends yupe\components\controllers\BackController
{

    public function init()
    {
        Yii::import('application.modules.zendsearch.vendors.*');
        require_once('Zend/Search/Lucene.php');
        parent::init();
    }

    public function actionIndex()
    {
        $this->render('index');
    }


    /**
     * Search index creation
     */
    public function actionCreate()
    {
        /**
         * Если это не AJAX-запрос - посылаем:
         **/
        if (!Yii::app()->getRequest()->getIsPostRequest() && !Yii::app()->getRequest()->getIsAjaxRequest())
            throw new CHttpException(404, Yii::t('ZendSearchModule.zendsearch', 'Page was not found!'));

        try {
            // Папка для хранения индекса поиска
            $indexFiles = Yii::app()->getModule('zendsearch')->indexFiles;
            // Модели, включенные в индекс
            $searchModels = Yii::app()->getModule('zendsearch')->searchModels;
            // Лимит количества символов к описанию превью найденной страницы
            $limit = 600;
            SetLocale(LC_ALL, 'ru_RU.UTF-8');
            $analyzer = new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive();
            Zend_Search_Lucene_Analysis_Analyzer::setDefault($analyzer);
            $index = new Zend_Search_Lucene(Yii::getPathOfAlias('application.' . $indexFiles), true);

            // Пробежаться по всем моделям и добавить их в индекс
            foreach ($searchModels as $modelName => $model) {

                if (is_file(Yii::getPathOfAlias($model['path']) . '.php')) {
                    $searchNodes = $modelName::model()->findAll();
                    foreach ($searchNodes as $node) {
                        $doc = new Zend_Search_Lucene_Document();
                        $doc->addField(Zend_Search_Lucene_Field::Text('title', CHtml::encode($node->$model['titleColumn']), 'UTF-8'));
                        $link = str_replace('{' . $model['linkColumn'] . '}', $node->$model['linkColumn'], $model['linkPattern']);
                        $doc->addField(Zend_Search_Lucene_Field::Text('link', $link, 'UTF-8'));
                        $contentColumns = explode(',', $model['textColumns']);
                        $i = 0;
                        foreach ($contentColumns as $column) {
                            $content = $this->cleanContent($node->$column);
                            if ($i == 0) {
                                $doc->addField(Zend_Search_Lucene_Field::Text('content', $content, 'UTF-8'));
                                $description = $this->cleanContent($this->previewContent($node->$column, $limit));
                                $doc->addField(Zend_Search_Lucene_Field::Text('description', $description, 'UTF-8'));
                            } else {
                                $doc->addField(Zend_Search_Lucene_Field::Text('content' . $i, $content, 'UTF-8'));
                            }
                            $i++;
                        }
                        $index->addDocument($doc);
                    }
                    $index->optimize();
                    $index->commit();
                }
            }

            Yii::app()->ajax->raw(Yii::t('ZendSearchModule.zendsearch','Index updated successfully!'));
        } catch (Exception $exc) {
            Yii::app()->ajax->raw(Yii::t('ZendSearchModule.zendsearch','There is an error!'));
        }
    }

    private function previewContent($data, $limit = 400)
    {
        return substr($data, 0, $limit) . '...';
    }

    private function cleanContent($data)
    {
        return strip_tags($data);
    }
}