<?php

/**
 * Class PaymentSystem
 */
class PaymentSystem extends CApplicationComponent
{
    /**
     *
     */
    const LOG_CATEGORY = 'store.payment';

    /**
     * @var string
     */
    public $parametersFile = 'parameters.json';

    /**
     * @param Payment $payment
     * @param Order $order
     * @param bool|false $return
     * @throws CException
     */
    public function renderCheckoutForm(Payment $payment, Order $order, $return = false)
    {
        throw new CException("Must be implemented");
    }

    /**
     * @param Payment $payment
     * @param CHttpRequest $request
     * @throws CException
     */
    public function processCheckout(Payment $payment, CHttpRequest $request)
    {
        throw new CException("Must be implemented");
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        $class_info = new ReflectionClass($this);
        $params = json_decode(
            file_get_contents(dirname($class_info->getFileName()).DIRECTORY_SEPARATOR.$this->parametersFile),
            true
        );

        return $params;
    }

    /**
     * @param array $paymentSettings
     * @param bool|false $return
     * @return string
     */
    public function renderSettings($paymentSettings = [], $return = false)
    {
        $params = $this->getParameters();
        $settings = '';
        foreach ((array)$params['settings'] as $param) {
            $variable = $param['variable'];
            $settings .= CHtml::openTag('div', ['class' => 'form-group']);
            $settings .= CHtml::label($param['name'], 'Payment_settings_'.$variable, ['class' => 'control-label']);
            $value = isset($paymentSettings[$variable]) ? $paymentSettings[$variable] : null;
            if (isset($param['options'])) {
                $settings .= CHtml::dropDownList(
                    'PaymentSettings['.$variable.']',
                    $value,
                    CHtml::listData($param['options'], 'value', 'name'),
                    ['class' => 'form-control']
                );
            } else {
                $settings .= CHtml::textField('PaymentSettings['.$variable.']', $value, ['class' => 'form-control']);
            }
            $settings .= CHtml::closeTag('div');
        }
        if ($return) {
            return $settings;
        } else {
            echo $settings;
        }
    }
}
