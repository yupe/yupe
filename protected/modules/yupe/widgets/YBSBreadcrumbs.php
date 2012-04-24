<?php

Yii::import("zii.widgets.CBreadcrumbs");

class YBSBreadcrumbs extends CBreadcrumbs
{

    public $htmlOptions = array('class' => 'breadcrumb');

    public function init()
    {
        parent::init();
        $this->tagName = "ul";
    }

    public function run()
    {
        if (empty($this->links))
            return;

        echo CHtml::openTag($this->tagName, $this->htmlOptions) . "\n";
        $links = array();
        if ($this->homeLink === null)
            $links[] = CHtml::link(Yii::t('zii', 'Home'), Yii::app()->homeUrl);
        else if ($this->homeLink !== false)
            $links[] = $this->homeLink;

        $cl = count($links);
        $i = 0;

        foreach ($this->links as $label => $url)
        {

            if (is_string($label) || is_array($url))
            {
                echo CHtml::openTag("li");
                echo CHtml::link($this->encodeLabel ? CHtml::encode($label) : $label, $url);
            }
            else
            {
                echo CHtml::openTag("li", array("class" => "active"));
                echo ($this->encodeLabel ? CHtml::encode($url) : $url);
            }
            if ($i++ != $cl)
                echo CHtml::openTag("span", array("class" => "divider")) . $this->separator . CHtml::closeTag("span");
            echo CHtml::closeTag("li");
        }
        echo CHtml::closeTag($this->tagName);
    }
}