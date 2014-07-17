Работа с событиями в Юпи!
=========================

Начиная с версии 0.7 в состав Юпи! входит компонент, предназначенный для работы с событиями - EventManager.
Реализация EventManager в Юпи! основана на компоненте EventDispatcher от Symfony.
Подробнее про этот компонент можно узнать из [официальной документации](http://symfony.com/doc/current/components/event_dispatcher/introduction.html).

Если модуль и его компоненты содержит события, достуные для "подписки" другими компонентами, такой модуль должен содержать PHP-класс, описывающий все события.
Рассмотрим это на примере модуля "Пользователи" ([user](https://github.com/yupe/yupe/tree/dev/protected/modules/user)).
Внутри модуля имеется каталог events, а в нем класс UserEvents, вот с таким содержанием:

<pre><code class="php">
class UserEvents
{
    const SUCCESS_ACTIVATE_ACCOUNT = 'user.success.activate';

    const FAILURE_ACTIVATE_ACCOUNT = 'user.failure.activate';

    const SUCCESS_EMAIL_CONFIRM = 'user.success.email.confirm';

    const FAILURE_EMAIL_CONFIRM = 'user.failure.email.confirm';

    const SUCCESS_LOGIN = 'user.success.login';

    const FAILURE_LOGIN = 'user.failure.login';

    const BEFORE_LOGIN = 'user.before.login';

    const BEFORE_LOGOUT = 'user.before.logout';

    const AFTER_LOGOUT = 'user.after.logout';

    const BEFORE_PASSWORD_RECOVERY = 'user.before.password.recovery';

    const SUCCESS_PASSWORD_RECOVERY = 'user.success.password.recovery';

    const FAILURE_PASSWORD_RECOVERY = 'user.failure.password.recovery';

    const SUCCESS_ACTIVATE_PASSWORD = 'user.success.activate.password';

    const FAILURE_ACTIVATE_PASSWORD = 'user.failure.activate.password';

    const SUCCESS_REGISTRATION = 'user.success.registration';

    const FAILURE_REGISTRATION = 'user.failure.registration';
}
</code></pre>

Каждая константа описывает одно событие. Название события ОБЯЗАТЕЛЬНО содержит в себе название модуля, к компоненту которого это событие относится.
Остальные слова и фразы внутри названия события разделяются символом "."

**Создание класса события**

**Вызов события**

Для вызова события из кода компонента необходимо обратиться в компоненту EventManager и вызвать его метод "fire".
<pre><code class="php">
Yii::app()->eventManager->fire(UserEvents::SUCCESS_REGISTRATION, new UserRegistrationEvent());
</code></pre>

**Назначение обработчиков**
<pre><code class="php">
<?php

return array(
    'module' => array(
        'class' => 'application.modules.rbac.RbacModule'
    ),
    'import' => array(
        'application.modules.rbac.listeners.AccessControlListener'
    ),
    'component' => array(
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
            'assignmentTable' => '{{user_user_auth_assignment}}',
            'itemChildTable' => '{{user_user_auth_item_child}}',
            'itemTable' => '{{user_user_auth_item}}',
        ),
        // override core ModuleManager
        'moduleManager' => array(
            'class' => 'application.modules.rbac.components.ModuleManager'
        ),
        //attach event handlers
        'eventManager' => array(
            'class' => 'yupe\components\EventManager',
            'events'=> array(
                // before backend controllers
                'yupe.before.backend.controller.action' => array(
                    array('AccessControlListener', 'onBeforeBackendControllerAction')
                )
            )
        )
    ),
    'rules' => array(
        '/backend/rbac/<controller:\w+>/<action:\w+>/<id:[\w._-]+>' => 'rbac/<controller>Backend/<action>',
    ),
);
</code></pre>