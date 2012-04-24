EImperaviRedactorWidget
=======================

Adds [imperavi redactor](http://redactor.imperavi.ru/) as a form field widget.

Usage
-----
~~~
[php]
$this->widget('ext.yiiext.widgets.imperaviRedactor.EImperaviRedactorWidget',array(
	// you can either use it for model attribute
	'model'=>$my_model,
	'attribute'=>'my_field',
	// or just for input field
	'name'=>'my_input_name',
	// imperavi redactor [options](http://redactor.imperavi.ru/)
	'options'=>array(
		'toolbar'=>'classic',
		'cssPath'=>Yii::app()->theme->baseUrl.'/css/',
	),
));
~~~
