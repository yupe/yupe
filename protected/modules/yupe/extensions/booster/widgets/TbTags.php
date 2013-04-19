<?php
/*## TbTags class file.
 *
 * @author Antonio Ramirez <antonio@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php) 
 * @package bootstrap.widgets.input
 */

class TbTags extends CInputWidget
{
	/**
	 * @var TbActiveForm when created via TbActiveForm
	 *
	 * This attribute is set to the form that renders the widget
	 * @see TbActionForm->inputRow
	 */
	public $form;

	/**
	 * @var array 
	 *
	 * Suggestions for generating the list options:  array('A','B','C')
	 *
	 */
	public $suggestions = array();

	/**
	 * @var string[] the JavaScript event handlers.
	 * The events are on the format:
	 *
	 * <pre>
	 *    // ...
	 *    'whenAddingTag' => 'js:function(tag){ console.log(tag);}',
	 *    // ...
	 * </pre>
	 *
	 * @see <https://github.com/maxwells/bootstrap-tags#overrideable-functions>
	 *
	 */

	public $events = array(
		// whenAddingTag (tag:string) : anything external you'd like to do with the tag
		'whenAddingTag' => null,
		// tagRemoved (tag:string) : find out which tag was removed by either presseing delete key or clicking the (x)
		'tagRemoved'    => null,
		// definePopover (tag:string) : must return the popover content for the tag that is being added. (eg "Content for [tag]")
		'definePopover' => null,
		// excludes (tag:string) : returns true if you want the tag to be excluded, false if allowed
		'exclude'       => null,
		// pressedReturn (e:triggering event)
		'pressedReturn' => null,
		// pressedDelete (e:triggering event)
		'pressedDelete' => null,
		// pressedDown (e:triggering event)
		'pressedDown'   => null,
		// pressedUp (e:triggering event)
		'pressedUp'     => null,
	);

	/**
	 * @var array $restricTo the list of allowed tags
	 */
	public $restrictTo;

	/**
	 * @var array list of tags to display initially display
	 */
	public $tagData = array();

	/**
	 * @var array list of popover messages that should be displayed with the tags initially displayed.
	 *
	 * <strong>Note</strong>: Is important that the list matches the index list of those tags in $tagData.
	 */
	public $popoverData;

	/**
	 * @var array $excludes the list of disallowed tags
	 */
	public $exclude = array();

	/**
	 * @var boolean $displayPopovers whether to display popovers with information or not
	 */
	public $displayPopovers;

	/**
	 * @var string $tagClass what class the tag div will have for styling.
	 * Defaults to `btn-success`
	 */
	public $tagClass = 'btn-success';

	/**
	 * @var string $promptText placeholder string when the re are no tags and nothing typed in
	 */
	public $promptText = 'Please, type in your tags...';

	/**
	 * @var array $options the array to configure the js component.
	 */
	protected $options = array();

	/**
	 *### .init()
	 *
	 * Initializes the widget.
	 */
	public function init()
	{
		$this->options = CMap::mergeArray(array(
			'suggestions'     => $this->suggestions,
			'restrictTo'      => $this->restrictTo,
			'exclude'         => $this->exclude,
			'displayPopovers' => $this->displayPopovers,
			'tagClass'        => $this->tagClass,
			'tagData'         => $this->tagData,
			'popoverData'     => $this->popoverData
		), $this->options);
	}

	/**
	 *### .run()
	 *
	 * Runs the widget.
	 */
	public function run()
	{
		list($name, $id) = $this->resolveNameID();

		$this->renderContent($id, $name);
		$this->registerClientScript($id);
	}

	/**
	 *### .renderContent()
	 *
	 * Renders required HTML tags
	 *
	 * @param integer $id
	 * @param string $name
	 * @return string with HTML tags
	 */
	public function renderContent($id, $name)
	{

		if ($this->hasModel())
		{
			if ($this->form)
				echo $this->form->hiddenField($this->model, $this->attribute);
			else
				echo CHtml::activeHiddenField($this->model, $this->attribute);

		} else
			echo CHtml::hiddenField($name, $this->value);

		echo "<div id='tags_{$id}' class='tag-list'><div class='tags'></div></div>";
	}

	/**
	 *### .registerClientScript()
	 *
	 * Registers required client script for bootstrap select2.
	 * It is not used through bootstrap->registerPlugin
	 * in order to attach events if any
	 *
	 * @param string $id
	 */
	public function registerClientScript($id)
	{
		Yii::app()->bootstrap->registerAssetCss('bootstrap-tags.css');
		Yii::app()->bootstrap->registerAssetJs('bootstrap.tags.js');

		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';

		Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->getId(), "jQuery('#tags_{$id}').tags({$options});");
	}
}
