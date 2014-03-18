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
 * A utility class for working with OAuth.
 */
class EOAuthUtils extends EOAuthComponent {
  /**
   * The EOAuthUtils class is not meant to have any instances.
   * @access private
   */
  private function __construct() {}

  /**
   * Using the consumer and scope provided, a request is made to the endpoint
   * to generate an OAuth request token.
   * @param OAuthConsumer $consumer the consumer
   * @param string $scope the scope of the application to authorize
   * @param string $endpoint the OAuth endpoint to make the request against
   * @param string $applicationName optional name of the application to display
   *     on the authorization redirect page
   * @param string $callbackUrl optional callback URL
   * @return OAuthToken a request token
   * @see http://code.google.com/apis/accounts/docs/OAuth_ref.html#RequestToken
   */
  public static function GetRequestToken(OAuthConsumer $consumer, $scope,
      $endpoint, $applicationName, $callbackUrl) {
    $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();

    // Set parameters.
    $params = array();
    $params['scope'] = $scope;
    if (isset($applicationName)) {
      $params['xoauth_displayname'] = $applicationName;
    }
    if (isset($callbackUrl)) {
      $params['oauth_callback'] = $callbackUrl;
    }

    // Create and sign request.
    $request = OAuthRequest::from_consumer_and_token($consumer, NULL, 'GET',
        $endpoint, $params);
    $request->sign_request($signatureMethod, $consumer, NULL);

    // Get token.
    return self::GetTokenFromUrl($request->to_url());
  }

  /**
   * Using the provided request token, an authorization URL is generated for the
   * endpoint.
   * @param OAuthToken $token the request token
   * @param string $endpoint the OAuth endpoint to generate the URL for
   * @return string an authorization URL to redirect the user to
   * @see http://code.google.com/apis/accounts/docs/OAuth_ref.html#GetAuth
   */
  public static function GetAuthorizationUrl(OAuthToken $token, $endpoint) {
    return $endpoint . "?oauth_token=" . $token->key;
  }

  /**
   * Using the provided consumer and authorized request token, a request is
   * made to the endpoint to generate an OAuth access token.
   * @param OAuthConsumer $consumer the consumer
   * @param OAuthToken $token the authorized request token
   * @param string $verifier the OAuth verifier code returned with the callback
   * @param string $endpoint the OAuth endpoint to make the request against
   * @return OAuthToken an access token
   * @see http://code.google.com/apis/accounts/docs/OAuth_ref.html#AccessToken
   */
  public static function GetAccessToken(OAuthConsumer $consumer,
      OAuthToken $token, $verifier, $endpoint) {
    $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();

    // Set parameters.
    $params = array();
    $params['oauth_verifier'] = $verifier;

    // Create and sign request.
    $request = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET',
        $endpoint, $params);
    $request->sign_request($signatureMethod, $consumer, $token);

    // Get token.
    return self::GetTokenFromUrl($request->to_url());
  }

  /**
   * Makes an HTTP request to the given URL and extracts the returned OAuth
   * token.
   * @param string $url the URL to make the request to
   * @return OAuthToken the returned token
   */
  private static function GetTokenFromUrl($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    $headers = curl_getinfo($ch);
    curl_close($ch);

    if ($headers['http_code'] != 200) {
      throw new OAuthException($response);
    }

    return self::GetTokenFromQueryString($response);
  }

  /**
   * Parses a query string and extracts the OAuth token.
   * @param string $queryString the query string
   * @return OAuthToken the token contained within the query string
   */
  private static function GetTokenFromQueryString($queryString) {
    $values = array();
    parse_str($queryString, $values);
    return new OAuthToken($values['oauth_token'],
        $values['oauth_token_secret']);
  }
}
