<?php
/**
 * CustomOdnoklassnikiService class file.
 *
 * @author Sergey Vardanyan <rakot.ss@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)) . '/services/OdnoklassnikiOAuthService.php';

class CustomOdnoklassnikiService extends OdnoklassnikiOAuthService {

//	protected $scope = 'VALUABLE ACCESS';

	protected function fetchAttributes() {
		$info = $this->makeSignedRequest('http://api.odnoklassniki.ru/fb.do', array(
			'query' => array(
				'method' => 'users.getCurrentUser',
				'format' => 'JSON',
				'application_key' => $this->client_public,
				'client_id' => $this->client_id,
			),
		));

		$this->attributes = json_decode(json_encode($info), true);
		$this->attributes['id'] = $info->uid;
		$this->attributes['name'] = $info->first_name . ' ' . $info->last_name;

		if ($this->scope == 'VALUABLE ACCESS') {
			$this->getRealIdAndUrl();
		}
	}

	/**
	 * Avable only if VALUABLE ACCESS is on
	 * you should ask for enable this scope for odnoklassniki administration
	 */
	protected function getRealIdAndUrl() {
		$info = $this->makeSignedRequest('http://api.odnoklassniki.ru/fb.do', array(
			'query' => array(
				'method' => 'users.getInfo',
				'uids' => $this->attributes['id'],
				'fields' => 'url_profile',
				'format' => 'JSON',
				'application_key' => $this->client_public,
				'client_id' => $this->client_id,
			),
		));

		preg_match('/\d+\/{0,1}$/', $info[0]->url_profile, $matches);
		$this->attributes['id'] = (int)$matches[0];
		$this->attributes['url'] = $info[0]->url_profile;
	}

	public function wallPost($data) {
		$post = array(
			'application_key' => $this->client_public,
			'method' => 'share.addLink',
			'format' => 'JSON',
		);
		if (isset($data['link'])) {
			$post['linkUrl'] = $data['link'];
		}

		if (isset($data['message'])) {
			$post['comment'] = $data['message'];
		}
		$this->makeSignedRequest('http://api.odnoklassniki.ru/fb.do', array(
			'query' => $post
		));
	}

}
