<?php
/**
 * TbFileUpload.php
 *
 * Modified version from the great implementation of XUpload Yii Extension
 * @author AsgarothBelem <asgaroth.belem@gmail.com>
 * @link http://blueimp.github.com/jQuery-File-Upload/
 * @link https://github.com/Asgaroth/xupload
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 11/5/12
 * Time: 12:46 AM
 */
Yii::import('zii.widgets.jui.CJuiInputWidget');
class TbFileUpload extends CJuiInputWidget
{
	/**
	 * the url to the upload handler
	 * @var string
	 */
	public $url;

	/**
	 * set to true to use multiple file upload
	 * @var boolean
	 */
	public $multiple = false;

	/**
	 * The upload template id to display files available for upload
	 * defaults to null, meaning using the built-in template
	 */
	public $uploadTemplate;

	/**
	 * The template id to display files available for download
	 * defaults to null, meaning using the built-in template
	 */
	public $downloadTemplate;

	/**
	 * Wheter or not to preview image files before upload
	 */
	public $previewImages = true;

	/**
	 * Whether or not to add the image processing pluing
	 */
	public $imageProcessing = true;

	/**
	 * @var string name of the form view to be rendered
	 */
	public $formView = 'bootstrap.views.fileupload.form';

	/**
	 * @var string name of the upload view to be rendered
	 */
	public $uploadView = 'bootstrap.views.fileupload.upload';

	/**
	 * @var string name of the download view to be rendered
	 */
	public $downloadView = 'bootstrap.views.fileupload.download';

	/**
	 * @var string name of the view to display images at bootstrap-slideshow
	 */
	public $previewImagesView = 'bootstrap.views.gallery.preview';

	/**
	 * Widget initialization
	 */
	public function init()
	{
		if ($this->uploadTemplate === null) {
			$this->uploadTemplate = "#template-upload";
		}

		if ($this->downloadTemplate === null) {
			$this->downloadTemplate = "#template-download";
		}

		if (!isset($this->htmlOptions['enctype'])) {
			$this->htmlOptions['enctype'] = 'multipart/form-data';
		}

		parent::init();
	}

	/**
	 * Generates the required HTML and Javascript
	 */
	public function run()
	{

		list($name, $id) = $this->resolveNameID();

		$this->htmlOptions['id'] = ($this->hasModel() ? get_class($this->model) : 'fileupload') . '-form';

		$this->options['url'] = $this->url;

		// if acceptFileTypes is not set as option, try getting it from models rules
		if (!isset($this->options['acceptFileTypes'])) {
			$fileTypes = $this->getFileValidatorProperty($this->model, $this->attribute, 'types');
			if (isset($fileTypes)) {
				$fileTypes = (preg_match(':jpg:', $fileTypes) && !preg_match(':jpe:', $fileTypes) ? preg_replace(
					':jpg:',
					'jpe?g',
					$fileTypes
				) : $fileTypes);
				$this->options['acceptFileTypes'] = 'js:/(\.)(' . preg_replace(':,:', '|', $fileTypes) . ')$/i';
			}
		}

		// if maxFileSize is not set as option, try getting it from models rules
		if (!isset($this->options['maxFileSize'])) {
			$fileSize = $this->getFileValidatorProperty($this->model, $this->attribute, 'maxSize');
			if (isset($fileSize)) {
				$this->options['maxFileSize'] = $fileSize;
			}
		}

		if ($this->multiple) {
			$this->htmlOptions["multiple"] = true;
		}

		$this->render($this->uploadView);
		$this->render($this->downloadView);
		$this->render($this->formView, array('name' => $name, 'htmlOptions' => $this->htmlOptions));

		if ($this->previewImages || $this->imageProcessing) {
			$this->render($this->previewImagesView);
		}

		$this->registerClientScript($this->htmlOptions['id']);
	}

	/**
	 * Registers and publishes required scripts
	 *
	 * @param string $id
	 */
	public function registerClientScript($id)
	{

		Yii::app()->bootstrap->registerAssetCss('fileupload/jquery.fileupload-ui.css');

		// Upgrade widget factory
		// @todo remove when jquery.ui 1.9+ is fully integrated into stable Yii versions
		Yii::app()->bootstrap->registerAssetJs('fileupload/vendor/jquery.ui.widget.js');
		//The Templates plugin is included to render the upload/download listings
		Yii::app()->bootstrap->registerAssetJs("fileupload/tmpl.min.js", CClientScript::POS_END);

		if ($this->previewImages || $this->imageProcessing) {
			Yii::app()->bootstrap->registerAssetJs("fileupload/load-image.min.js", CClientScript::POS_END);
			Yii::app()->bootstrap->registerAssetJs("fileupload/canvas-to-blob.min.js", CClientScript::POS_END);
			// gallery :)
			Yii::app()->bootstrap->registerAssetCss("bootstrap-image-gallery.min.css");
			Yii::app()->bootstrap->registerAssetJs("bootstrap-image-gallery.min.js", CClientScript::POS_END);
		}
		//The Iframe Transport is required for browsers without support for XHR file uploads
		Yii::app()->bootstrap->registerAssetJs('fileupload/jquery.iframe-transport.js');
		Yii::app()->bootstrap->registerAssetJs('fileupload/jquery.fileupload.js');
		// The File Upload image processing plugin
		if ($this->imageProcessing) {
			Yii::app()->bootstrap->registerAssetJs('fileupload/jquery.fileupload-ip.js');
		}
		// The File Upload file processing plugin
		if ($this->previewImages) {
			Yii::app()->bootstrap->registerAssetJs('fileupload/jquery.fileupload-fp.js');
		}
		// locale
		Yii::app()->bootstrap->registerAssetJs('fileupload/jquery.fileupload-locale.js');
		//The File Upload user interface plugin
		Yii::app()->bootstrap->registerAssetJs('fileupload/jquery.fileupload-ui.js');

		$options = CJavaScript::encode($this->options);
		Yii::app()->clientScript->registerScript(__CLASS__ . '#' . $id, "jQuery('#{$id}').fileupload({$options});");
	}

	/**
	 * Check for a property of CFileValidator
	 *
	 * @param CModel $model
	 * @param string $attribute
	 * @param null $property
	 *
	 * @return string property's value or null
	 */
	private function getFileValidatorProperty($model = null, $attribute = null, $property = null)
	{
		if (!isset($model, $attribute, $property)) {
			return null;
		}

		foreach ($model->getValidators($attribute) as $validator) {
			if ($validator instanceof CFileValidator) {
				$ret = $validator->$property;
			}
		}
		return isset($ret) ? $ret : null;
	}
}
