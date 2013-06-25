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
	// Можно использовать пару имя модели - имя свойства
	'model' => $my_model,
	'attribute' => 'my_field',

	// или только имя поля ввода
	'name' => 'my_input_name',

	// Немного опций, см. http://imperavi.com/redactor/docs/
	'options' => array(
		'lang' => 'ru',
		'toolbar' => false,
		'iframe' => true,
		'css' => 'wym.css',
	),
));
```

Также можно подключить Redactor к уже существующим на странице элементам:

```php
$this->widget('ImperaviRedactorWidget', array(
	// Селектор для textarea
	'selector' => '.redactor',
	// Немного опций, см. http://imperavi.com/redactor/docs/
	'options' => array(),
));
```

Плагины редактора подключаются при помощи пакетов с ресурсами.

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
			// Можно указать путь для публикации
			'basePath' => 'application.components.imperavi.my_plugin',
			// Можно указать ссылку на ресурсы плагина, в этом случае basePath игнорирутеся.
			// По умолчанию, путь до папки plugins из ресурсов расширения
			'baseUrl' => '/js/my_plugin',
			'css' => array('clips.css',),
			'js' => array('clips.js',),
			// Можно также указывать зависимости
			'depends' => array('imperavi-redactor',),
		),
	),
));
```
