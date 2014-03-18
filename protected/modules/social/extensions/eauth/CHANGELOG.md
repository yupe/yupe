Yii EAuth Change Log
====================

### 08.08.2013
* Added proper error handling.
* Added Ukrainian translation.

### 08.07.2013
* Added default scope to Linkedin provider.

### 15.06.2013
* Update Twitter API to 1.1 (fixed #61)
* Add User-Agent header in GitHubOAuthService.php (fixed #60)
* Reformat source code
* Added ability to change OpenID realm
* Added OpenID optional attributes

### Changes before 15.06.2013
* Added Microsoft Live OAuth provider.
* Added Yandex OAuth provider.
* Added CustomFacebookService example class.
* Added 'cache' and 'cacheExpire' options to control cache.
* Added list of services to display in the EAuthWidget.
* Changed VK.com API urls.

### Version 1.1.8 (10.06.2012)
* Added optional headers in EOAuthServiceBase::initRequest().
* Added LinkedIn OAuth provider.
* Added GitHub OAuth provider.
* Fixed sending signed requests with the query parameters in the EOAuthService.

### Version 1.1.7 (30.03.2012)
* Fixed issue #11. Twitter must authorize user everytime they login.
* Fixed issue #10. VKontakte must authorize user everytime they login with empty oauth scope.
* Fixed translations.
* Fixed bug in the EOAuthService::initRequest(), incorrect variable use in http header.
* Fixed error with CURL HTTP chunked transfer encoding.

### Version 1.1.6 (01.02.2012)
* Added EAuthUserIdentity class.
* Added translations support.
* Fixed EAuthServiceBase::hasArrtubite() and EAuthServiceBase::getId() methods.

### Version 1.1.5 (03.01.2012)
* Added MoiKrug OAuth provider.
* Added Odnoklassniki OAuth provider.
* Added ability to write in the log of unsuccessful requests in the EAuthServiceBase::makeRequest().
* Added access_token lifetime handling, #1 closed. Please, check your custom OAuth 2.0 classes!
* Added links to provider files to register your applications.
* Changed url for the Yandex OpenID.
* Fixed infinite loop when calling getAttrbiutes from fetchAttributes inside a provider class.
* Removed $_GET['js'] from the redirect_uri for the OAuth 2.0 providers, which could cause problems with a callback URL for some providers.
* Small fixes in the css of the widget.

### Version 1.1.4 (13.11.2011)
* Added handling for denied callback in the TwitterOAuthService.
* Fixed a redirect page for disabled javascript.
* EAuthWidget been rewritten for use with CController->widget() instead of EAuth->renderWidget().
* Added automatic detection of the current action in the widget.
* Fixed popup window size for the new Google design.

### Version 1.1.3 (14.10.2011)
* MailruOAuthService::makeSignedRequest() now fully compatible with the basic method.
* Fixed error when MailruOAuthService::getAccessToken() returns an empty token.
* Fixed: service IDs in the configuration is no longer associated with the names of services.
* Fixed MailruOAuthService::getTokenUrl() method to be fully compatible with the basic method.
* Added Google OAuth 2.0 provider, updated css file of the widget.

### Version 1.1.2 (08.10.2011)
* Fixed fetchJsonError() method in OAuth providers.
* Fixed examples of custom classes for OAuth 2.0 providers.
* Updated EAuth::redirect() method to support the closing popup window without $_GET['js'] variable.

### Version 1.1 (07.10.2011)
* Fixed a wrong call urldecode instead of urldecode in the FacebookOAuthService.php.
* Fixed exception rethrowing: removed unnecessary $e->getPrevious() call.
* Fixed: the call $service->getItemAttributes() returns an empty array.
* Removed checking $_GET['error_reason'] in EOAuth2Service.php.
* EAuthServiceBase is an abstract class now.
* Updated curl requests api.
* Updated OAuth Service Providers.
* Method getItemAttributes() renamed to getAttributes().
* Added methods to work with a authorization session (Methods: getStateKeyPrefix, setState, hasState, getState).
* Added Mail.ru OAuth provider, updated css file of the widget.
* Added getters support for service attributes.

### Version 1.0 (02.10.2011)
* Initial release.