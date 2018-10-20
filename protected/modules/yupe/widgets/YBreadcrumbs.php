<?php

Yii::import('zii.widgets.CBreadcrumbs');

class YBreadcrumbs extends \CBreadcrumbs
{
    /**
     * Renders the content of the portlet.
     */
    public function run()
    {
        if (empty($this->links))
            return;

        $definedLinks = $this->links;

        echo CHtml::openTag($this->tagName, $this->htmlOptions) . "\n";
        $links = array();
        if ($this->homeLink === null)
            $definedLinks = [Yii::t('zii', 'Home') => Yii::app()->homeUrl] + $definedLinks;
        elseif ($this->homeLink !== false)
            $links[] = $this->homeLink;

        $i = 0;

        foreach ($definedLinks as $label => $url) {
            $i++;
            if (is_string($label) || is_array($url)) {

                $links[] = strtr($this->activeLinkTemplate, [
                    '{url}' => CHtml::normalizeUrl($url),
                    '{label}' => $this->encodeLabel ? CHtml::encode($label) : $label,
                    '{position}' => $i
                ]);
            } else

                $links[] = strtr($this->inactiveLinkTemplate, [
                    '{label}' => $this->encodeLabel ? CHtml::encode($url) : $url,
                    '{position}' =>  $i
                ]);

        }
        echo implode($this->separator, $links);
        echo CHtml::closeTag($this->tagName);
    }
}