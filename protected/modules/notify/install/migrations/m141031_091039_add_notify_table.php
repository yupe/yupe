<?php

class m141031_091039_add_notify_table extends CDbMigration
{
    public function safeUp()
	{
        $this->createTable('{{notify_settings}}', [
                'id' => 'pk',
                'user_id' => 'integer NOT NULL',
                'my_post' => 'BOOLEAN NOT NULL DEFAULT 1',
                'my_comment' => 'BOOLEAN NOT NULL DEFAULT 1'
            ]);

        //ix
        $this->createIndex("ix_{{notify_settings}}_user_id", '{{notify_settings}}', "user_id", false);

        //fk
        $this->addForeignKey(
            "fk_{{notify_settings}}_user_id",
            '{{notify_settings}}',
            'user_id',
            '{{user_user}}',
            'id',
            'CASCADE',
            'NO ACTION'
        );

        $users = User::model()->findAll();

        foreach($users as $user) {
            $model = new NotifySettings();
            $model->user_id = $user->id;
            $model->save();
        }
	}

	public function safeDown()
	{
        $this->dropTable('{{notify_settings}}');
	}
}
