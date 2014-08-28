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
use yupe\components\ConsoleCommand;

class YQueueMailSenderCommand extends ConsoleCommand
{
    const MAIL_WORKER_ID = 1;

    public $logCategory = 'mail';

    public $from;

    public $sender = 'mail';

    public function getLogCategory()
    {
        return 'mail';
    }

    public function actionIndex($limit = 5)
    {
        $limit = (int)$limit;

        $this->log("Try process {$limit} mail tasks...");

        $queue = new Queue();

        $models = $queue->getTasksForWorker(self::MAIL_WORKER_ID, $limit);

        $this->log("Find " . count($models) . " new mail task");

        foreach ($models as $model) {
            $this->log("Process mail task id = {$model->id}");

            $data = $model->decodeJson();

            if (!$data) {
                $model->completeWithError('Error json_decode', CLogger::LEVEL_ERROR);

                $this->log("Error json_decode");

                continue;
            }

            if (!isset($data['from'], $data['to'], $data['theme'], $data['body'])) {
                $model->completeWithError('Wrong data...');

                $this->log('Wrong data...', CLogger::LEVEL_ERROR);

                continue;
            }

            $from = $this->from ? $this->from : $data['from'];

            if (Yii::app()->getComponent($this->sender)->send($from, $data['to'], $data['theme'], $data['body'])) {
                $model->complete();

                $this->log("Success send mail");

                continue;
            }

            $this->log('Error sending email', CLogger::LEVEL_ERROR);
        }
    }
}
