Markitup widget
===============

Позволяет использовать [markItUp](http://markitup.jaysalvat.com/) как виджет формы.


Установка
---------
Распаковать в `protected/extensions`.

Использование
-------------

~~~
[php]
<?php $this->widget('ext.yiiext.widgets.markitup.EMarkitupWidget', array(
    // можно использовать как для поля модели
	'model' => $my_model,
	'attribute' => 'my_field',

	// так и просто для элемента формы
    'name' => 'my_input_name',
))?>
~~~