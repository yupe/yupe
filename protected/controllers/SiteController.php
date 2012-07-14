<?php
class SiteController extends YFrontController
{
    const POST_PER_PAGE = 5;
    
    private $alreadyInstalledFlag;
    
    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);
        
        $this->alreadyInstalledFlag = Yii::app()->basePath . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '.ai';
        if(!file_exists($this->alreadyInstalledFlag))
            $this->redirect ('/install');
    }

    public function actions()
    {
        return array(
            'page' => array(
                'class' => 'CViewAction',
            )
        );
    }

    public function actionIndex()
    {
        
        $dataProvider = new CActiveDataProvider('Post', array(
            'criteria' => new CDbCriteria(array(
                'condition' => 't.status = :status',
                'params' => array(':status' => Post::STATUS_PUBLISHED),
                'limit' => self::POST_PER_PAGE,
                'order' => 't.id DESC',
                'with' => array('createUser', 'blog')
            )),
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionSocial()
    {
        $this->render('social');
    }
}