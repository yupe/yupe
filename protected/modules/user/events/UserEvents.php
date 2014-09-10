<?php

class UserEvents
{
    const SUCCESS_ACTIVATE_ACCOUNT = 'user.success.activate';

    const FAILURE_ACTIVATE_ACCOUNT = 'user.failure.activate';

    const SUCCESS_EMAIL_CHANGE = 'user.success.email.change';

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
