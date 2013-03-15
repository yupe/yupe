<?php
/**
 * An example of extending the provider class.
 *
 * @author ChooJoy <choojoy.work@gmail.com>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
 
require_once dirname(dirname(__FILE__)).'/services/MailruOAuthService.php';

class CustomMailruService extends MailruOAuthService {	

	protected function fetchAttributes() {
		$info = (array)$this->makeSignedRequest('http://www.appsmail.ru/platform/api', array(
			'query' => array(
				'uids' => $this->uid,
				'method' => 'users.getInfo',
				'app_id' => $this->client_id,
			),
		));
		
		$info = $info[0];
		
		$this->attributes['id'] = $info->uid;
		$this->attributes['first_name'] = $info->first_name;
		$this->attributes['photo'] = $info->pic;
	}
	
}
