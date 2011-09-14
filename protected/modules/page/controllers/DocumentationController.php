<?php
class DocumentationController extends YFrontController
{
    public $layout = '//layouts/back/column2';

    public function actionIndex()
    {
        $this->render('index');
    }
}

?>