Introduction
------------
EOAuthUserIdentity class implements IUserIdentity Yii interface and the OAuth protocol to authenticate a user.

Based on Google's software.

[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=jorgebg&url=https://github.com/jorgebg/yii-eoauth&title=yii-eoauth&language=en_GB&tags=github&category=software) 

###Resources
* [OAuth](http://oauth.net/)
* [InDaHouseRulez SL](http://www.indahouserulez.com)
* [Google API DFP PHP Example web application](http://code.google.com/p/google-api-dfp-php/source/browse/trunk#trunk/webapp/lib)



##Documentation

###Requirements
* Yii 1.0 or above

###Installation
* Extract the release file under `protected/extensions/eoauth`

###Usage

Use this sample actions for login/logout with Google:


~~~
[php]

    public function actionLogin() {

        Yii::import('ext.eoauth.*');

        $ui = new EOAuthUserIdentity(
                array(
                	//Set the "scope" to the service you want to use
                        'scope'=>'https://sandbox.google.com/apis/ads/publisher/',
                        'provider'=>array(
                                'request'=>'https://www.google.com/accounts/OAuthGetRequestToken',
                                'authorize'=>'https://www.google.com/accounts/OAuthAuthorizeToken',
                                'access'=>'https://www.google.com/accounts/OAuthGetAccessToken',
                        )
                )
        );

        if ($ui->authenticate()) {
            $user=Yii::app()->user;
            $user->login($ui);
            $this->redirect($user->returnUrl);
        }
        else throw new CHttpException(401, $ui->error);

    }



    public function actionLogout() {

        Yii::app()->user->logout();

        // Redirect to application home page.
        $this->redirect(Yii::app()->homeUrl);
    }

~~~


Set to load the extensions in the main.php (by [DavidHHuan](http://www.yiiframework.com/user/2371/), thanx!)

~~~
[php]
'import'=>array(
    'application.models.*',
    'application.components.*',
        'ext.eoauth.*',
        'ext.eoauth.lib.*',
),
~~~


License
---------
Some time ago I developed this extension for [InDaHouseRulez SL](http://www.indahouserulez.com). I no longer work there, but I still support the extension.

The extension was released under the [MIT license](http://www.opensource.org/licenses/mit-license.php), so I made a fork on [GitHub](https://github.com), where you'll find the latest version:

[https://github.com/jorgebg/yii-eoauth](https://github.com/jorgebg/yii-eoauth)