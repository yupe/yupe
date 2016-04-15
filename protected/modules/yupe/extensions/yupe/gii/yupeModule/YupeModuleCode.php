<?php

Yii::import('gii.generators.module.ModuleCode');

class YupeModuleCode extends ModuleCode
{
	public $moduleID;
    public $moduleCategory;
    public $moduleIcon;
    public $generateMigration;

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('moduleID, moduleCategory, moduleIcon', 'filter', 'filter'=>'trim'),
			array('moduleID, moduleCategory, moduleIcon', 'required'),
			array('moduleID, moduleCategory, moduleIcon', 'match', 'pattern'=>'/^\w+$/', 'message'=>'{attribute} should only contain word characters.'),
            array('generateMigration', 'sticky'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'moduleID' => 'Модель (название)',
            'moduleCategory' => 'Категория модуля',
            'moduleIcon' => 'Иконка',
            'generateMigration' => 'Сгенерировать файл миграции',
		));
	}

	public function successMessage()
	{
        if(Yii::app()->hasModule($this->moduleID))
            return 'Модуль с таким названием был сгенерирован ранее. Введите пожалуйста другое название.';

        $output=<<<EOD
<p>Модуль успешно сгенерирован.<br/>Для его установки необходимо перейти на страницу <a href="/backend/settings">Модули</a>.<br/>Не забудьте отключить модуль gii перед переходом.</p>
EOD;

        return $output;
	}

	public function prepare()
	{
		$this->files=array();
		$templatePath=$this->templatePath;
		$modulePath=$this->modulePath;
		$moduleTemplateFile=$templatePath.DIRECTORY_SEPARATOR.'module.php';

		$this->files[]=new CCodeFile(
			$modulePath.'/'.$this->moduleClass.'.php',
			$this->render($moduleTemplateFile)
		);

		$files=CFileHelper::findFiles($templatePath,array(
			'exclude'=>array(
				'.svn',
				'.gitignore'
			),
		));

		foreach($files as $file)
		{
			if($file!==$moduleTemplateFile && !$this->isIgnireFile($file))
			{
				if(CFileHelper::getExtension($file)==='php')
					$content=$this->render($file);
				elseif(basename($file)==='.gitkeep')  // an empty directory
				{
					$file=dirname($file);
					$content=null;
				}
				else
					$content=file_get_contents($file);

                $modifiedFile = $this->getModifiedFile($file);
                if ( $modifiedFile !== false )
                    $file = $modifiedFile;

				$this->files[]=new CCodeFile(
					$modulePath.substr($file,strlen($templatePath)),
					$content
				);
			}
		}
	}

    /**
     * Возвращаем название класса модуля
     * @return string
     */
	public function getModuleClass()
	{
		return ucfirst($this->moduleID).'Module';
	}

    /**
     * Возвращаем путь к папке модуля
     * @return string
     */
	public function getModulePath()
	{
		return Yii::app()->modulePath.DIRECTORY_SEPARATOR.$this->moduleID;
	}

    /**
     * Вписываем в название файла название модуля
     * @param $file
     * @return bool|string
     */
    private function getModifiedFile($file)
    {
        $file = explode(DIRECTORY_SEPARATOR,$file);
        $fileName = $file[count($file)-1];

        $files = [
            'BackendController.php' => ucfirst($this->moduleID).'BackendController.php',
            'Controller.php' => ucfirst($this->moduleID).'Controller.php',
            'migration.php' => 'm000000_000000_'.$this->moduleID.'_base.php',
            'install.php' => $this->moduleID.'.php',
            'message.php' => $this->moduleID.'.php',
            'BackendIndex.php' => $this->moduleID.'Backend'.DIRECTORY_SEPARATOR.'index.php',
            'Index.php' => $this->moduleID.DIRECTORY_SEPARATOR.'index.php'
        ];

        if (isset($files[$fileName]))
        {
            $file[count($file)-1] = $files[$fileName];
            $modifiedFile = implode('\\',$file);
            return $modifiedFile;
        }

        return false;
    }

    private function isIgnireFile($file)
    {
        if ( strpos($file, 'migration.php') && $this->generateMigration == 0 ) {
            return true;
        }

        return false;
    }
}