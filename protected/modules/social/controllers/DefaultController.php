<?php
class DefaultController extends YBackController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}