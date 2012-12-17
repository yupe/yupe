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
	// you can either use it for model attribute
	'model'=>$my_model,
	'attribute'=>'my_field',

	// or just for input field
	'name'=>'my_input_name',

	// some options, see http://imperavi.com/redactor/docs/
	'options'=>array(
		'lang'=>'en',
		'toolbar'=>'mini',
		'css'=>'wym.css',
	),
));
```

Alternatively you can attach Redactor to already existing DOM element by calling:

```php
$this->widget('ImperaviRedactorWidget',array(
	// the textarea selector
	'selector'=>'.redactor',
	// some options, see http://imperavi.com/redactor/docs/
	'options'=>array(),
));
```
