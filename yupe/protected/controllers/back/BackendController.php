<?php
class BackendController extends YBackController
{
	public function actionIndex()
	{	
		$this->render('index',Yii::app()->yupe->getModules());
	}
	
	public function actionModulesettings($module)
	{
		$module = Yii::app()->getModule($module);
		
		if(!$module)
		{
			throw new CHttpException(404,Yii::t('yupe','Страница настроек данного модуля недоступна!'));
		}
		
		$elements = array();
		
		$editableParams = $module->getEditableParams();
		
		$moduleParamsLabels = $module->getParamsLabels();
		
		foreach($module as $key => $value)
		{
			if(in_array($key,$editableParams) && !is_object($value) && !is_array($value))
			{
				$elements[$key] = array(
						'type'      => 'text',
						'maxlength' => 200,
						'label'     => $moduleParamsLabels[$key],
						'id'        => $key,
						'name'      => $key,
						'value'     => $value 
				);
			}			
		}
		
		// сформировать боковое меню из ссылок на настройки модулей
		$modules = Yii::app()->yupe->getModules();
		
		$menu    = array();
		
		foreach($modules['modules'] as $oneModule)
		{
			if($oneModule->getEditableParams())
			{
			    array_push($menu,array('label' => $oneModule->getName(),'url' => $this->createUrl('/back/backend/modulesettings/',array('module' => $oneModule->getId()))));
			}
		}		
		
		$this->render('modulesettings',array('menu' => $menu,'module' => $module,'elements' => $elements));
	}


	public function actionSaveModulesettings()
	{
		if(Yii::app()->request->isPostRequest)
		{		
			$moduleId = Yii::app()->request->getPost('moduleId');
			
			if(!$moduleId)
			{
				throw new CHttpException(404,Yii::t('yupe','Страница не найдена!'));
			}
			
			$module = Yii::app()->getModule($moduleId);
			
			if(!$module)
			{
				throw new CHttpException(404,Yii::t('yupe','Модуль "{module}" не найден!',array('{module}' => $moduleId)));
			}
			
			$editableParams = $module->getEditableParams();
			
			$transaction = Yii::app()->db->beginTransaction();
				
			try
			{
				Settings::model()->deleteAll('moduleId = :moduleId',array(':moduleId' => $moduleId));
				
				foreach($_POST as $key => $value)
				{
					if(in_array($key,$editableParams))
					{						
						$model = new Settings();
						
						$model->setAttributes(array(
							'moduleId'   => $moduleId,
							'paramName'  => $key,
							'paramValue' => $value
						));
						
						if(!$model->save())
						{
							//@TODO  исправить вывод ошибок
							Yii::app()->user->setFlash(FlashMessagesWidget::ERROR_MESSAGE,print_r($model->getErrors(),true));
				
				            $this->redirect(array('/back/backend/modulesettings','module' => $moduleId));				
						}
					}
				}
				
				$transaction->commit();
				
				Yii::app()->user->setFlash(FlashMessagesWidget::NOTICE_MESSAGE,Yii::t('yupe','Настройки модуля "{module}" сохранены!',array('{module}' => $module->getName())));
				
				//@TODO сброс полностью - плохо =(
				Yii::app()->cache->flush();
				
				$this->redirect(array('/back/backend/modulesettings/','module' => $moduleId));				
			}
			catch(Exception $e)
			{
				$transaction->rollback();
				
				Yii::app()->user->setFlash(FlashMessagesWidget::ERROR_MESSAGE,$e->getMEssage());
				
				$this->redirect(array('/back/backend/modulesettings','module' => $moduleId));
			}			
		}
		
		throw new CHttpException(404,Yii::t('yupe','Странцйа не найдена!'));
	}
	
	
	public function actionThemesettings()
	{		
		if(Yii::app()->request->isPostRequest && isset($_POST['theme']))
		{
			$theme = Yii::app()->request->getPost('theme');		
			
			$settings = Settings::model()->find('moduleId = :moduleId AND paramName = :paramName',array(':moduleId' => Yii::app()->yupe->coreModuleId,':paramName' => 'theme'));
			
			if(!is_null($settings))
			{
				$settings->paramValue = $theme;
				
				if($settings->save())
				{
					Yii::app()->user->setFlash(FlashMessagesWidget::NOTICE_MESSAGE,Yii::t('yupe','Настройки сохранены!'));
					
					//@TODO сброс полностью - плохо =(
					Yii::app()->cache->flush();
					
					$this->redirect(array('/back/backend/themesettings/'));
				}
			}
			else
			{
				$settings = new Settings();
				
				$settings->setAttributes(array(
					'moduleId'   => Yii::app()->yupe->coreModuleId,
					'paramName'  => 'theme',
					'paramValue' => $theme
				));
				
				if($settings->save())
				{
					Yii::app()->user->setFlash(FlashMessagesWidget::NOTICE_MESSAGE,Yii::t('yupe','Настройки сохранены!'));
					
					//@TODO сброс полностью - плохо =(
					Yii::app()->cache->flush();
					
					$this->redirect(array('/back/backend/themesettings/'));
				}
			}
			
			Yii::app()->user->setFlash(FlashMessagesWidget::ERROR_MESSAGE,Yii::t('yupe','При сохранении произошла ошибка!'));
					
			$this->redirect(array('/back/backend/themesettings/'));
		}
		
		$themes = array();
		
		if($handler = opendir(Yii::app()->themeManager->basePath))
		{
			$file = false;
			
			while(($file = readdir($handler)))
			{				
				if($file != '.' && $file != '..' && !is_file($file))
				{
					$themes[$file] = $file;
				}
			}
			
			closedir($handler);
		}		
		
		$theme = Yii::app()->theme ? Yii::app()->theme->name : Yii::t('yupe','Тема не используется');
		
		$this->render('themesettings',array('themes' => $themes,'theme' => $theme));
	}
	
}
?>