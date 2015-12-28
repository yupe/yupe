<?php

/**
 * Class PaymentManager
 */
class PaymentManager extends CApplicationComponent
{
    /**
     * @var null
     */
    private $_paymentSystems = null;
    /**
     * @var null
     */
    private $_formattedList = null;

    /**
     * @var array
     */
    public $paymentSystems = [];

    /**
     * Возвращает список зарегистрированных платежных систем в формате array(id_payment_system => payment_system_object, ...)
     *
     * @return array
     * @throws CException
     */
    public function getPaymentSystems()
    {
        if ($this->_paymentSystems) {
            return $this->_paymentSystems;
        }

        $systems = [];
        foreach ($this->paymentSystems as $id => $params) {
            $system = Yii::createComponent($params);
            $systems[$id] = $system;
        }
        $this->_paymentSystems = $systems;

        return $this->_paymentSystems;
    }

    /**
     * Список платежных систем в виде array(id => 'Название', ...)
     * @return array
     */
    public function getSystemsFormattedList()
    {
        if ($this->_formattedList) {
            return $this->_formattedList;
        }
        $list = [];
        foreach ($this->getPaymentSystems() as $id => $system) {
            $params = $system->getParameters();
            $list[$id] = $params['name'];
        }
        $this->_formattedList = $list;

        return $this->_formattedList;
    }

    /**
     * @param $id
     * @return PaymentSystem|null
     * @throws CException
     */
    public function getPaymentSystemObject($id)
    {
        $systems = $this->getPaymentSystems();
        if (isset($systems[$id])) {
            return $systems[$id];
        }

        return null;
    }
}
