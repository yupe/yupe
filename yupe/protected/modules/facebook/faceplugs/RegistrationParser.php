<?php

/**
 * Wrappers for facebook plugins.
 * @copyright © Digitick <www.digitick.net> 2011
 * @license GNU Lesser General Public License v3.0
 * @author Ianaré Sévi
 */

/**
 * The registration parser is used to convert the JSON response from Facebook
 * into a format easily inserted into Yii applications.
 *
 * THIS IS UNFINISHED, UNTESTED CODE !!
 *
 * !!!! DO NOT USE !!!!
 */
class RegistrationParser extends CComponent
{
	public $data;
	public $app_id;
	public $app_secret;
	public $mapper;

	protected $testData = '{
					   "oauth_token": "...big long string...",
					   "algorithm": "HMAC-SHA256",
					   "expires": 1291840400,
					   "issued_at": 1291836800,
					   "registration": {
					      "name": "Paul Tarjan",
					      "email": "fb@paulisageek.com",
					      "location": {
					         "name": "San Francisco, California",
					         "id": 114952118516947
					      },
					      "gender": "male",
					      "birthday": "12/16/1985",
					      "like": true,
					      "phone": "555-123-4567",
					      "anniversary": "2/14/1998",
					      "captain": "K",
					      "force": "jedi",
					      "live": {
					         "name": "Denver, Colorado",
					         "id": 115590505119035
					      }
					   },
					   "user_id": "218471"
					}';

	/**
	 * change the facebook response to an objet
	 * @return Object $response
	 */
	public function parse_signed_request()
	{
		$data = json_decode($this->testData);
		if (strtoupper($data->algorithm) !== 'HMAC-SHA256') {
			if (YII_DEBUG) {
				throw new CException('Unknown algorithm : "'. $data->algorithm .'" . Expected HMAC-SHA256');
			}
			return null;
		}
		return $data->registration;
	}

	/**
	 * 
	 * @param $input
	 * @return string
	 */
	protected function base64UrlDecode($input)
	{
		return base64_decode(strtr($input, '-_', '+/'));
	}

}