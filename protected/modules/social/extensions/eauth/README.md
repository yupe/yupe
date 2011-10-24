Yii EAuth extension
===================

EAuth extension allows to authenticate users by the OpenID and OAuth providers.

Supported providers out of box:

* OpenID: Google, Yandex;
* OAuth: Twitter;
* OAuth 2.0: Google, Facebook, VKontakte, Mail.ru.


### Resources

* [Yii EAuth](https://github.com/Nodge/yii-eauth)
* [Yii Framework](http://yiiframework.com/)
* [OpenID](http://openid.net/)
* [OAuth](http://oauth.net/)
* [OAuth 2.0](http://oauth.net/2/)
* [loid extension](http://www.yiiframework.com/extension/loid)
* [EOAuth extension](http://www.yiiframework.com/extension/eoauth)


### Requirements

* Yii 1.1 or above
* PHP curl extension
* [loid extension](http://www.yiiframework.com/extension/loid)
* [EOAuth extension](http://www.yiiframework.com/extension/eoauth)


## Installation

* Install loid and EOAuth extensions
* Extract the release file under `protected/extensions`
* In your `protected/config/main.php`, add the following:

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
			'popup' => true, // Use the popup window instead of redirecting.
			'services' => array( // You can change the providers and their classes.
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


## Usage

#### The user identity

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

#### The action

```php
<?php
...
	public function actionLogin() {
		$service = Yii::app()->request->getQuery('service');
		if (isset($service) in_array($service, array())) {
			$authIdentity = Yii::app()->eauth->getIdentity($service);
			$authIdentity->redirectUrl = Yii::app()->user->returnUrl;
			$authIdentity->cancelUrl = $this->createAbsoluteUrl('site/login');
			
			if ($authIdentity->authenticate()) {
				$identity = new ServiceUserIdentity($authIdentity);
				
				// successful authentication
				if ($identity->authenticate()) {
					Yii::app()->user->login($identity);
					
					// special redirect with closing popup window
					$authIdentity->redirect();
				}
				else {
					// close popup window and redirect to cancelUrl
					$authIdentity->cancel();
				}
			}
			
			// Something went wrong, redirect to login page
			$this->redirect(array('site/login'));
		}
		
		// default action code...
	}
```

#### The view

```php
<h2>Do you already have an account on one of these sites? Click the logo to log in with it here:</h2>
<?php 
	Yii::app()->eauth->renderWidget();
?>
```


## License

Some time ago I developed this extension for [LiStick.ru](http://listick.ru) and I still support the extension.

The extension was released under the [New BSD License](http://www.opensource.org/licenses/bsd-license.php), so you'll find the latest version on [GitHub](https://github.com/Nodge/yii-eauth).
