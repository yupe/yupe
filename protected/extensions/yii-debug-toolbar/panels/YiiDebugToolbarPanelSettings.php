<?php
/**
 * YiiDebugToolbarPanelSettings class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */


/**
 * YiiDebugToolbarPanelSettings class
 *
 * Description of YiiDebugToolbarPanelSettings
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @author Igor Golovanov <igor.golovanov@gmail.com>
 * @version $Id$
 * @package YiiDebugToolbar
 * @since 1.1.7
 */
class YiiDebugToolbarPanelSettings extends YiiDebugToolbarPanel
{
    public function getMenuTitle()
    {
        return YiiDebug::t('Settings');
    }

    public function getMenuSubTitle()
    {
        return 'YII_DEBUG ' . CHtml::tag( 'span', array(
                    'style'=>sprintf('color:%s;',YII_DEBUG ? 'red':'green')
                ), YII_DEBUG ? YiiDebug::t('ON') : YiiDebug::t('OFF'));
    }

    public function getTitle()
    {
        return YiiDebug::t('Application Settings');
    }

    public function getSubTitle()
    {
        return sprintf('(%s)', get_class(Yii::app()));
    }

    public function init()
    {

    }

    protected function getApplicationData()
    {
        return $this->prepareData(get_object_vars(Yii::app()));
    }

    protected function getModulesData()
    {
        return $this->prepareData(Yii::app()->modules);
    }

    protected function getApplicationParams()
    {
        return $this->prepareData(Yii::app()->params);
    }

    protected function getComponentsData()
    {
        return $this->prepareData(Yii::app()->components);
    }

    public function run()
    {
        $this->render('settings', array(
            'application' => $this->getApplicationData(),
            'params' => $this->getApplicationParams(),
            'modules' => $this->getModulesData(),
            'components' => $this->getComponentsData(),

        ));
    }

    private function prepareData($data)
    {
        $result = array();
        foreach ($data as $key=>$value)
        {
            if (is_object($value))
            {
                $value = array_merge(array(
                    'class' => get_class($value)
                ), get_object_vars($value));

            }
            $result[$key] = $value;
        }
        return $result;
    }
}
