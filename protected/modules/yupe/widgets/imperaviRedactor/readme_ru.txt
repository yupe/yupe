EImperaviRedactorWidget
=======================

Позволяет использовать [imperavi redactor](http://redactor.imperavi.ru/) как виджет формы.

Использование
-------------
~~~
[php]
$this->widget('ext.yiiext.widgets.imperaviRedactor.EImperaviRedactorWidget',array(
	// можно использовать как для поля модели
	'model'=>$my_model,
	'attribute'=>'my_field',
	// так и просто для элемента формы
	'name'=>'my_input_name',
	// [настройки](http://redactor.imperavi.ru/) редактора imperavi
	'options'=>array(
		'toolbar'=>'classic',
		'cssPath'=>Yii::app()->theme->baseUrl.'/css/',
	),
));
~~~
