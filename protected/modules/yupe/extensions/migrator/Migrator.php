<?php
/**
 * Migrator class file.
 *
 * @author Alexander Tischenko <tsm@glavset.ru>
 * @link http://www.yupe.ru
 * @copyright Copyright &copy; 2012 Yupe team
 */

class Migrator extends CApplicationComponent
{
	public $connectionID='db';
    public $migrationTable='migrations';

	public function init()
	{
		return parent::init();
	}

    public function  updateToLatest($module)
    {
        if (($newMigrations = $this->getNewMigrations($module))!==array())
        {
            Yii::log(Yii::t('yupe','Обновляем до последней версии базы модуль {module}', array('{module}'=>$module)));
            foreach($newMigrations as $migration)
                if($this->migrateUp($module, $migration)===false)
                    return false;
        }

        return true;
    }

	protected function migrateUp($module, $class)
	{
        $db = $this->getDbConnection();

        ob_start();
        ob_implicit_flush(false);

        echo Yii::t('yupe',"Применяем миграцию {class}", array('{class}'=> $class));

        $start=microtime(true);
		$migration=$this->instantiateMigration($module,$class);

        // Вставляем запись о начале миграции
        $db->createCommand()->insert($db->tablePrefix.$this->migrationTable, array(
                'version'=>$class,
                'module'=>$module,
                'apply_time'=>0,
            ));

        $result = $migration->up();
        Yii::log($msg=ob_get_clean());

		if($result!==false)
		{
            // Проставляем "установлено"
			$db->createCommand()->update($db->tablePrefix.$this->migrationTable, array(
				'apply_time'=>time(),
			), "`version`=:ver AND `module`=:mod", array(':ver'=> $class, 'mod'=>$module));
			$time=microtime(true)-$start;
            Yii::log(Yii::t('yupe',"Миграция {class} применена за {s} сек.", array('{class}'=> $class, '{s}'=> sprintf("%.3f",$time))));
		}
		else
		{
			$time=microtime(true)-$start;
            Yii::log(Yii::t('yupe',"Ошибка применения миграции {class} ({s} сек.)", array('{class}'=> $class, '{s}'=> sprintf("%.3f",$time))));
            Yii::app()->user->setFlash('warning',$msg);
			return false;
		}
	}

	protected function migrateDown($module, $class)
	{
		Yii::log(Yii::t('yupe',"Отменяем миграцию {class}", array('{class}'=> $class)));
        $db = $this->getDbConnection();
		$start=microtime(true);
		$migration=$this->instantiateMigration($module, $class);

        ob_start();
        ob_implicit_flush(false);
        $result = $migration->down();
        Yii::log($msg=ob_get_clean());

        if($result !==false)
		{
			$db->createCommand()->delete($db->tablePrefix.$this->migrationTable, array(
                $db->quoteColumnName('version')."=".$db->quoteValue($class),
                $db->quoteColumnName('module')."=".$db->quoteValue($module)
            ));
			$time=microtime(true)-$start;
            Yii::log(Yii::t('yupe',"Миграция {class} отменена за {s} сек.", array('{class}'=> $class, '{s}'=> sprintf("%.3f",$time))));
		}
		else
		{
			$time=microtime(true)-$start;
            Yii::log(Yii::t('yupe',"Ошибка отмены миграции {class} ({s} сек.)", array('{class}'=> $class, '{s}'=> sprintf("%.3f",$time))));
            Yii::app()->user->setFlash('warning',$msg);
			return false;
		}
	}

	protected function instantiateMigration($module, $class)
	{
		$file=Yii::getPathOfAlias("application.modules.".$module.".install.migrations").DIRECTORY_SEPARATOR.$class.'.php';
		require_once($file);
		$migration=new $class;
		$migration->setDbConnection($this->getDbConnection());
		return $migration;
	}

	/**
	 * @var CDbConnection
	 */
	private $_db;
	protected function getDbConnection()
	{
		if($this->_db!==null)
			return $this->_db;
		else if(($this->_db=Yii::app()->getComponent($this->connectionID)) instanceof CDbConnection)
			return $this->_db;
        throw new CException(Yii::t('yupe','Неверно указан параметр connectionID'));
	}

	protected function getMigrationHistory($module,$limit=20)
	{
		$db=$this->getDbConnection();
		if($db->schema->getTable($db->tablePrefix.$this->migrationTable)===null)
			$this->createMigrationHistoryTable();

        // @TODO: add cache here??
        $data = $db->createCommand()
                ->select('version, apply_time')
                ->from($db->tablePrefix.$this->migrationTable)
                ->order('version DESC')
                ->where('module=:module', array(':module'=>$module))
			    ->limit($limit)
            ->queryAll();

		return CHtml::listData($data, 'version', 'apply_time');
	}

	protected function createMigrationHistoryTable()
	{
		$db=$this->getDbConnection();
        Yii::log(Yii::t('yupe','Создаем таблицу для хранения версий миграций {table}', array('{table}'=>$this->migrationTable)));

		$db->createCommand()->createTable($db->tablePrefix.$this->migrationTable,array(
            'id'=> 'pk',
            'module'=> 'string NOT NULL',
			'version'=>'string NOT NULL',
			'apply_time'=>'integer',
		),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $db->createCommand()->createIndex("idx_migrations_module",$db->tablePrefix.$this->migrationTable , "module",false);

	}

	protected function getNewMigrations($module)
	{
		$applied=array();
		foreach($this->getMigrationHistory($module, -1) as $version=>$time)
            if ($time)
			    $applied[substr($version,1,13)]=true;

		$migrations=array();
        if ( ($migrationsPath = Yii::getPathOfAlias("application.modules.".$module.".install.migrations")) && is_dir($migrationsPath) )
        {
            $handle=opendir($migrationsPath);
            while(($file=readdir($handle))!==false)
            {
                if($file==='.' || $file==='..')
                    continue;
                $path=$migrationsPath.DIRECTORY_SEPARATOR.$file;
                if(preg_match('/^(m(\d{6}_\d{6})_.*?)\.php$/',$file,$matches) && is_file($path) && !isset($applied[$matches[2]]))
                    $migrations[]=$matches[1];
            }
            closedir($handle);
            sort($migrations);
        }
		return $migrations;
	}

    /*
     * Check each modules for new migrations
     *
     */
    public function checkForUpdates($modules)
    {
        // check for table
        $db=$this->getDbConnection();
        if($db->schema->getTable($db->tablePrefix.$this->migrationTable)===null)
            $this->createMigrationHistoryTable();

        $updates = array();

        foreach($modules as $mid=>$module)
            if ($a=$this->getNewMigrations($mid))
                $updates[$mid]=$a;

        return $updates;
    }

}
