<?php
/**
 * YQueueMailSenderCommand консольная команда для отправки email-сообщений через очередь
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.queue.commands
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @since 0.1
 *
 */
class YQueueMailSenderCommand extends CConsoleCommand
{
    const MAIL_WORKER_ID = 1;

    public function actionIndex($limit = 5)
    {
        $limit = (int) $limit;

        echo "Process " . $limit . " mail task...\n";

        Yii::log("Process " . $limit . " mail task...\n");

        $models = Queue::model()->findAll(array(
            'condition' => 'worker = :worker AND status = :status',
            'params' => array(
                ':worker' => self::MAIL_WORKER_ID,
                ':status' => Queue::STATUS_NEW
            ),
            'limit' => $limit,
            'order' => 'priority desc'
        ));

        echo "Find " . count($models) . " new mail task...\n";

        Yii::log("Find " . count($models) . " new mail task...\n");

        foreach ($models as $model)
        {
            echo "Process mail task id = {$model->id}...\n";

            Yii::log("Process mail task id = {$model->id}...\n");

            if (!$data = (array) json_decode($model->task))
            {
                $model->status = Queue::STATUS_ERROR;

                $model->notice = 'Error json_decode...';

                $model->save();

                echo "Error json_decode...\n";

                Yii::log('Error json_decode...');

                continue;
            }

            if (!isset($data['from'], $data['to'], $data['theme'], $data['body']))
            {
                $model->status = Queue::STATUS_ERROR;

                $model->notice = 'Wrong data...';

                $model->save();

                echo "Wrong data...";

                Yii::log('Wrong data...');

                continue;
            }

            if (Yii::app()->mail->send($data['from'], $data['to'], $data['theme'], $data['body']))
            {
                $model->status = Queue::STATUS_COMLETED;

                $model->complete_time = new CDbExpression('NOW()');

                $model->save();

                echo "Success send...";

                Yii::log("Success send...");

                continue;
            }
        }
    }
}