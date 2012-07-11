<?php
class YQueueMailSenderCommand extends CConsoleCommand
{
	const MAIL_WORKER_ID = 1;

	public function actionIndex($limit=5)
	{
		$limit = (int)$limit;

        echo "\n".$limit."\n";

        $models = Queue::model()->findAll(array(
            'condition' => 'worker = :worker AND status = :status',
            'params'    => array(
            	':worker' => self::MAIL_WORKER_ID,
            	':status' => Queue::STATUS_NEW
            ),
            'limit' => $limit,
            'order' => 'id desc'
        ));

        echo "\n".count($models)."\n";

        foreach($models as $model)
        {
           if(!$data = (array)json_decode($model->task))
           {
               $model->status = Queue::STATUS_ERROR;
               
               $model->notice = 'Error json_decode...';

               $model->save();

               continue;	   
           }

           if(!isset($data['from'], $data['to'],$data['theme'], $data['body']))
           {
               $model->status = Queue::STATUS_ERROR;
               
               $model->notice = 'Wrong data...';

               $model->save();

               continue;	   	
           }

           if(Yii::app()->mail->send($data['from'],$data['to'],$data['theme'],$data['body']))
           {
               $model->status = Queue::STATUS_COMLETED;
               
               $model->complete_time = new CDbExpression('NOW()');

               $model->save();

               continue;	
           }
        }
	}
}