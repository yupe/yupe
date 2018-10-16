<?php

/**
 * YDbQueue копмпонент для хранения очереди заданий в базе данных
 *
 * @author    yupe team <team@yupe.ru>
 * @link      http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package   yupe.modules.queue.components
 * @license   BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version   0.6
 *
 */
class YDbQueue extends YQueue
{
    public $queueTableName = null;
    public $connectionId;
    public $workerNamesMap;
    private $_db;

    public function init()
    {
        parent::init();

        $this->queueTableName = Queue::model()->tableName();
    }

    public function getDbConnection()
    {
        if ($this->_db !== null) {
            return $this->_db;
        } elseif (($id = $this->connectionId) !== null) {
            if (($this->_db = Yii::app()->getComponent($id)) instanceof CDbConnection) {
                return $this->_db;
            }
        }

        throw new CException(Yii::t(
            'QueueModule.queue',
            'CDbQueue.connectionId "{id}" is invalid. Please make sure it refers to the ID of a CDbConnection application component.',
            ['{id}' => $id]
        ));
    }

    public function setDbConnection($value)
    {
        $this->_db = $value;
    }

    public function add($worker, array $data)
    {
        if (($data = json_encode($data)) === false) {
            throw new CException(Yii::t('QueueModule.queue', 'Error json_encode !'));
        }
        try {
            $command = $this->getDbConnection()->createCommand(
                "INSERT INTO {$this->queueTableName} (worker, task, create_time) VALUES (:worker,:task, NOW())"
            );
            $command->bindValue(':worker', (int)$worker, PDO::PARAM_INT);
            $command->bindValue(':task', $data, PDO::PARAM_STR);

            return $command->execute();
        } catch (Exceprion $e) {
            return false;
        }
    }

    public function flush($worker = null)
    {
        $sql = "DELETE FROM {$this->queueTableName}";

        $worker = (int)$worker;
        if ($worker) {
            $sql .= " WHERE worker = '$worker'";
        }

        $this->getDbConnection()->createCommand($sql)->execute();

        return true;
    }
}
