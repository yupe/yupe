<?php
class ContentBlockWidget extends YWidget
{
    public $code;
    public $silent = false;

    public function init()
    {
        if (!$this->code)
            throw new CException(Yii::t('ContentBlockModule.contentblock', 'Укажите название контент блока для ContentBlockWidget!'));
    }

    public function run()
    {
        $cacheName = "ContentBlock{$this->code}" . Yii::app()->language;

        $output = Yii::app()->cache->get($cacheName);

        if ($output === false)
        {
            $block = ContentBlock::model()->find('code = :code', array(':code' => $this->code));

            if (!$block && (bool) $this->silent === false)
                throw new CException(Yii::t('ContentBlockModule.contentblock', 'Контент блок "{code}" не найден !', array('{code}' => $this->code)));
            else
            {
                switch ($block->type)
                {
                    case ContentBlock::PHP_CODE:
                        $output = eval($block->content);
                        break;
                    case ContentBlock::SIMPLE_TEXT:
                        $output = CHtml::encode($block->content);
                        break;
                    case ContentBlock::HTML_TEXT:
                        $output = $block->content;
                        break;
                }
            }
            Yii::app()->cache->set($cacheName, $output);
        }
        $this->render('contentblock', array('output' => $output));
    }
}