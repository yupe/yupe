<?php
/**
 *##  TbBreadcrumbs class file.
 *
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

Yii::import('zii.widgets.CBreadcrumbs');

/**
 * Bootstrap breadcrumb widget.
 * @see http://twitter.github.io/bootstrap/components.html#breadcrumbs
 * @package booster.widgets.navigation
 */
class TbBreadcrumbs extends CBreadcrumbs
{
	/**
	 * The tag name for the breadcrumbs container tag. Defaults to 'ul'.
	 * @var string
	 */
	public $tagName = 'ul';

	/**
	 * The HTML attributes for the breadcrumbs container tag.
	 * @var array
	 */
	public $htmlOptions = array('class' => 'breadcrumb');

	/**
	 * String, specifies how each inactive item is rendered. Defaults to
	 * "{label}", where "{label}" will be replaced by the corresponding item label.
	 * Note that inactive template does not have "{url}" parameter.
	 * @var string
	 */
	public $inactiveLinkTemplate = '{label}';

	/**
	 * The separator between links in the breadcrumbs. Defaults to '/'.
	 * @var string
	 */
	public $separator = '/';

	/**
	 *### .init()
	 *
	 * Initializes the widget.
	 */
	public function init()
	{
		$this->separator = '<span class="divider">' . $this->separator . '</span>';
	}

	/**
	 *### .run()
	 *
	 * Renders the content of the widget.
	 */
	public function run()
	{
		if (empty($this->links))
			return;

		echo CHtml::openTag($this->tagName, $this->htmlOptions);

		if ($this->homeLink === null) {
			$this->homeLink = CHtml::link(Yii::t('zii', 'Home'), Yii::app()->homeUrl);
		}
		if ($this->homeLink !== false) {
			// check whether home link is not a link
			$active = (stripos($this->homeLink, '<a') === false) ? ' class="active"' : '';
			echo '<li' . $active . '>' . $this->homeLink . $this->separator . '</li>';
		}

		end($this->links);
		$lastLink = key($this->links);

		foreach ($this->links as $label => $url) {
			if (is_string($label) || is_array($url)) {
				echo '<li>';
				echo strtr($this->activeLinkTemplate, array(
					'{url}' => CHtml::normalizeUrl($url),
					'{label}' => $this->encodeLabel ? CHtml::encode($label) : $label,
				));
			} else {
				echo '<li class="active">';
				echo str_replace('{label}', $this->encodeLabel ? CHtml::encode($url) : $url, $this->inactiveLinkTemplate);
			}

			if ($lastLink !== $label) {
				echo $this->separator;
			}
			echo '</li>';
		}

		echo CHtml::closeTag($this->tagName);
	}
}
