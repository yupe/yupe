<?php
use yupe\models\Settings;

class m000000_000000_shop_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        /********* cart **************/

        $this->createTable(
            '{{shop_cart}}',
            array(
                'id' => 'pk',
                'session_id' => 'string NOT NULL'
            ),
            $this->getOptions()
        );

        $this->createTable(
            '{{shop_cart_good}}',
            array(
                'id' => 'pk',
                'cart_id' => 'integer NOT NULL',
                'catalog_good_id' => 'integer NOT NULL'
            ),
            $this->getOptions()
        );

        $this->createIndex(
            "ix_{{shop_cart_good}}_cart",
            '{{shop_cart_good}}',
            'cart_id'
        );

        $this->createIndex(
            "ix_{{shop_cart}}_session",
            '{{shop_cart}}',
            'session_id'
        );

        $this->addForeignKey(
            "fk_{{shop_cart_good}}_cart",
            '{{shop_cart_good}}',
            'cart_id',
            '{{shop_cart}}',
            'id',
            'cascade',
            'NO ACTION'
        );

        $this->createIndex(
            "ix_{{shop_cart_good}}_good",
            '{{shop_cart_good}}',
            'catalog_good_id'
        );

        $this->addForeignKey(
            "fk_{{shop_cart_good}}_good",
            '{{shop_cart_good}}',
            'catalog_good_id',
            '{{catalog_good}}',
            'id',
            'RESTRICT',
            'NO ACTION'
        );

        /********** orders *********/
        $this->createTable(
            '{{shop_order}}',
            array(
                'id' => 'pk',
                'price' => 'decimal(19,3) NOT NULL',
                'address' => 'text NOT NULL',
                'recipient' => 'string NOT NULL',
                'phone' => 'string NOT NULL',
                'create_time' => 'timestamp NOT NULL'
            ),
            $this->getOptions()
        );

        $this->createTable(
            '{{shop_order_good}}',
            array(
                'id' => 'pk',
                'order_id' => 'integer NOT NULL',
                'price' => 'decimal(19,3) NOT NULL',
                'catalog_good_id' => 'integer NOT NULL'
            ),
            $this->getOptions()
        );

        $this->createIndex(
            "ix_{{shop_order_good}}_good",
            '{{shop_order_good}}',
            'catalog_good_id'
        );
        $this->createIndex(
            "ix_{{shop_order_good}}_order",
            '{{shop_order_good}}',
            'order_id'
        );

        $this->addForeignKey(
            "fk_{{shop_order_good}}_good",
            '{{shop_order_good}}',
            'catalog_good_id',
            '{{catalog_good}}',
            'id',
            'RESTRICT',
            'NO ACTION'
        );

        // почтовое событие нового заказа
        $this->insert(
            "{{mail_mail_event}}",
            array(
                'code' => 'new-order',
                'name' => 'Новый заказ',
                'description' => 'Событие после создания нового заказа'
            )
        );
        // здесь не должно быть других insert`ов
        $lastId = $this->dbConnection->lastInsertID;
        // шаблон письма о новом заказе
        //Yii::import('yupe.models.Settings');
        $this->insert(
            "{{mail_mail_template}}",
            array(
                'code' => 'pismo-administratoru-o-novom-zakaze',
                'event_id' => $lastId,//$this->dbConnection->lastInsertID,
                'name' => 'Письмо администратору о новом заказе',
                'from' => 'web@' . $_SERVER["HTTP_HOST"],
                'to' => Settings::model()->findByAttributes(array('module_id' => 'yupe', 'param_name' => 'email'))->param_value,
                'theme' => 'Новый заказ на сайте',
                'body' => '<p>На сайте новый заказ №orderId</p>',
                'status' => 1
            )
        );

    }

    public function safeDown()
    {
        // шаблон письма о новом заказе
        /*$this->delete(
            "{{mail_mail_template}}",
            'code = :code',
            array(
                ':code' => 'pismo-administratoru-o-novom-zakaze'
            )
        );*/
        // почтовое событие нового заказа
        $this->delete(
            "{{mail_mail_event}}",
            'code = :code',
            array(
                ':code' => 'new-order'
            )
        );

        $this->dropTableWithForeignKeys('{{shop_cart_good}}');
        $this->dropTableWithForeignKeys('{{shop_cart}}');
        $this->dropTableWithForeignKeys('{{shop_order_good}}');
        $this->dropTableWithForeignKeys('{{shop_order}}');
    }
}