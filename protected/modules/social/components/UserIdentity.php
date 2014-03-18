<?php
namespace application\modules\social\components;

use \CBaseUserIdentity;
use \IAuthService;
use \SocialUser;
use \User;
use \Yii;
use \CDbExpression;

class UserIdentity extends CBaseUserIdentity
{
    /**
     * @var IAuthService implementation.
     */
    protected $service;
    protected $id;
    protected $name;

    public function __construct(IAuthService $service)
    {
        $this->service = $service;
    }

    public function authenticate()
    {
        $storage = SocialUser::model()
            ->with('user')
            ->find('provider = :provider AND uid = :uid', array(
                ':provider' => $this->service->getServiceName(),
                ':uid' => $this->service->getId(),
            ));

        if ($storage !== null && (int)$storage->user->status !== User::STATUS_BLOCK) {
            $user = $storage->user;
            $this->id = $user->id;
            $this->name = $user->nick_name;

            $this->setPersistentStates(array(
                'loginTime' => time(),
                'isAdmin' => $user->access_level === User::ACCESS_LEVEL_ADMIN,
                'nick_name' => $user->nick_name,
                'access_level' => $user->accessLevel,
                'id' => $user->id,
            ));

            $user->last_visit = new CDbExpression('NOW()');
            $user->update(array('last_visit'));
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode === self::ERROR_NONE;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
}
