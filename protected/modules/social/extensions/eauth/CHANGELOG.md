Yii EAuth Change Log
====================

### In progress...
* Added handling for denied callback in the TwitterOAuthService.
* Fixed a redirect page for disabled javascript.
* EAuthWidget been rewritten for use with CController->widget() instead of EAuth->renderWidget().
* Added automatic detection of the current action in the widget.

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