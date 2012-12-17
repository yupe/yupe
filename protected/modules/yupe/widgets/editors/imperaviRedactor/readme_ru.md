Imperavi Redactor Widget
========================

`ImperaviRedactorWidget` — обёртка для [Imperavi Redactor](http://imperavi.com/redactor/),
довольно неплохого WYSIWYG редактора.

Обратите внимание, что сам Imperavi Redactor — коммерческий продукт и не является
OpenSource, но так как сообщество Yii купило OEM-лицензию, то вы можете бесплатно
пользоваться им в проектах на Yii.

Использование
-------------

Импортируем виджет:

```php
Yii::import('ext.imperavi-redactor-widget.ImperaviRedactorWidget');
```

Вызываем виджет:

```php
$this->widget('ImperaviRedactorWidget', array(
	// можно использовать пару имя модели - имя свойства
	'model'=>$my_model,
	'attribute'=>'my_field',

	// или только имя поля ввода
	'name'=>'my_input_name',

	// немного опций, см. http://imperavi.com/redactor/docs/
	'options'=>array(
		'lang'=>'en',
		'toolbar'=>'mini',
		'css'=>'wym.css',
	),
));
```

Также можно подключить Redactor к уже существующим на странице элементам:

```php
$this->widget('ImperaviRedactorWidget',array(
	// селектор для textarea
	'selector'=>'.redactor',
	// немного опций, см. http://imperavi.com/redactor/docs/
	'options'=>array(),
));
```
