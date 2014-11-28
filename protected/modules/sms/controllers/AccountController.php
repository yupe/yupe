<?php

/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
class AccountController extends yupe\components\controllers\FrontController
{
    public function filters()
    {
        return [
            ['yupe\filters\YFrontAccessControl + profile']
        ];
    }

    public function actions()
    {
         return [
            'profilePhone'    => ['class' => 'application.modules.sms.controllers.account.ProfilePhoneAction'],
            'confirmPhone'    => ['class' => 'application.modules.sms.controllers.account.PhoneConfirmAction'],
        ];
    }
}
