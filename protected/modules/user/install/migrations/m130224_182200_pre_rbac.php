<?php
/**
 * FileDocComment
 * User install migration
 * Класс миграций для модуля User: Добавляет простую поддержку RBAC
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * User install migration
 * Класс миграций для модуля User: Добавляет простую поддержку RBAC
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m130224_182200_pre_rbac extends YDbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{user_user_auth_item}}', array(
                'name'           => "char(64) NOT NULL",
                'type'           => "integer NOT NULL",
                'module'         => "varchar(100) NOT NULL DEFAULT 'yupe'",
                'description'    => "text NOT NULL DEFAULT ''",
                'bizrule'        => "text NOT NULL DEFAULT ''",
                'data'           => "text NOT NULL DEFAULT ''",
                'detailed_description' => "text NOT NULL DEFAULT ''",
            ),  $this->getOptions()
        );

        $this->addPrimaryKey("pk_{{user_user_auth_item}}_name", '{{user_user_auth_item}}', 'name');
        $this->createIndex("ix_{{user_user_auth_item}}_type", '{{user_user_auth_item}}', "type", false);
        $this->createIndex("ix_{{user_user_auth_item}}_module", '{{user_user_auth_item}}', "module", false);

        $this->insert(
            '{{user_user_auth_item}}', array(
                'name'                  => 'guest',
                'description'           => Yii::t('UserModule.user', 'Гости'),
                'detailed_description'  => Yii::t('UserModule.user', 'Посетители сайта, которые НЕ проходили авторизацию.'),
                'bizrule'               => 'return Yii::app()->user->isGuest;',
                'type'                  => UserAuthItem::USER_RBAC_ROLE,
                'module'                => 'user',
            )
        );

        $this->insert(
            '{{user_user_auth_item}}', array(
                'name'                  => 'authenticated',
                'description'           => Yii::t('UserModule.user', 'Авторизованные'),
                'detailed_description'  => Yii::t('UserModule.user', 'Пользователи, которые прошли авторизацию.'),
                'bizrule'               => 'return !Yii::app()->user->isGuest;',
                'type'                  => UserAuthItem::USER_RBAC_ROLE,
                'module'                => 'user',
            )
        );

        $this->insert(
            '{{user_user_auth_item}}', array(
                'name'       => 'admin',
                'description'        => Yii::t('UserModule.user', 'Администраторы'),
                'detailed_description' => Yii::t('UserModule.user', 'Администраторы сайта, имеют полный доступ к сайту.'),
                'type'                  => UserAuthItem::USER_RBAC_ROLE,
                'module'                => 'user',
            )
        );

        $this->insert(
            '{{user_user_auth_item}}', array(
                'name'       => 'editors',
                'description'        => Yii::t('UserModule.user', 'Редакторы'),
                'detailed_description' => Yii::t('UserModule.user', 'Редакторы содержимого сайта, имеют доступ только к редактированию контента.'),
                'type'                  => UserAuthItem::USER_RBAC_ROLE,
                'module'                => 'user',
            )
        );


        $this->createTable(
            '{{user_user_auth_item_child}}', array(
                'parent'           => "char(64) NOT NULL",
                'child'            => "char(64) NOT NULL",
            ), $this->getOptions()
        );

        $this->addPrimaryKey("pk_{{user_user_auth_item_child}}_parent_child",   '{{user_user_auth_item_child}}', 'parent,child');
        $this->addForeignKey("fk_{{user_user_auth_item_child}}_child", '{{user_user_auth_item_child}}', 'child', '{{user_user_auth_item}}', 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey("fk_{{user_user_auth_itemchild}}_parent", '{{user_user_auth_item_child}}', 'parent','{{user_user_auth_item}}', 'name', 'CASCADE', 'CASCADE');


        $this->createTable(
            '{{user_user_auth_assignment}}', array(
                'itemname'       => "char(64) NOT NULL",
                'userid'         => "integer NOT NULL",
                'bizrule'        => "text NOT NULL DEFAULT ''",
                'data'           => "text NOT NULL DEFAULT ''",
            ), $this->getOptions()
        );

        $this->addPrimaryKey("pk_{{user_user_auth_assignment}}_itemname_userid", '{{user_user_auth_assignment}}', 'itemname,userid');
        $this->addForeignKey("fk_{{user_user_auth_assignment}}_user", '{{user_user_auth_assignment}}', 'userid', '{{user_user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey("fk_{{user_user_auth_assignment}}_item", '{{user_user_auth_assignment}}', 'itemname', '{{user_user_auth_item}}', 'name', 'CASCADE', 'CASCADE');

        $this->getDbConnection()->createCommand("
            INSERT INTO {{user_user_auth_assignment}} ( itemname,userid )
            SELECT 'admin',id FROM {{user_user}} WHERE access_level=1
        ")->execute();

        $this->dropColumn( '{{user_user}}','access_level' );

    }

    /**
     * Функция удаления таблицы:
     *
     * @return nothing
     **/
    // @TODO: ОБЯЗАТЕЛЬНО ПРОВЕРИТЬ!!!!!!!!!
    public function safeDown()
    {
        $this->addColumn('{{user_user}}', 'access_level','integer NOT NULL DEFAULT "0" ');

        $this->getDbConnection()->createCommand("
            UPDATE {{user_user}} SET access_level=1 WHERE id IN (
                SELECT userid  FROM {{user_user_auth_assignment}}
                WHERE itemname='admin'
            )"
        )->execute();

        $this->dropTableWithForeignKeys('{{user_user_auth_assignment}}');
        $this->dropTableWithForeignKeys('{{user_user_auth_item_child}}');
        $this->dropTableWithForeignKeys('{{user_user_auth_item}}');
    }
}