<?php
class PeopleController extends YFrontController
{
    // показать всех пользователей
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('User', array(
                                                             'criteria' => array(
                                                                 'condition' => 'status = :status',
                                                                 'params' => array(':status' => User::STATUS_ACTIVE),
                                                                 'with' => array('profile'),
                                                                 'order' => 'last_visit DESC'
                                                             )
                                                        ));

        $this->render('index', array(
                                    'dataProvider' => $dataProvider
                               ));
    }
}

?>