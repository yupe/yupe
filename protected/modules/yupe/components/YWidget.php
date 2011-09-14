<?php
class YWidget extends CWidget
{   
    public function getViewPath()
    {        
        if(!is_object(Yii::app()->theme))
        {
            return parent::getViewPath();
        }        
        
        $themeView = Yii::app()->themeManager->basePath.DIRECTORY_SEPARATOR.Yii::app()->theme->name.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'widgets'.DIRECTORY_SEPARATOR.get_class($this);            

        return file_exists($themeView) ? $themeView : parent::getViewPath();
    }
}
?>