<?php
class YDbQueue extends YQueue
{
    public $queueTableName = 'yupe_queue';
    public $connectionId;
    public $workerNamesMap;
    private $_db;

    public function init()
    {
        parent::init();
    }

    public function getDbConnection()
    {
        if ($this->_db !== null)
            return $this->_db;
        else if (($id = $this->connectionId) !== null)
        {
            if (($this->_db = Yii::app()->getComponent($id)) instanceof CDbConnection)
                return $this->_db;
        }

        throw new CException(Yii::t('QueueModule.queue', 'CDbQueue.connectionId "{id}" is invalid. Please make sure it refers to the ID of a CDbConnection application component.', array('{id}' => $id)));
    }

    public function setDbConnection($value)
    {
        $this->_db = $value;
    }

    public function add($worker, array $data)
    {
        if (($data = json_encode($data)) === false)
            throw new CException(Yii::t('QueueModule.queue', 'Error json_encode !'));
        try
        {
            $command = $this->getDbConnection()->createCommand("INSERT INTO {$this->queueTableName} (worker, task, create_time) VALUES (:worker,:task, NOW())");
            $command->bindValue(':worker', (int) $worker, PDO::PARAM_INT);
            $command->bindValue(':task', $data, PDO::PARAM_STR);
            return $command->execute();
        }
        catch (Exceprion $e)
        {
            return false;
        }
    }

    public function flush($worker = null)
    {
        $sql = "DELETE FROM {$this->queueTableName}";

        $worker = (int) $worker;
        if ($worker)
            $sql .= " WHERE worker = '$worker'";

        $this->getDbConnection()->createCommand($sql)->execute();
        return true;
    }
}