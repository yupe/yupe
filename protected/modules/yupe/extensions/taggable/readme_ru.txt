Taggable Behavior
=================

Позволяет модели работать с тегами.

Установка и настройка
---------------------
Создать таблицу для хранения тегов и кросс-таблицу для связи тегов с моделью.
Для конфигурации ниже можно воспользоваться SQL из файла `schema.sql`.

Определить в модели ActiveRecord метод `behaviors()`:
~~~
[php]
function behaviors() {
    return array(
        'tags' => array(
            'class' => 'ext.yiiext.behaviors.model.taggable.ETaggableBehavior',
            // Имя таблицы для хранения тегов
            'tagTable' => 'Tag',
            // Имя кросс-таблицы, связывающей тег с моделью.
            // По умолчанию выставляется как Имя_таблицы_моделиTag
            'tagBindingTable' => 'PostTag',
            // Имя внешнего ключа модели в кроcc-таблице.
            // По умолчанию равно имя_таблицы_моделиId
            'modelTableFk' => 'post_id',

            // tagTableCondition - по умолчанию пусто. Может быть использовано в том случае, если тег составляется
            // из нескольких полей и требуется особый SQL для его нахождения. Пример для таблицы user:
            // 'tagTableCondition' => new CDbExpression("CONCAT(t.name,' ',t.surname) = :tag "),

            // Имя первичного ключа тега
            'tagTablePk' => 'id',
            // Имя поля названия тега
            'tagTableName' => 'name',
            // Имя поля счетчика тега
            // Если устанвовлено в null (по умолчанию), то не сохраняется в базе
            'tagTableCount' => 'count',
            // ID тега в таблице-связке
            'tagBindingTableTagId' => 'tagId',
            // ID компонента, реализующего кеширование. Если false кеширование не происходит.
            // По умолчанию ID равен false.
            'cacheID' => 'cache',


            // Создавать несуществующие теги автоматически.
            // При значении false сохранение выкидывает исключение если добавляемый тег не существует.
            'createTagsAutomatically' => true,

			// Критерий по умолчанию для выборки тегов
            'scope' => array(
				'condition' => ' t.user_id = :user_id ',
				'params' => array( ':user_id' => Yii::app()->user->id ),
			),

			// Значения, которые необходимо вставлять при записи тега
			'insertValues' => array(
				'user_id' => Yii::app()->user->id,
			),
        )
    );
}
~~~

Если надо использовать теги через модель (например, для назначения им своего поведения),
используйте класс EARTaggableBehavior

Добавить в секцию import настроек строку подключения директории расшриения taggable

~~~
[php]
return array(
  // ...
  'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.yiiext.behaviors.model.taggable.*',
		// ...
		// другие импорты
	),
	// ...
);

~~~

Определить в модели ActiveRecord метод `behaviors()`:

~~~
[php]
function behaviors() {
    return array(
        'tags_with_model' => array(
            'class' => 'ext.yiiext.behaviors.model.taggable.EARTaggableBehavior',
            // Имя таблицы для хранения тегов
            'tagTable' => 'Tag',
            // Имя модели тега
            'tagModel' => 'Tag',
            // ...
            // остальные нужные параметры указываются также, как и выше
        )
    );
}
~~~

Методы
------
### setTags($tags)
Задаёт новые теги для модели затирая старые.

~~~
[php]
$post = new Post();
$post->setTags('tag1, tag2, tag3')->save();
~~~


### addTags($tags) или addTag($tags)
Добавляет один или несколько тегов к уже существующим.

~~~
[php]
$post->addTags('new1, new2')->save();
~~~


### removeTags($tags) или removeTag($tags)
Удаляет указанные теги (если есть).

~~~
[php]
$post->removeTags('new1')->save();
~~~

### removeAllTags()
Удаляет все теги данной модели.

~~~
[php]
$post->removeAllTags()->save();
~~~

### getTags()
Отдаёт массив тегов.

~~~
[php]
$tags = $post->getTags();
foreach($tags as $tag){
  echo $tag;
}
~~~

