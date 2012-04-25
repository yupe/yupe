<?php
/**
 * BootCrumb class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('zii.widgets.CBreadcrumbs');

/**
 * Bootstrap breadcrumb widget.
 */
class BootBreadcrumbs extends CBreadcrumbs
{
	/**
	 * @var array the HTML attributes for the breadcrumbs container tag.
	 */
	public $htmlOptions = array('class'=>'breadcrumb');
	/**
	 * @var string the separator between links in the breadcrumbs (defaults to ' / ').
	 */
	public $separator = '/';

	/**
	 * Renders the content of the widget.
	 */
	public function run()
	{
		$links = array();

		if ($this->homeLink === null || !(isset($this->homeLink['label']) && isset($this->homeLink['url'])))
			$this->homeLink = array('label'=>Yii::t('bootstrap', 'Home'),'url'=>Yii::app()->homeUrl);

		if (!empty($this->links))
		{
			$content = CHtml::link($this->homeLink['label'], $this->homeLink['url']);
			$links[] = $this->renderItem($content);
		}
		else
			$links[] = $this->renderItem($this->homeLink['label'], true);

		foreach ($this->links as $label=>$url)
		{
			if (is_string($label) || is_array($url))
			{
				$label = $this->encodeLabel ? CHtml::encode($label) : $label;
				$content = CHtml::link($label, $url);
				$links[] = $this->renderItem($content);
			}
			else
				$links[] = $this->renderItem($this->encodeLabel ? CHtml::encode($url) : $url, true);
		}

		echo CHtml::openTag('ul', $this->htmlOptions);
		echo implode('', $links);
		echo '</ul>';
	}

	/**
	 * Renders a single breadcrumb item.
	 * @param string $content the content.
	 * @param boolean $active whether the item is active.
	 * @return string the markup.
	 */
	protected function renderItem($content, $active=false)
	{
		$separator = !$active ? '<span class="divider">'.$this->separator.'</span>' : '';
		
		ob_start();
		echo CHtml::openTag('li', $active ? array('class'=>'active') : array());
		echo $content.$separator;
		echo '</li>';
		return ob_get_clean();
	}
}
