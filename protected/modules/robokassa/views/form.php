<?php
/**
 * @var string $action
 * @var string $login
 * @var string $password
 * @var string $language
 * @var integer $id
 * @var string $description
 * @var float $price
 */

$description = Yii::t('RobokassaModule.robokassa', 'Payment order #{id} on "{site}" website', [
    '{id}' => $id,
    '{site}' => Yii::app()->getModule('yupe')->siteName
]);

echo CHtml::form($action)
    . CHtml::hiddenField('MrchLogin', $login)
    . CHtml::hiddenField('OutSum', $price)
    . CHtml::hiddenField('InvId', $id)
    . CHtml::hiddenField('Desc', $description)
    . CHtml::hiddenField('SignatureValue', md5("$login:$price:$id:$password"))
    . CHtml::hiddenField('Culture', $language)
    . CHtml::submitButton(Yii::t('RobokassaModule.robokassa','Pay'))
    . CHtml::endForm();
