<?php

interface IPaymentSystem
{
    public function renderCheckoutForm(Payment $payment, Order $order, $return = false);
    public function processCheckout(Payment $payment);
}