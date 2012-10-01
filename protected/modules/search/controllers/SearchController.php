<?php
    class SearchController extends YFrontController
    {
        public $indexes;
        function actionSearch($q=null,$page=1)
        {
            $news = null;
            $searchCriteria = new stdClass();
            $pages = new CPagination();
            $pages->pageSize = 50;
            $pages->currentPage = $page;
            $searchCriteria->select = 'id';
            $p = new CHtmlPurifier();
            $q = CHtml::encode($p->purify($q));
            $searchCriteria->query = $q.'*';
            $searchCriteria->paginator = $pages;
            $searchCriteria->from = join(",",$this->indexes);
            $resArray = Yii::App()->search->searchRaw($searchCriteria); // array result
            if (is_array($resArray['matches']))
            {
                $c = new CDbCriteria();
                $c->order='FIELD(id,'.join(",",array_keys($resArray['matches'])).')';
                $news = News::model()->findAllByPk(array_keys($resArray['matches']),$c);
            }
            $this->render("search_results",array('news'=>$news));

        }
    }