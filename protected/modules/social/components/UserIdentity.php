<?php
namespace application\modules\social\components;

use CBaseUserIdentity;
use IAuthService;
use application\modules\social\models\SocialUser;
use User;
use Yii;
use CDbExpression;
use YWebUser;

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
            ->find(
                'provider = :provider AND uid = :uid',
                [
                    ':provider' => $this->service->getServiceName(),
                    ':uid'      => $this->service->getId(),
                ]
            );

        if (null === $storage || !$storage->user->isActive()) {
            return false;
        }

        $this->id = $storage->user->id;
        $this->name = $storage->user->nick_name;

        Yii::app()->getUser()->setState(YWebUser::STATE_ACCESS_LEVEL, $storage->user->access_level);
        Yii::app()->getUser()->setState(YWebUser::STATE_NICK_NAME, $storage->user->nick_name);

        $storage->user->visit_time = new CDbExpression('NOW()');
        $storage->user->update(['visit_time']);
        $this->errorCode = self::ERROR_NONE;

        return true;
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
