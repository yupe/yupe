<?php
/*
 * This product includes software developed at
 * Google Inc. (http://www.google.es/about.html)
 * under Apache 2.0 License (http://www.apache.org/licenses/LICENSE-2.0.html).
 *
 * See http://google-api-dfp-php.googlecode.com.
 *
 */
class EOAuthUserIdentity extends EOAuthComponent implements IUserIdentity {

    /**
     * @var string (required)
     * For example 'https://sandbox.google.com/apis/ads/publisher/'
     */
    public $scope;

    /**
     * @var string OAuth consumer key. Defaults to 'anonymous'
     */
    public $key='anonymous';
    /**
     * @var string OAuth consumer secret. Defaults to 'anonymous'
     */
    public $secret='anonymous';

    /**
     * @var array|class OAuthProvider configuration|class.
     * If using array:
     *      'provider'=>array(
     *          'request'=>'https://www...',
     *          'authorize'=>'https://www...',
     *          'access'=>'https://www...',
     *      )
     *
     * @see EOAuthProvider
     */
    private $provider;


    private $_providerClass='EOAuthProvider';
    private $_authenticated=false;
    private $_error;

    public function __construct($attributes) {

        if(is_array($attributes)) {
            if(isset($attributes['provider'])) {
                $this->setProvider($attributes['provider']);
                unset($attributes['provider']);
            }
            else
                $this->setProvider();
            
            foreach($attributes as $attr=>$value)
                $this->$attr=$value;
        }
        else return null;
    }

    public function getError(){
        return $this->_error;
    }

    public function setError($msg) {
        $this->_error=$msg;
    }

    public function getIsAuthenticated() {
        return $this->_authenticated;
    }

    public function getId() {
        return $this->provider->token->key;
    }

    public function getName() {
        return $this->provider->token->key;
    }

    public function getPersistentStates() {
    }

    public function authenticate() {

        $session=Yii::app()->session;

        if (isset($_REQUEST['oauth_token'])) {
            $oauthToken = $_REQUEST['oauth_token'];
        }
        if (isset($_REQUEST['oauth_verifier'])) {
            $oauthVerifier = $_REQUEST['oauth_verifier'];
        }

        try {

        if (!isset($oauthToken)) {
            // Create consumer.
            $consumer = new OAuthConsumer($this->key, $this->secret);

            // Set the scope (must match service endpoint).
            $scope = $this->scope;

            // Set the application name as it is displayed on the authorization page.
            $applicationName = Yii::app()->name;

            // Use the URL of the current page as the callback URL.
            $protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
                    ? 'https://' : 'http://';
            $server = $_SERVER['HTTP_HOST'];
            $path = $_SERVER["REQUEST_URI"];
            $callbackUrl = $protocol . $server . $path;

            // Get request token.
            $token = EOAuthUtils::GetRequestToken($consumer, $scope,
                    $this->provider->request_token_endpoint, $applicationName, $callbackUrl);

            // Store consumer and token in session.
            $session['OAUTH_CONSUMER'] = $consumer;
            $session['OAUTH_TOKEN'] = $token;

            // Get authorization URL.
            $url = EOAuthUtils::GetAuthorizationUrl($token,
                    $this->provider->authorize_token_endpoint);

            // Redirect to authorization URL.
            Yii::app()->request->redirect($url);
        } else {
            // Retrieve consumer and token from session.
            $consumer = $session['OAUTH_CONSUMER'];
            $token = $session['OAUTH_TOKEN'];

            // Set authorized token.
            $token->key = $oauthToken;

            // Upgrade to access token.
            $token = EOAuthUtils::GetAccessToken($consumer, $token, $oauthVerifier,
                    $this->provider->access_token_endpoint);

            // Set OAuth provider.
            $this->provider->consumer=$consumer;
            $this->provider->token=$token;

            $this->_authenticated=true;
        }

        } catch (OAuthException $e) {
            $this->_error=$e->getMessage();
        }

        return $this->isAuthenticated;
    }

    public function setProvider($provider='EOAuthProvider') {
        if(is_string($provider))
            $this->_providerClass=$provider;
        $this->provider= new $this->_providerClass;
        if(is_array($provider))
            foreach($provider as $attr=>$val) {
                $attribute=$attr.'_token_endpoint';
                $this->provider->$attribute=$val;
            }


    }
    public function getProvider(){
        return $this->provider;
    }

}
?>
