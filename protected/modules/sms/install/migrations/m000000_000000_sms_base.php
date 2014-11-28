<?php
/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
class m000000_000000_sms_base extends yupe\components\DbMigration
{

    public function safeUp()
    {
        /**
         * sms_messages:
         **/
        $this->createTable(
            '{{sms_sms_messages}}', array(
                'id'          => 'pk',
                'to'          => 'varchar(25) NOT NULL',
                'text'       => 'text NOT NULL',
                'status'      => "integer NOT NULL DEFAULT '0'",
            ), $this->getOptions()
        );

        //ix
        $this->createIndex("ix_{{sms_sms_messages}}_to", '{{sms_sms_messages}}', "to", false);
        $this->createIndex("ix_{{sms_sms_messages}}_status", '{{sms_sms_messages}}', "status", false);

   }
 

    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{sms_sms_messages}}');
    }
}
