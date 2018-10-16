<?php
/**
 * @var integer $id
 * @var string $description
 * @var float $price
 * @var array $settings
 */

$login = $settings['login'];
$password = $settings['password1'];

$description = Yii::t('RobokassaModule.robokassa', 'Payment order #{id} on "{site}" website', [
    '{id}' => $id,
    '{site}' => Yii::app()->getModule('yupe')->siteName
]);
?>

<?= CHtml::form($settings['testmode'] ? "http://test.robokassa.ru/Index.aspx" : "https://merchant.roboxchange.com/Index.aspx") ?>
<?= CHtml::hiddenField('MrchLogin', $login) ?>
<?= CHtml::hiddenField('OutSum', $price) ?>
<?= CHtml::hiddenField('InvId', $id) ?>
<?= CHtml::hiddenField('Desc', $description) ?>
<?= CHtml::hiddenField('SignatureValue', md5("$login:$price:$id:$password")) ?>
<?= CHtml::hiddenField('Culture', $settings['language']) ?>
<?= CHtml::submitButton(Yii::t('RobokassaModule.robokassa','Pay')) ?>
<?= CHtml::endForm() ?>
