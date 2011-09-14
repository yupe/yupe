<?php
class DefaultController extends Controller
{
    public $layout = 'application.modules.install.views.layouts.main';
    
    public $stepName;
	
	private $alreadyInstalledFlag;
    
	public function init()
	{
		$this->alreadyInstalledFlag = Yii::app()->basePath.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'.ai';
	}
	
    protected function beforeAction()
	{		
	    // проверка на то, что сайт уже установлен...
	    if(file_exists($this->alreadyInstalledFlag) && $this->action->id != 'finish')
		{
			throw new CHttpException(404,Yii::t('yupe','Страница не найдена!'));
		}
		
	    return true;	  
	}

	public function actionIndex()
	{
	    $this->stepName = Yii::t('install','Шаг первый : "Приветствие!"');
	
		$this->render('index');
	}
	
	public function actionRequirements()
	{ 
  	    $this->stepName = Yii::t('install','Шаг второй : "Проверка системных требований"');
		
		
		$requirements=array(
							array(
								Yii::t('yii','PHP version'),
								true,
								version_compare(PHP_VERSION,"5.1.0",">="),
								'<a href="http://www.yiiframework.com">Yii Framework</a>',
								Yii::t('yii','PHP 5.1.0 or higher is required.')),							
							array(
								Yii::t('yii','Reflection extension'),
								true,
								class_exists('Reflection',false),
								'<a href="http://www.yiiframework.com">Yii Framework</a>',
								''),
							array(
								Yii::t('yii','PCRE extension'),
								true,
								extension_loaded("pcre"),
								'<a href="http://www.yiiframework.com">Yii Framework</a>',
								''),
							array(
								Yii::t('yii','SPL extension'),
								true,
								extension_loaded("SPL"),
								'<a href="http://www.yiiframework.com">Yii Framework</a>',
								''),
							array(
								Yii::t('yii','DOM extension'),
								false,
								class_exists("DOMDocument",false),
								'<a href="http://www.yiiframework.com/doc/api/CHtmlPurifier">CHtmlPurifier</a>, <a href="http://www.yiiframework.com/doc/api/CWsdlGenerator">CWsdlGenerator</a>',
								''),
							array(
								Yii::t('yii','PDO extension'),
								false,
								extension_loaded('pdo'),
								Yii::t('yii','All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
								''),
							array(
								Yii::t('yii','PDO SQLite extension'),
								false,
								extension_loaded('pdo_sqlite'),
								Yii::t('yii','All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
								Yii::t('yii','This is required if you are using SQLite database.')),
							array(
								Yii::t('yii','PDO MySQL extension'),
								false,
								extension_loaded('pdo_mysql'),
								Yii::t('yii','All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
								Yii::t('yii','This is required if you are using MySQL database.')),
							array(
								Yii::t('yii','PDO PostgreSQL extension'),
								false,
								extension_loaded('pdo_pgsql'),
								Yii::t('yii','All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
								Yii::t('yii','This is required if you are using PostgreSQL database.')),
							array(
								Yii::t('yii','Memcache extension'),
								false,
								extension_loaded("memcache"),
								'<a href="http://www.yiiframework.com/doc/api/CMemCache">CMemCache</a>',
								''),
							array(
								Yii::t('yii','APC extension'),
								false,
								extension_loaded("apc"),
								'<a href="http://www.yiiframework.com/doc/api/CApcCache">CApcCache</a>',
								''),
							array(
								Yii::t('yii','Mcrypt extension'),
								false,
								extension_loaded("mcrypt"),
								'<a href="http://www.yiiframework.com/doc/api/CSecurityManager">CSecurityManager</a>',
								Yii::t('yii','This is required by encrypt and decrypt methods.')),
							array(
								Yii::t('yii','SOAP extension'),
								false,
								extension_loaded("soap"),
								'<a href="http://www.yiiframework.com/doc/api/CWebService">CWebService</a>, <a href="http://www.yiiframework.com/doc/api/CWebServiceAction">CWebServiceAction</a>',
								'')							
							);
		
		$result = 1;

		foreach($requirements as $i=>$requirement)
		{
			if($requirement[1] && !$requirement[2])
			{
				$result=0;
			}
			else if($result > 0 && !$requirement[1] && !$requirement[2])
			{
				$result=-1;
			}
			if($requirement[4] === '')
			{
				$requirements[$i][4]='&nbsp;';
			}
		}
	
   		$this->render('requirements',array('requirements' => $requirements,'result' => $result));
	}
	
	public function actionDbsettings()
	{	
	    $this->stepName = Yii::t('install','Шаг третий : "Соединение с базой данных"');
		
		$dbConfFile = Yii::app()->basePath.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'dbParams.php';
		
		$sqlDataDir = $this->module->basePath.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
		
		$sqlFile    = $sqlDataDir.'yupe.sql';
				
		$form = new DbSettingsForm();
		
		if(Yii::app()->request->isPostRequest)
		{
			$form->setAttributes($_POST['DbSettingsForm']);
			
			if($form->validate())
			{			
				try
				{
					//@TODO правильня обработка указанного номера порта - сейчас вообще не учитывается
					$connectionString = "mysql:host={$form->host};dbname=$form->dbName";
		        	$connection = new CDbConnection($connectionString,$form->user,$form->password);
			        $connection->connectionString = $connectionString;
                    $connection->username = $form->user;
                    $connection->password = $form->password;
                    $connection->emulatePrepare = true;                    
                    $connection->charset = 'utf8';
					$connection->active  = true;
					
					Yii::app()->setComponent('db',$connection);
					
					$dbParams = array(
						    'class'                 => 'CDbConnection',
						    'connectionString'      => "mysql:host={$form->host};dbname=$form->dbName",
						    'username'              => $form->user,
						    'password'              => $form->password,
						    'emulatePrepare'        => true,
						    'charset'               => 'utf8',
						    'enableParamLogging'    => 1,
						    'enableProfiling'       => 1,
						    'schemaCachingDuration' => 108000,
						    'tablePrefix'           => ''
		            );
					
					$dbConfString = "<?php\n return ".var_export($dbParams,true)." ;\n?>";
					
					$fh = fopen($dbConfFile,'w+');
					
					if(!$fh)
					{
					    $form->addError('',Yii::t('install',"Не могу открыть файл '{file}' для записии!",array('{file}' => $dbConfFile)));
					}
					else
					{
					    fwrite($fh,$dbConfString);
						
						fclose($fh);
						
						@chmod($dbConfFile,0666);						
						
						$result = $this->executeSql($sqlFile);
						
						// обработать если есть все файлы с расшмрением .sql
						$sqlFiles = glob("{$sqlDataDir}*.sql");						
						
						if(is_array($sqlFiles) && count($sqlFiles) > 1)
						{
							foreach($sqlFiles as $file)
							{
								if($file != $sqlFile)
								{
									$this->executeSql($file);
								}
							}
						}						
					
						Yii::app()->user->setFlash(FlashMessagesWidget::NOTICE_MESSAGE,Yii::t('install','Настройки базы данных успешно сохранены! База данных проинициализирована!'));
						
						$this->redirect(array('/install/default/createuser/'));
					}				
					
				}
				catch(Exception $e)
				{
				    $form->addError('',$e->getMessage());
				}
			}
		}
		
		$result = $sqlResult = false;
		
		if(file_exists($dbConfFile) && is_writable($dbConfFile))
		{
			$result = true;
		}
		
		if(file_exists($sqlFile) && is_readable($sqlFile))
		{
			$sqlResult = true;
		}
		
   		$this->render('dbsettings',array('model' => $form,'sqlResult' => $sqlResult, 'sqlFile' => $sqlFile, 'result' => $result, 'file' => $dbConfFile));
	}
	
	public function actionCreateuser()
	{
		$this->stepName = Yii::t('install','Шаг четвертый : "Создание учетной записи администратора"');
		
		$model = new CreateUserForm();
		
		if(Yii::app()->request->isPostRequest && isset($_POST['CreateUserForm']))
		{
			$model->setAttributes($_POST['CreateUserForm']);
			
			if($model->validate())
			{
				$user = new User();
				
				$salt = Registration::model()->generateSalt();
				
				$user->setAttributes(array(
						'nickName' => $model->userName,
						'email'    => $model->email,
						'salt'     => $salt,
						'password' => Registration::model()->hashPassword($model->password,$salt),
						'registrationDate' => new CDbExpression('NOW()'),
						'registrationIp'   => Yii::app()->request->userHostAddress,
						'accessLevel'      => User::ACCESS_LEVEL_ADMIN
				));
				
				if($user->save())
				{
					Yii::app()->user->setFlash(FlashMessagesWidget::NOTICE_MESSAGE,Yii::t('install','Администратор успешно создан!'));
					
					@touch($this->alreadyInstalledFlag);
					
					$this->redirect(array('/install/default/sitesettings/'));
				}
			}
		}
		
		$this->render('createuser',array('model' => $model));
	}
	
	public function actionSitesettings()
	{
   	    $this->stepName = Yii::t('install','Шаг пятый : "Настройки проекта"');
		
		$model = new SiteSettingsForm();
	    
		if(Yii::app()->request->isPostRequest)
		{
			$model->setAttributes($_POST['SiteSettingsForm']);
			
			if($model->validate())
			{
				$transaction = Yii::app()->db->beginTransaction();
				
				try
				{
					$user = User::model()->admin()->findAll();				
					
					if(count($user) > 1)
					{
						throw new CHttpException(500,Yii::t('install','Произошла ошибка при установке =('));
					}
					
					foreach(array('siteDescription','siteName','siteKeyWords') as $param)
					{
						$settings = new Settings();
						
						$settings->setAttributes(array(
							'moduleId'   => 'yupe',
							'paramName'  => $param,
							'paramValue' => $model->$param,
							'userId'     => $user[0]->id
						));
						
						if($settings->save())
						{
							continue;
						}
						else
						{
							throw new CDbException(print_r($settings->getErrors(),true));
						}
					}
					
					$transaction->commit();				
					
          			Yii::app()->user->setFlash(FlashMessagesWidget::NOTICE_MESSAGE,Yii::t('install','Настройки сайта успешно сохранены!'));
						
			    	$this->redirect(array('/install/default/finish/'));									
				}
				catch(CDbException $e)
				{
					$transaction->rollback();
					
					Yii::app()->user->setFlash(FlashMessagesWidget::ERROR_MESSAGE,$e->getMessage());
					
					$this->redirect(array('/install/default/sitesettings/'));					
				}				
			}
		}		
		
   		$this->render('sitesettings',array('model' => $model));
	}
	
	public function actionFinish()
	{
   	    $this->stepName = Yii::t('install','Шаг пятый : "Окончание установки"');
	
   	    $this->render('finish');
	}
	
	private function executeSql($sqlFile, $prefix='')
	{		
		$sql = file_get_contents($sqlFile);	
						
		$command = Yii::app()->db->createCommand($sql);
		
		return $command->execute();				
	}

}
?>