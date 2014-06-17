<?php

class PaymentManager extends CComponent
{
    private $_paymentSystems = null;
    private $_formattedList = null;

    public function getPaymentSystemConfig($id)
    {
        if (!$id)
        {
            return null;
        }
        if (isset($this->_paymentSystems[$id]))
        {
            return $this->_paymentSystems[$id];
        }
        $path                       = Yii::getPathOfAlias('application.modules.shop.components.payments.' . $id) . DIRECTORY_SEPARATOR . 'config.json';
        $config                     = json_decode(file_get_contents($path), true);
        $this->_paymentSystems[$id] = $config;
        return $this->_paymentSystems[$id];
    }

    public function getPaymentSystems()
    {
        if ($this->_paymentSystems)
        {
            return $this->_paymentSystems;
        }
        $path    = Yii::getPathOfAlias('application.modules.shop.components.payments');
        $systems = array();
        foreach ((array)glob($path . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR) as $system)
        {
            $config                                        = json_decode(file_get_contents($system . DIRECTORY_SEPARATOR . 'config.json'), true);
            $systems[pathinfo($system, PATHINFO_BASENAME)] = $config;
        }
        $this->_paymentSystems = $systems;
        return $this->_paymentSystems;
    }

    public function getSystemsFormattedList()
    {
        if ($this->_formattedList)
        {
            return $this->_formattedList;
        }
        $list = array();
        foreach ($this->getPaymentSystems() as $system => $config)
        {
            $list[$system] = $config['name'];
        }
        $this->_formattedList = $list;
        return $this->_formattedList;
    }

    /**
     * @param $id
     * @return IPaymentSystem|null
     * @throws CException
     */
    public function loadPaymentSystemObject($id)
    {
        if ($id)
        {
            $path      = Yii::getPathOfAlias('application.modules.shop.components.payments.' . $id);
            $classFile = array_shift(glob($path . DIRECTORY_SEPARATOR . '*PaymentSystem.php'));
            $className = pathinfo($classFile, PATHINFO_FILENAME);
            if ($className)
            {
                Yii::import('application.modules.shop.components.payments.' . $id . '.' . $className);
                return new $className;
            }
        }
        return null;
    }

    public function renderSettings($id, $paymentSettings = array(), $return = false)
    {
        $config   = $this->getPaymentSystemConfig($id);
        $settings = '';
        foreach ((array)$config['settings'] as $param)
        {
            $variable = $param['variable'];
            $settings .= CHtml::openTag('div', array('class' => 'control-group'));
            $settings .= CHtml::label($param['name'], 'Payment_settings_' . $variable, array('class' => 'control-label'));
            $settings .= CHtml::openTag('div', array('class' => 'controls'));
            if (isset($param['options']))
            {
                $settings .= CHtml::dropDownList('PaymentSettings[' . $variable . ']', $paymentSettings[$variable], CHtml::listData($param['options'], 'value', 'name'));
            }
            else
            {
                $settings .= CHtml::textField('PaymentSettings[' . $variable . ']', $paymentSettings[$variable]);
            }
            $settings .= CHtml::closeTag('div');
            $settings .= CHtml::closeTag('div');
        }
        if ($return)
        {
            return $settings;
        }
        else
        {
            echo $settings;
        }
    }
}