### hasTag($tags) или hasTags($tags)
Назаначены ли модели указанные теги.

~~~
[php]
$post = Post::model()->findByPk(1);
if($post->hasTags("yii, php")){
    //…
}
~~~

### getAllTags()
Отдаёт все имеющиеся для этого класса моделей теги.

~~~
[php]
$tags = Post::model()->getAllTags();
foreach($tags as $tag){
  echo $tag;
}
~~~

### getAllTagsWithModelsCount()
Отдаёт все имеющиеся для этого класса модели теги с количеством моделей для каждого.

~~~
[php]
$tags = Post::model()->getAllTagsWithModelsCount();
foreach($tags as $tag){
  echo $tag['name']." (".$tag['count'].")";
}
~~~

### taggedWith($tags) или withTags($tags)
Позволяет ограничить запрос AR записями с указанными тегами.

~~~
[php]
$posts = Post::model()->taggedWith('php, yii')->findAll();
$postCount = Post::model()->taggedWith('php, yii')->count();
~~~

### resetAllTagsCache() и resetAllTagsWithModelsCountCache()
Используются для сборса кеша getAllTags() и getAllTagsWithModelsCount().



Приятные бонусы
---------------
Теги, разделённые запятой можно распечатать следующим образом:

~~~
[php]
$post->addTags('new1, new2')->save();
echo $post->tags->toString();
~~~

Использование нескольких групп тегов
------------------------------------
Модели можно присвоить теги из нескольких групп. Например, для модели Software можно
задать теги групп OS и Category.

Для этого необходимо создать по две таблицы на каждую группу тегов:

~~~
[sql]
/* Tag table */
CREATE TABLE `Os` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `Os_name` (`name`)
);

/* Tag binding table */
CREATE TABLE `PostOs` (
  `post_id` INT(10) UNSIGNED NOT NULL,
  `osId` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY  (`post_id`,`osId`)
);

/* Tag table */
CREATE TABLE `Category` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `Category_name` (`name`)
);

/* Tag binding table */
CREATE TABLE `PostCategory` (
  `post_id` INT(10) UNSIGNED NOT NULL,
  `categoryId` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY  (`post_id`,`categoryId`)
);
~~~

Затем прописать для модели поведения:

~~~
[php]
return array(
    'categories' => array(
        'class' => 'ext.yiiext.behaviors.model.taggable.ETaggableBehavior',
        'tagTable' => 'Category',
        'tagBindingTable' => 'PostCategory',
        'tagBindingTableTagId' => 'categoryId',
    ),
    'os' => array(
        'class' => 'ext.yiiext.behaviors.model.taggable.ETaggableBehavior',
        'tagTable' => 'Os',
        'tagBindingTable' => 'PostOs',
        'tagBindingTableTagId' => 'osId',
    ),
);
~~~

Далее можно писать такой код:

~~~
[php]
$soft = Software::model()->findByPk(1);
// по умолчанию идут методы подключенного выше поведения,
// поэтому можно не писать $soft->categories->addTag("Antivirus"),
// а использовать краткую форму:
$soft->addTag("Antivirus");
$soft->os->addTag("Windows");
$soft->save();
~~~

Использование с CAutoComplete
-----------------------------

~~~
[php]
<?$this->widget('CAutoComplete', array(
	'name' => 'tags',
	'value' => $model->tags->toString(),
	'url'=>'/autocomplete/tags', //путь к URL для дополнения тегов
	'multiple'=>true,
	'mustMatch'=>false,
	'matchCase'=>false,
)) ?>
~~~

Сохранение тегов будет выглядеть так:

~~~
[php]
function actionUpdate(){
	$model = Post::model()->findByPk($_GET['id']);

	if(isset($_POST['Post'])){
		$model->attributes=$_POST['Post'];
		$model->setTags($_POST['tags']);

		// если у вас более одной группы тегов:
		// $model->tags1->setTags($_POST['tags1']);
		// $model->tags1->setTags($_POST['tags2']);

		if($model->save()) $this->redirect(array('index'));
	}
	$this->render('update',array(
		'model'=>$model,
	));
}
~~~