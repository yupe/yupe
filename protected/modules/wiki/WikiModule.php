<?php
/**
 * Yeeki module.
 *
 * Includes all necessary wiki functionality. Can be used as a module in your
 * application.
 */
class WikiModule extends YWebModule
{
    // Yupe method
    public function getCategory()
    {
        return Yii::t('menu', 'Контент');
    }

    public function getNavigation()
    {
        return array(
            //Yii::t('menu', 'Wiki')=>'/wiki/default/admin/',
        );
    }

    public function getName()
    {
        return Yii::t('menu', 'Wiki');
    }

    public function getDescription()
    {
        return Yii::t('menu', 'Модуль для создания и редактирования меню');
    }

    public function getVersion()
    {
        return Yii::t('comment', '1.0');
    }

    public function getAuthor()
    {
        return Yii::t('menu', 'Alexander Makarov, @samdark. Mark Bryk, @mbryk.');
    }

    public function getAuthorEmail()
    {
        return Yii::t('menu', 'sam@rmcreative.ru');
    }

    public function getUrl()
    {
        return Yii::t('menu', 'https://github.com/samdark/Yeeki');
    }
    
    // Yeeki method
	/**
	 * @var array Markup transformations config used to process wiki page text.
	 * These are executed sequentionally
	 */
	public $markupProcessors = array(
		array(
			'class' => 'MarkdownMarkup',
			'purify' => true,
		),
	);

	/**
	 * @var array Auth adapter config
	 */
	public $authAdapter = array(
		'class' => 'YiiAuth',
	);

	/**
	 * @var array Search adapter config
	 */
	public $searchAdapter = array(

	);

	/**
	 * @var array User adapter config
	 */
	public $userAdapter = array(
		//'class' => 'WikiUser',
	);

	/**
	 * @var AbstractMarkup[]
	 */
	private $_markupProcessors;

	public function init()
	{
		// import the module-level models and components
		$this->setImport(array(
			'wiki.models.*',
			'wiki.components.*',
		));

		/** @var $cs CClientScript */
		$cs = Yii::app()->clientScript;

		if(!isset($cs->packages['yeeki']))
		{
			$cs->addPackage('yeeki',array(
				'basePath' => 'wiki.assets',
				'depends' => array('jquery'),
				'css' => array('wiki.css'),
				'js' => array('jquery.markitup.js', 'wiki.js'),
			));
		}
		$cs->registerPackage('yeeki');
	}

	/**
	 * @return AbstractMarkup[]
	 */
	public function getMarkupProcessors()
	{
		if($this->_markupProcessors===null)
		{
			Yii::import('wiki.components.markup.*');
			foreach($this->markupProcessors as $markupConfig)
			{
				$this->_markupProcessors[] = Yii::createComponent($markupConfig);
			}

		}
		return $this->_markupProcessors;
	}

	/**
	 * @var IWikiAuth
	 */
	private $_auth;

	/**
	 * @return IWikiAuth
	 */
	public function getAuth()
	{
		Yii::import('wiki.components.auth.*');
		if($this->_auth===null)
		{
			$this->_auth = Yii::createComponent($this->authAdapter);
		}
		return $this->_auth;
	}

	/**
	 * @var IWikiUser
	 */
	private $_userAdapter;
	public function getUserAdapter()
	{
		Yii::import('wiki.components.auth.*');
		if($this->_userAdapter===null)
		{
			$this->_userAdapter = Yii::createApplication($this->userAdapter);
		}
		return $this->_userAdapter;
	}
}
