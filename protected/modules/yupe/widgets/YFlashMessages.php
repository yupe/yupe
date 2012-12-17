<?php

class YFlashMessages extends YWidget
{
    const NOTICE_MESSAGE  = 'notice';
    const WARNING_MESSAGE = 'warning';
    const ERROR_MESSAGE   = 'error';

    public $error           = 'error';
    public $warning         = 'warning';
    public $notice          = 'notice';
    public $autoHide        = false;
    public $autoHideSeconds = 3600;
    public $divId           = 'flash';
    public $customJsCode;

    public function run()
    {
        if (count(Yii::app()->user->getFlashes(false)))
        {
            if ($this->autoHide)
            {
                $this->autoHideSeconds = (int) $this->autoHideSeconds;
                $this->error           =       CHtml::encode($this->error);
                $this->warning         =       CHtml::encode($this->warning);
                $this->notice          =       CHtml::encode($this->notice);

                $js = "$('#{$this->divId}').fadeOut({$this->autoHideSeconds});";

                Yii::app()->getClientScript()->registerCoreScript('jquery');
                Yii::app()->getClientScript()->registerScript(md5($this->id), $js, CClientScript::POS_END);
            }
            else if ($this->customJsCode)
            {
                Yii::app()->getClientScript()->registerCoreScript('jquery');
                Yii::app()->getClientScript()->registerScript(md5($this->customJsCode), $this->customJsCode, CClientScript::POS_END);
            }

            $this->render('flashmessages');
        }
    }
}