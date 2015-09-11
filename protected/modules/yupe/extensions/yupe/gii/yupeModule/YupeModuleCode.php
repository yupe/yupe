<?php

Yii::import('gii.generators.module.ModuleCode');

class YupeModuleCode extends ModuleCode
{
	public $moduleID;
    public $moduleCategory;
    public $moduleIcon;

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('moduleID, moduleCategory, moduleIcon', 'filter', 'filter'=>'trim'),
			array('moduleID, moduleCategory, moduleIcon', 'required'),
			array('moduleID, moduleCategory, moduleIcon', 'match', 'pattern'=>'/^\w+$/', 'message'=>'{attribute} should only contain word characters.'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'moduleID' => 'Модель (название)',
            'moduleCategory' => 'Категория модуля',
            'moduleIcon' => 'Иконка',
		));
	}

	public function successMessage()
	{
		if(Yii::app()->hasModule($this->moduleID))
			return 'The module has been generated successfully. You may '.CHtml::link('try it now', Yii::app()->createUrl($this->moduleID), array('target'=>'_blank')).'.';

		$output=<<<EOD
<p>The module has been generated successfully.</p>
<p>To access the module, you need to modify the application configuration as follows:</p>
EOD;
		$code=<<<EOD
<?php
return array(
    'modules'=>array(
        '{$this->moduleID}',
    ),
    ......
);
EOD;

		return $output.highlight_string($code,true);
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

			if($file!==$moduleTemplateFile)
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
    public function getModifiedFile($file)
    {
        $file = explode(DIRECTORY_SEPARATOR,$file);
        $fileName = $file[count($file)-1];

        $files = [
            'BackendController.php' => ucfirst($this->moduleID).'BackendController.php',
            'Controller.php' => ucfirst($this->moduleID).'Controller.php',
            'migration.php' => 'm000000_000000_'.$this->moduleID.'_base.php',
            'install.php' => $this->moduleID.'.php',
            'message.php' => $this->moduleID.'.php',
            'index.php' => 'index.php'
        ];

        if (isset($files[$fileName]))
        {
            $file[count($file)-1] = $files[$fileName];
            /*if ( $fileName == 'index.php' ) {
                $file[count($file)-2] = $this->moduleID;
            }*/
            $modifiedFile = implode('\\',$file);
            return $modifiedFile;
        }

        return false;
    }
}