Markitup widget
===============

Adds [markItUp](http://markitup.jaysalvat.com/) widget as a form field widget.


Installation
------------
Unpack to `protected/extensions`.

Usage
-----

~~~
[php]
<?php $this->widget('ext.yiiext.widgets.markitup.EMarkitupWidget', array(
    // you can either use it for model attribute
	'model' => $my_model,
	'attribute' => 'my_field',

	// or just for input field
    'name' => 'my_input_name',
))?>
~~~
