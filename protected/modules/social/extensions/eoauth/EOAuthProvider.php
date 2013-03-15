<?php
/*
 * This product includes software developed at
 * Google Inc. (http://www.google.es/about.html)
 * under Apache 2.0 License (http://www.apache.org/licenses/LICENSE-2.0.html).
 *
 * See http://google-api-dfp-php.googlecode.com.
 *
 */
/**
 * Example implementation of an Ads OAuth provider.
 */
class EOAuthProvider extends EOAuthComponent/*OAuthProvider*/ {
    public $consumer;
    public $token;

    public $request_token_endpoint=
            'https://www.google.com/accounts/OAuthGetRequestToken';
    public $authorize_token_endpoint =
            'https://www.google.com/accounts/OAuthAuthorizeToken';
    public $access_token_endpoint =
            'https://www.google.com/accounts/OAuthGetAccessToken';

    /**
     * Constructor for EOAuthProvider.
     * @param OAuthConsumer $consumer the OAuth consumer
     * @param OAuthToken $token the OAuth access token
     */
    public function __construct($consumer=null, $token=null) {
        $this->consumer = $consumer;
        $this->token = $token;

    }

    /**
     * Returns the value of the OAuth Authorization HTTP header for a given
     * endpoint URL.
     * @param string $url the endpoint URL to authorize against
     * @return string the OAuth Authorization HTTP header value
     */
    public function GetOAuthHeader($url) {
        $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();
        $request = OAuthRequest::from_consumer_and_token($this->consumer,
                $this->token, 'POST', $url, array());
        $request->sign_request($signatureMethod, $this->consumer, $this->token);
        $header = $request->to_header();
// Remove "Authorization:" prefix.
        $pieces = explode(':', $header, 2);
        return trim($pieces[1]);
    }


}
