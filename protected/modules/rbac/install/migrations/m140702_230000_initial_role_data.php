<?php
Yii::import('application.modules.user.models.User');
Yii::import('application.modules.rbac.models.*');

class m140702_230000_initial_role_data extends yupe\components\DbMigration
{
    public function safeUp()
    {
        /* Всем администраторам назначается роль admin */
        $adminRole = new AuthItem();
        $adminRole->name = AuthItem::ROLE_ADMIN;
        $adminRole->description = Yii::t('RbacModule.rbac', 'Admin');
        $adminRole->type = AuthItem::TYPE_ROLE;
        $adminRole->save();

        $admins = User::model()->findAllByAttributes(['access_level' => User::ACCESS_LEVEL_ADMIN]);
        foreach ($admins as $admin) {
            $assign = new AuthAssignment();
            $assign->itemname = $adminRole->name;
            $assign->userid = $admin->id;
            $assign->save();
        }
    }

    public function safeDown()
    {
        AuthItem::model()->deleteByPk(AuthItem::ROLE_ADMIN);
    }
}
