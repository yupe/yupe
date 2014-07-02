<?php
Yii::import('application.modules.user.models.User');
Yii::import('application.modules.rbac.models.*');

class m140702_230000_initial_role_data extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $adminRole              = new AuthItem();
        $adminRole->name        = 'admin';
        $adminRole->description = 'Администратор';
        $adminRole->type        = AuthItem::TYPE_ROLE;
        $adminRole->save();

        $admins = User::model()->findAllByAttributes(array('access_level' => User::ACCESS_LEVEL_ADMIN));
        foreach ($admins as $admin)
        {
            $assign           = new AuthAssignment();
            $assign->itemname = $adminRole->name;
            $assign->userid   = $admin->id;
            $assign->save();
        }
    }

    public function safeDown()
    {
        AuthItem::model()->deleteByPk('admin');
    }
}