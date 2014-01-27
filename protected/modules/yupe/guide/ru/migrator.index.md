Компонент "Мигратор"
====================

Для обновление базы данных в "Юпи" используются миграционные файлы, в которых описаны необходимые действия. Есть возможность "накатывания" и "отката" миграции, соответственно методы `safeUp` и `safeDown`. Миграционные файлы это почти теже самые миграции, что есть в [Yii](http://www.yiiframework.com/doc/guide/1.1/ru/database.migration), есть лишь небольшие правки, которые были внесены для корректной работы поверх поддерживаемых СУБД.

Отличия от Yii-миграций
-----------------------

Начнём пожалуй с того, что вместо `CDbMigration` в "Юпи" используется `yupe\components\DbMigration` который дополняет своим функционалом базовый класс, а именно:

* метод `getOptions` который возвращает опции создания таблицы для различных СУБД
* метод `normTable` для "нормализации" именни таблицы
* метод `dropTableWithForeignKeys` в котором планируется/реализовано удаление таблицы вместе с foreign-ключами

Как писать миграции для "Юпи"
---------------------------

Написание миграций для Юпи почти ничем не отличается от того, как это работает в [Yii](http://www.yiiframework.com/doc/guide/1.1/ru/database.migration), достаточно лишь использовать как базовый класс `yupe\components\DbMigration` и работать с методами, которые рекомендуются в нём, для совместимости со всеми поддерживаемыми СУБД. Имя файла и класса миграции формируется следующим образом - `m{yymmdd_time_name}`, например `130503_091124_BlogPostImage`. В примере используется миграция, котрорая создана 03-05-2013 в 09:11:24 с именем BlogPostImage.
Миграции необходимо располагать в каталоге `./protected/modules/<module>/install/migrations/`, это делается для того, чтобы миграции относились к определённым модулям.

Рассмотрим пример миграции для "Юпи"
------------------------------------

Ниже представлен листинг миграции для "Юпи" на примере модуля "Блог":

<pre><code class="php">
/**
 * Blog install migration
 * Класс миграций для модуля Blog:
 *
 * @category YupeMigration
 * @package  yupe
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_blog_base extends yupe\components\DbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        // blog
        $this->createTable(
            '{{blog_blog}}',
            array(
                'id' => "pk",
                'category_id' => "integer DEFAULT NULL",
                'name' => "varchar(250) NOT NULL",
                'description' => "text",
                'icon' => "varchar(250) NOT NULL DEFAULT ''",
                'slug' => "varchar(150) NOT NULL",
                'lang' => "char(2) DEFAULT NULL",
                'type' => "integer NOT NULL DEFAULT '1'",
                'status' => "integer NOT NULL DEFAULT '1'",
                'create_user_id' => "integer NOT NULL",
                'update_user_id' => "integer NOT NULL",
                'create_date' => "integer NOT NULL",
                'update_date' => "integer NOT NULL",
            ),
            $this->getOptions()
        );

        // ix
        $this->createIndex("ux_{{blog_blog}}_slug_lang", '{{blog_blog}}', "slug,lang", true);
        $this->createIndex("ix_{{blog_blog}}_create_user", '{{blog_blog}}', "create_user_id", false);
        $this->createIndex("ix_{{blog_blog}}_update_user", '{{blog_blog}}', "update_user_id", false);
        $this->createIndex("ix_{{blog_blog}}_status", '{{blog_blog}}', "status", false);
        $this->createIndex("ix_{{blog_blog}}_type", '{{blog_blog}}', "type", false);
        $this->createIndex("ix_{{blog_blog}}_create_date", '{{blog_blog}}', "create_date", false);
        $this->createIndex("ix_{{blog_blog}}_update_date", '{{blog_blog}}', "update_date", false);
        $this->createIndex("ix_{{blog_blog}}_lang", '{{blog_blog}}', "lang", false);
        $this->createIndex("ix_{{blog_blog}}_slug", '{{blog_blog}}', "slug", false);
        $this->createIndex("ix_{{blog_blog}}_category_id", '{{blog_blog}}', "category_id", false);

        // fk
        $this->addForeignKey("fk_{{blog_blog}}_create_user", '{{blog_blog}}', 'create_user_id', '{{user_user}}', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey("fk_{{blog_blog}}_update_user", '{{blog_blog}}', 'update_user_id', '{{user_user}}', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey("fk_{{blog_blog}}_category_id", '{{blog_blog}}', 'category_id', '{{category_category}}', 'id', 'SET NULL', 'NO ACTION');


        // post
        $this->createTable(
            '{{blog_post}}',
            array(
                'id' => "pk",
                'blog_id' => "integer NOT NULL",
                'create_user_id' => "integer NOT NULL",
                'update_user_id' => "integer NOT NULL",
                'create_date' => "integer NOT NULL",
                'update_date' => "integer NOT NULL",
                'publish_date' => "integer NOT NULL",
                'slug' => "varchar(150) NOT NULL",
                'lang' => "char(2) DEFAULT NULL",
                'title' => "varchar(250) NOT NULL",
                'quote' => "varchar(250) NOT NULL DEFAULT ''",
                'content' => "text NOT NULL",
                'link' => "varchar(250) NOT NULL DEFAULT ''",
                'status' => "integer NOT NULL DEFAULT '0'",
                'comment_status' => "integer NOT NULL DEFAULT '1'",
                'create_user_ip' => "varchar(20) NOT NULL",
                'access_type' => "integer NOT NULL DEFAULT '1'",
                'keywords' => "varchar(250) NOT NULL DEFAULT ''",
                'description' => "varchar(250) NOT NULL DEFAULT ''",
            ),
            $this->getOptions()
        );

        //ix
        $this->createIndex("ux_{{blog_post}}_lang_slug", '{{blog_post}}', "slug,lang", true);
        $this->createIndex("ix_{{blog_post}}_blog_id", '{{blog_post}}', "blog_id", false);
        $this->createIndex("ix_{{blog_post}}_create_user_id", '{{blog_post}}', "create_user_id", false);
        $this->createIndex("ix_{{blog_post}}_update_user_id", '{{blog_post}}', "update_user_id", false);
        $this->createIndex("ix_{{blog_post}}_status", '{{blog_post}}', "status", false);
        $this->createIndex("ix_{{blog_post}}_access_type", '{{blog_post}}', "access_type", false);
        $this->createIndex("ix_{{blog_post}}_comment_status", '{{blog_post}}', "comment_status", false);
        $this->createIndex("ix_{{blog_post}}_lang", '{{blog_post}}', "lang", false);
        $this->createIndex("ix_{{blog_post}}_slug", '{{blog_post}}', "slug", false);
        $this->createIndex("ix_{{blog_post}}_publish_date", '{{blog_post}}', "publish_date", false);

        //fks 
        $this->addForeignKey("fk_{{blog_post}}_blog", '{{blog_post}}', 'blog_id', '{{blog_blog}}', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey("fk_{{blog_post}}_create_user", '{{blog_post}}', 'create_user_id', '{{user_user}}', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey("fk_{{blog_post}}_update_user", '{{blog_post}}', 'update_user_id', '{{user_user}}', 'id', 'NO ACTION', 'NO ACTION');

        // user to blog
        $this->createTable(
            '{{blog_user_to_blog}}',
            array(
                'id' => "pk",
                'user_id' => "integer NOT NULL",
                'blog_id' => "integer NOT NULL",
                'create_date' => "integer NOT NULL",
                'update_date' => "integer NOT NULL",
                'role' => "integer NOT NULL DEFAULT '1'",
                'status' => "integer NOT NULL DEFAULT '1'",
                'note' => "varchar(250) NOT NULL DEFAULT ''",
            ),
            $this->getOptions()
        );

        //ix
        $this->createIndex(
            "ux_{{blog_user_to_blog}}_blog_user_to_blog_u_b",
            '{{blog_user_to_blog}}',
            "user_id,blog_id",
            true
        );
        $this->createIndex(
            "ix_{{blog_user_to_blog}}_blog_user_to_blog_user_id",
            '{{blog_user_to_blog}}',
            "user_id",
            false
        );
        $this->createIndex(
            "ix_{{blog_user_to_blog}}_blog_user_to_blog_id",
            '{{blog_user_to_blog}}',
            "blog_id",
            false
        );
        $this->createIndex(
            "ix_{{blog_user_to_blog}}_blog_user_to_blog_status",
            '{{blog_user_to_blog}}',
            "status",
            false
        );
        $this->createIndex("ix_{{blog_user_to_blog}}_blog_user_to_blog_role", '{{blog_user_to_blog}}', "role", false);

        //fk
        $this->addForeignKey("fk_{{blog_user_to_blog}}_blog_user_to_blog_user_id", '{{blog_user_to_blog}}', 'user_id', '{{user_user}}', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey("fk_{{blog_user_to_blog}}_blog_user_to_blog_blog_id", '{{blog_user_to_blog}}', 'blog_id', '{{blog_blog}}', 'id', 'CASCADE', 'NO ACTION');

        // tags
        $this->createTable(
            '{{blog_tag}}',
            array(
                'id' => 'pk',
                'name' => 'varchar(255) NOT NULL',
            ),
            $this->getOptions()
        );

        //ix
        $this->createIndex("ux_{{blog_tag}}_tag_name", '{{blog_tag}}', "name", true);

        // post to tag
        $this->createTable(
            '{{blog_post_to_tag}}',
            array(
                'post_id' => 'integer NOT NULL',
                'tag_id' => 'integer NOT NULL',
                'PRIMARY KEY (post_id, tag_id)'
            ),
            $this->getOptions()
        );

        //ix  
        $this->createIndex("ix_{{blog_post_to_tag}}_post_id", '{{blog_post_to_tag}}', "post_id", false);
        $this->createIndex("ix_{{blog_post_to_tag}}_tag_id", '{{blog_post_to_tag}}', "tag_id", false);

        //fk
        $this->addForeignKey("fk_{{blog_post_to_tag}}_post_id", '{{blog_post_to_tag}}', 'post_id', '{{blog_post}}', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey("fk_{{blog_post_to_tag}}_tag_id", '{{blog_post_to_tag}}', 'tag_id', '{{blog_tag}}', 'id', 'CASCADE', 'NO ACTION');
    }

    /**
     * Удаляем таблицы
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{blog_post_to_tag}}');
        $this->dropTableWithForeignKeys('{{blog_tag}}');
        $this->dropTableWithForeignKeys('{{blog_post}}');
        $this->dropTableWithForeignKeys('{{blog_user_to_blog}}');
        $this->dropTableWithForeignKeys('{{blog_blog}}');
    }
}
</code></pre>



**При возникновении проблем - [напишите нам](http://amylabs.ru/contact)!**
