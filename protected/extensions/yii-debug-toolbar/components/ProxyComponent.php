<?php
/**
 * ProxyComponent class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */

/**
 * ProxyComponent represents an ...
 *
 * Description of ProxyComponent
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @version $Id$
 * @package
 * @since 1.1.7
 */
class ProxyComponent extends CComponent
{

    private $_instance;

    private $_isProxy;

    public function init()
    {
    }

    public function getIsProxy()
    {
        if (null === $this->_isProxy)
        {
            $this->_isProxy = (null !== $this->_instance && !is_a($this->_instance, get_class($this)));
        }
        return $this->_isProxy;
    }

    public function setInstance($value)
    {
        if (null === $this->_instance)
        {
            $this->_instance = $value;
        }
    }

    public function getInstance()
    {
        return $this->_instance;
    }

    public function  __call($name, $parameters)
    {
        if (false !== $this->getIsProxy() && false !== method_exists($this->_instance, $name))
        {
            return call_user_func_array(array($this->_instance, $name), $parameters);
        }

        return parent::__call($name, $parameters);
    }

    public function  __set($name, $value)
    {
        $setter='set'.$name;
        if (false !== method_exists($this, $setter))
        {
            return call_user_func_array(array($this, $setter), array($value));
        }
        else if (false !== property_exists($this, $name))
        {
            return $this->$name = $value;
        }
        else if (false !== $this->getIsProxy() && false !== method_exists($this->_instance, $setter))
        {
            return call_user_func_array(array($this->_instance, $setter), array($value));
        }
        else if (false !== $this->getIsProxy() && false !== property_exists($this->_instance, $name))
        {
            return $this->_instance->$name = $value;
        }

        return parent::__set($name, $value);
    }

    public function  __get($name)
    {
        $getter='get'.$name;

        if (false !== method_exists($this, $getter))
        {
            return call_user_func(array($this, $getter));
        }
        else if (false !== property_exists($this, $name))
        {
            return $this->$name;
        }
        else if (false !== $this->getIsProxy() && false !== method_exists($this->_instance, $getter))
        {
            return call_user_func(array($this->_instance, $getter));
        }
        else if (false !== $this->getIsProxy() && false !== property_exists($this->_instance, $name))
        {
            return $this->_instance->$name;
        }

        return parent::__get($name);
    }
}