<?php

class m150414_124659_add_order_coupon_table extends CDbMigration
{
	public function safeUp()
	{
        $this->createTable('{{store_order_coupon}}', [
                "id" => "pk",
                'order_id'    => 'integer not null',
                'coupon_id'   => 'integer not null',
                'create_time' => 'datetime not null'
            ]);

        //fk
        $this->addForeignKey('fk_{{store_order_coupon}}_order', '{{store_order_coupon}}', 'order_id', '{{store_order}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_{{store_order_coupon}}_coupon', '{{store_order_coupon}}', 'coupon_id', '{{store_coupon}}', 'id', 'CASCADE');

        //перенести имеющиеся купоны
        $orders = Yii::app()->getDb()->createCommand('SELECT * FROM {{store_order}} WHERE coupon_code IS NOT NULL')
            ->queryAll();

        foreach($orders as $order) {

            $coupons = explode(',', $order['coupon_code']);

            foreach($coupons as $code) {
                $coupon = Yii::app()->getDb()->createCommand('SELECT * FROM {{store_coupon}} WHERE code = :code')
                    ->bindValue(':code', $code)->queryRow();

                if(!empty($coupon)) {
                    Yii::app()->getDb()->createCommand()->insert('{{store_order_coupon}}', [
                            'order_id'  => $order['id'],
                            'coupon_id' => $coupon['id'],
                            'create_time'=> new CDbExpression('NOW()')
                        ]);
                }
            }
        }

        //удалить старую колонку
        $this->dropColumn('{{store_order}}', 'coupon_code');
	}

	public function safeDown()
	{
        $this->dropTable('{{store_order_coupon}}');
        $this->addColumn('{{store_order}}', 'coupon_code', 'varchar(255)');
	}
}
