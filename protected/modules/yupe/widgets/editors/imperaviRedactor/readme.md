Imperavi Redactor Widget
========================

`ImperaviRedactorWidget` is a wrapper for [Imperavi Redactor](http://imperavi.com/redactor/),
a high quality WYSIWYG editor.

Note that Imperavi Redactor itself is a proprietary commercial copyrighted software
but since Yii community bought OEM license you can use it for free with Yii.

Usage
-----

First, import the widget class file

```php
Yii::import('ext.imperavi-redactor-widget.ImperaviRedactorWidget');
```

Next, call the widget:

```php
$this->widget('ImperaviRedactorWidget', array(
	// You can either use it for model attribute
	'model' => $my_model,
	'attribute' => 'my_field',

	// or just for input field
	'name' => 'my_input_name',

	// Some options, see http://imperavi.com/redactor/docs/
	'options' => array(
		'lang' => 'ru',
		'toolbar' => false,
		'iframe' => true,
		'css' => 'wym.css',
	),
));
```

Alternatively you can attach Redactor to already existing DOM element by calling:

```php
$this->widget('ImperaviRedactorWidget', array(
	// The textarea selector
	'selector' => '.redactor',
	// Some options, see http://imperavi.com/redactor/docs/
	'options' => array(),
));
```

The redactor plugins plugged in with packages of resources.

```php
$this->widget('ImperaviRedactorWidget', array(
	'selector' => '.redactor',
	'options' => array(
		'lang' => 'ru',
	),
	'plugins' => array(
		'fullscreen' => array(
			'js' => array('fullscreen.js',),
		),
		'clips' => array(
			// You can set base path to assets
			'basePath' => 'application.components.imperavi.my_plugin',
			// or url, basePath will be ignored.
			// Defaults is url to plugis dir from assets
			'baseUrl' => '/js/my_plugin',
			'css' => array('clips.css',),
			'js' => array('clips.js',),
			// add depends packages
			'depends' => array('imperavi-redactor',),
		),
	),
));
```
