Yii EAuth extension
===================

Расширение EAuth позволяет добавить на сайт авторизацию с помощью OpenID и OAuth провайдеров.

Поддерживаемые провайдеры "из коробки":

* OpenID: Google, Яндекс;
* OAuth: Twitter;
* OAuth 2.0: Google, Facebook, ВКонтакте, Mail.ru.


### Ссылки

* [Yii EAuth](https://github.com/Nodge/yii-eauth)
* [Yii Framework](http://yiiframework.com/)
* [OpenID](http://openid.net/)
* [OAuth](http://oauth.net/)
* [OAuth 2.0](http://oauth.net/2/)
* [loid extension](http://www.yiiframework.com/extension/loid)
* [EOAuth extension](http://www.yiiframework.com/extension/eoauth)


### Системные требования

* Yii 1.1 or above
* PHP curl extension
* [loid extension](http://www.yiiframework.com/extension/loid)
* [EOAuth extension](http://www.yiiframework.com/extension/eoauth)


## Установка

* Установить расширения loid и EOAuth.
* Распаковать расширение EAuth в директорию `protected/extensions`.
* Добавить следующие строки в файл конфигурации `protected/config/main.php`:

```php
<?php
...
	'import'=>array(
		'ext.eoauth.*',
		'ext.eoauth.lib.*',
		'ext.lightopenid.*',
		'ext.eauth.services.*',
	),
...
	'components'=>array(
		'loid' => array(
			'class' => 'ext.lightopenid.loid',
		),
		'eauth' => array(
			'class' => 'ext.eauth.EAuth',
			'popup' => true, // Использовать всплывающее окно вместо перенаправления на сайт провайдера
			'services' => array( // Вы можете настроить список провайдеров и переопределить их классы
				'google' => array(
					'class' => 'GoogleOpenIDService',
				),
				'yandex' => array(
					'class' => 'YandexOpenIDService',
				),
				'twitter' => array(
					'class' => 'TwitterOAuthService',
					'key' => '...',
					'secret' => '...',
				),
				'google_oauth' => array(
					'class' => 'GoogleOAuthService',
					'client_id' => '...',
					'client_secret' => '...',
					'title' => 'Google (OAuth)',
				),
				'facebook' => array(
					'class' => 'FacebookOAuthService',
					'client_id' => '...',
					'client_secret' => '...',
				),
				'vkontakte' => array(
					'class' => 'VKontakteOAuthService',
					'client_id' => '...',
					'client_secret' => '...',
				),
				'mailru' => array(
					'class' => 'MailruOAuthService',
					'client_id' => '...',
					'client_secret' => '...',
				),
			),
		),
		...
	),
...
```


## Использование

#### Класс UserIdentity

```php
<?php

class ServiceUserIdentity extends UserIdentity {
	const ERROR_NOT_AUTHENTICATED = 3;

	/**
	 * @var EAuthServiceBase the authorization service instance.
	 */
	protected $service;
	
	/**
	 * Constructor.
	 * @param EAuthServiceBase $service the authorization service instance.
	 */
	public function __construct($service) {
		$this->service = $service;
	}
	
	/**
	 * Authenticates a user based on {@link username}.
	 * This method is required by {@link IUserIdentity}.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {		
		if ($this->service->isAuthenticated) {
			$this->username = $this->service->getAttribute('name');
			$this->setState('id', $this->service->id);
			$this->setState('name', $this->username);
			$this->setState('service', $this->service->serviceName);
			$this->errorCode = self::ERROR_NONE;		
		}
		else {
			$this->errorCode = self::ERROR_NOT_AUTHENTICATED;
		}
		return !$this->errorCode;
	}
}
```

#### Действие в контроллере

```php
<?php
...
	public function actionLogin() {
		$service = Yii::app()->request->getQuery('service');
		if (isset($service)) {
			$authIdentity = Yii::app()->eauth->getIdentity($service);
			$authIdentity->redirectUrl = Yii::app()->user->returnUrl;
			$authIdentity->cancelUrl = $this->createAbsoluteUrl('site/login');
			
			if ($authIdentity->authenticate()) {
				$identity = new ServiceUserIdentity($authIdentity);
				
				// успешная авторизация
				if ($identity->authenticate()) {
					Yii::app()->user->login($identity);
					
					// специальное перенаправления для корректного закрытия всплывающего окна
					$authIdentity->redirect();
				}
				else {
					// закрытие всплывающего окна и перенаправление на cancelUrl
					$authIdentity->cancel();
				}
			}
			
			// авторизация не удалась, перенаправляем на страницу входа
			$this->redirect(array('site/login'));
		}
		
		// далее стандартный код авторизации по логину/паролю...
	}
```

#### Представление

```php
<h2>Нажмите на иконку для входа через один из сайтов:</h2>
<?php 
	$this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login'));
?>
```


## Лицензия

Некоторое время назад я разработал данное расширение для своего проекта [LiStick.ru](http://listick.ru). На данный момент я продолжаю поддерживать расширение.

Расширение предоставляется под лицензией [New BSD License](http://www.opensource.org/licenses/bsd-license.php), так что последнюю версию можно найти на [GitHub](https://github.com/Nodge/yii-eauth).
