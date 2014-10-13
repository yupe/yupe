<?php
/**
 * Created by PhpStorm.
 * User: coder1
 * Date: 01.06.14
 * Time: 19:26
 *
 * @var $cart ShopCart
 * @var ShopOrder $order
 */

?>
<h1>Новый заказ</h1>


<p>В Вашей корзине <?= count($cart->shopCartGoods); ?> ед. товаров на
    сумму <?= Yii::app()->numberFormatter->formatCurrency($cart->sum, 'RUR') ?></p>

<ol>
    <?php
    foreach ($cart->shopCartGoods as $cartGood) {
        /**
         * @var ShopCartGood $cartGood
         */
        echo '<li>' . $cartGood->catalogGood->name . ', ' . Yii::app()->numberFormatter->formatCurrency($cartGood->catalogGood->price, 'RUR') . '</li>';
    }
    ?>
</ol>

<?php
/**
 * @var TbActiveForm $form
 */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'good-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'type' => 'vertical',
    'htmlOptions' => array('class' => 'well', 'enctype' => 'multipart/form-data'),
    'inlineErrors' => true,
)); ?>

<div class="row-fluid control-group <?php echo $order->hasErrors('phone') ? 'error' : ''; ?>">
    <?php echo $form->textFieldRow($order, 'phone', array('class' => 'span7 popover-help', 'size' => 20, 'maxlength' => 20, 'data-original-title' => $order->getAttributeLabel('phone'), 'data-content' => $order->getAttributeDescription('phone'))); ?>
</div>
<div class="row-fluid control-group <?php echo $order->hasErrors('recipient') ? 'error' : ''; ?>">
    <?php echo $form->textFieldRow($order, 'recipient', array('class' => 'span7 popover-help', 'size' => 20, 'maxlength' => 20, 'data-original-title' => $order->getAttributeLabel('recipient'), 'data-content' => $order->getAttributeDescription('recipient'))); ?>
</div>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type'       => 'primary',
    'label'      => 'Оформить заказ',
)); ?>

<?php $this->endWidget(); ?>
