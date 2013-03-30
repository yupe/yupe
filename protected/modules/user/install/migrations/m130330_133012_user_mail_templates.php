<?php
/**
 * File Doc Comment
 * User mail templates migration
 * Класс миграций для модуля User:
 * Добавляет шаблоны стандартных писем
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m130330_133012_user_mail_templates extends YDbMigration
{

    public function safeUp()
    {
        $items = array(
            array('id', 'code',                           'name', 'description'),
            array(1,    'USER_PASSWORD_RECOVERY',         Yii::t('userModule.mail_templates', 'Почтовое событие при восстановлении пароля'), ''),
            array(2,    'USER_REGISTRATION_ACTIVATE',     Yii::t('userModule.mail_templates', 'Почтовое событие при регистрации нового пользователя с активацией'), ''),
            array(3,    'USER_REGISTRATION',              Yii::t('userModule.mail_templates', 'Почтовое событие при регистрации нового пользователя без активации'), ''),
            array(4,    'USER_PASSWORD_AUTO_RECOVERY',    Yii::t('userModule.mail_templates', 'Почтовое событие при автоматическом восстановлении пароля'), ''),
            array(5,    'USER_PASSWORD_SUCCESS_RECOVERY', Yii::t('userModule.mail_templates', 'Почтовое событие при успешном восстановлении пароля'), ''),
            array(6,    'USER_ACCOUNT_ACTIVATION',        Yii::t('userModule.mail_templates', 'Почтовое событие при успешной активации пользователя'), '')
        ) ;
        $this->insertItems($items,'{{mail_mail_event}}');

        $items = array(
            array('id', 'code', 'event_id', 'name', 'description', 'from', 'to', 'theme', 'body', 'status'),
            array(1, 'passwordRecoveryMail',            1, 'Шаблон письма, отправляемого при запросе восстановления пароля', NULL, '{from_mail}', '{to_mail}', 'Восстановление пароля на сайте {site}.', '<html>\r\n<head>\r\n    <title>Восстановление пароля для сайта {site} !</title>\r\n</head>\r\n<body>\r\n<h1>Восстановление пароля для сайта "{site}".</h1>\r\n<br/>\r\n\r\nКто-то, возможно Вы, запросил сброс пароля для сайта "{site}".\r\n<br/>\r\nЕсли это были не Вы - просто удалите это письмо.\r\n<br/>\r\n\r\nДля восстановления пароля, пожалуйста, перейдите по {link}\r\n<br/>\r\n{url}\r\n<br/><br/>\r\n\r\nС уважением, администрация сайта {site}.\r\n</body>\r\n</html>', 1),
            array(2, 'passwordSuccessRecovery',         5, 'Шаблон письма с новым паролем после восстановления пароля.', NULL, '{from_mail}', '{to_mail}', 'Ваш новый пароль на сайте {site}.', '<h1>Восстановление пароля для сайта "{site}".</h1>\r\n<br>\r\n\r\nВаш новый пароль : <b>{password}</b><br>\r\nПомните – его всегда можно сменить в вашем профиле на сайте.\r\n<br>\r\nИспользуя данный пароль, вы можете теперь воти используя <a href="{login_url}">страницу входа</a>\r\n<br>\r\n{login_url}\r\n<br><br>\r\n\r\nС уважением, администрация сайта {site}.\r\n', 1),
            array(3, 'registrationMailEventActivate',   2, 'Шаблон письма с просьбой активации аккаунта.', NULL, '{from_mail}', '{to_mail}', 'Подтверждение регистрации на сайте {site}. Требуется активация.', 'Здравствуйте!\r\n<br><br>\r\nВы успешно зарегистрировались на сайте "{site}" !\r\n    <br/><br/>\r\nДля активации аккаунта, пожалуйста, перейдите по <a href="{url}">ссылке</a>\r\n<br/><br/>\r\n{url}\r\n<br/><br/>\r\nС уважением, администрация сайта {site}.\r\n', 1),
            array(4, 'registrationMailEvent',           3, 'Шаблон письма, отправляемого при успешной регистрации без требования активации аккаунта.', NULL, '{from_mail}', '{to_mail}', 'Успешная регистрация на сайте {site}.', '<h1>Ваш аккаунт на сайте "{site}" успешно создан!</h1>\r\n\r\n    <br/><br/>\r\n\r\nТеперь вы можете войти используя <a href="{login_url}">страницу входа</a>\r\n<br>\r\n{login_url}\r\n<br><br>\r\n\r\nС уважением, администрация сайта {site}.\r\n', 1),
            array(5, 'userAccountActivationMailEvent',  6, 'Шаблон письма с подтверждением успешной активации аккаунта.', NULL, '{from_mail}', '{to_mail}', 'Подтверждение активации аккаунта на сайте {site}.', '<h1>Ваш аккаунт на сайте "{site}" успешно активирован!</h1>\r\n\r\n    <br/><br/>\r\n\r\nТеперь вы можете войти используя <a href="{login_url}">страницу входа</a>\r\n<br>\r\n{login_url}\r\n<br><br>\r\n\r\nС уважением, администрация сайта {site}.\r\n', 1)
        ) ;
        $this->insertItems($items,'{{mail_mail_template}}');
    }

    public function safeDown()
    {
        $this->delete('{{mail_mail_event}}',array('id'=>array(1,2,3,4,5,6)));
        $this->delete('{{mail_mail_template}}',array('id'=>array(1,2,3,4,5)));
    }
}