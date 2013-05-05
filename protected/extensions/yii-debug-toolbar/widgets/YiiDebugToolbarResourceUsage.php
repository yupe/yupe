<?php
/**
 * YiiDebugToolbarResourceUsage class file.
 *
 * @author Sergey Malyshev <malyshev@zfort.net>
 */

/**
 * YiiDebugToolbarResourceUsage represents an ...
 *
 * Description of YiiDebugToolbarResourceUsage
 *
 * @author Sergey Malyshev <malyshev@zfort.net>
 * @package
 * @since 1.1.7
 */
class YiiDebugToolbarResourceUsage extends CWidget
{
    public $title = 'Resource Usage';

    public $htmlOptions = array();

    private $_loadTime;

    public function getLoadTime()
    {
        if (null === $this->_loadTime)
        {
            $this->_loadTime = $this->owner->owner->getLoadTime();
        }
        return $this->_loadTime;
    }

    public function getRequestLoadTime()
    {
        return ($this->owner->owner->getEndTime() - $_SERVER['REQUEST_TIME']);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $resources =  array(
            YiiDebug::t('Page Load Time')    =>  sprintf('%0.6F s.',$this->getLoadTime()),
            YiiDebug::t('Elapsed Time')      =>  sprintf('%0.6F s.',$this->getRequestLoadTime()),
            YiiDebug::t('Memory Usage')      =>  number_format(Yii::getLogger()->getMemoryUsage()/1024) . ' KB',
            YiiDebug::t('Memory Peak Usage') => function_exists('memory_get_peak_usage') ? number_format(memory_get_peak_usage()/1024) . ' KB' : 'N/A',
        );

        if (function_exists('mb_strlen') && isset($_SESSION))
        {
            $resources[YiiDebug::t('Session Size')] = sprintf('%0.3F KB' ,mb_strlen(serialize($_SESSION))/1024);
        }


        echo CHtml::openTag('div', $this->htmlOptions);

        echo CHtml::tag('h1', array(), $this->title);

        echo CHtml::openTag('ul', array('class'=>'data'));
        foreach ($resources as $key=>$value)
        {
            echo CHtml::openTag('li');
            echo CHtml::tag('label', array(), $key);
            echo CHtml::tag('span', array(), $value);
            echo CHtml::closeTag('li');
        }
        echo CHtml::closeTag('ul');
        echo CHtml::closeTag('div');
    }
}