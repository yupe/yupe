<?php
/**
 * GitHubOAuthService class file.
 *
 * Register application: https://github.com/settings/applications
 * 
 * @author Alexander Shkarpetin <ashkarpetin@gmail.com>
 * @link https://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)).'/services/GitHubOAuthService.php';

class CustomGitHubOAuthService extends GitHubOAuthService {

    protected function fetchAttributes() {
        $info = (object) $this->makeSignedRequest('https://api.github.com/user');
    
        $this->attributes['id'] = $info->id;
        $this->attributes['name'] = $info->login;
        $this->attributes['url'] = $info->html_url;
        
        $this->attributes['following'] = $info->following;
        $this->attributes['followers'] = $info->followers;
        $this->attributes['public_repos'] = $info->public_repos;
        $this->attributes['public_gists'] = $info->public_gists;
        $this->attributes['avatar_url'] = $info->avatar_url;
    }
}