<?php
$class = get_class($model);
Yii::app()->clientScript->registerScript(
    'gii.crud',
    "
    $('#{$class}_controller').change(function () {
        $(this).data('changed', $(this).val() != '');
    });
    $('#{$class}_model').bind('keyup change', function () {
        var controller = $('#{$class}_controller');
        if (!controller.data('changed')) {
            var id = new String($(this).val().match(/\\w*$/));
            if (id.length > 0)
                id = id.substring(0, 1).toLowerCase() + id.substring(1);
            controller.val(id);
        }
    });
"
);
?>
<h1><?php echo Yii::t('YupeModule.yupe', 'Yupe! Crud Generator!'); ?></h1>

<p><?php echo Yii::t('YupeModule.yupe', 'Yupe! Generator helps to create CRUD for any model.'); ?></p>

<p><?php echo Yii::t(
        'YupeModule.yupe',
        ' The resulting interface is well integrated into the control panel of Yupe!.'
    ); ?></p>

<p><?php echo Yii::t(
        'YupeModule.yupe',
        'More information and technical support you can find in our site {site}.',
        ['{site}' => CHtml::link(Yii::t('YupeModule.yupe', 'Yupe!'), 'http://yupe.ru/?from=generator')]
    ); ?></p>

<?php $form = $this->beginWidget('CCodeForm', ['model' => $model]); ?>

<div class="row">
    <?php echo $form->labelEx($model, 'model'); ?>
    <?php echo $form->textField($model, 'model', ['size' => 65]); ?>
    <div class="tooltip">
        Model class is case-sensitive. It can be either a class name (e.g. <code>Post</code>)
        or the path alias of the class file (e.g. <code>application.models.Post</code>).
        Note that if the former, the class must be auto-loadable.
    </div>
    <?php echo $form->error($model, 'model'); ?>
</div>

<div class="row">
    <label>Модуль (id) для которого генерируется CRUD</label>
    <?php echo $form->textField($model, 'mid', ['size' => 65]); ?>
    <div class="tooltip">
        Модуль (id) (например <code>page</code>, <code>user</code> или <code>news</code>)
    </div>
    <?php echo $form->error($model, 'mid'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'controller'); ?>
    <?php echo $form->textField($model, 'controller', ['size' => 65]); ?>
    <div class="tooltip">
        Контроллер ID чувствителен к регистру. CRUD controllers are often named after
        the model class name that they are dealing with. Ниже приведены некоторые примеры:
        <ul>
            <li><code>post</code> генерируется <code>PostController.php</code></li>
            <li><code>postTag</code> генерируется <code>PostTagController.php</code></li>
            <li><code>admin/user</code> генерируется <code>admin/UserController.php</code>.
                Если приложение имеет включенный модуль <code>admin</code>,
                он будет генерироваться <code>UserController</code> (and other CRUD code)
                within the module instead.
            </li>
        </ul>
    </div>
    <?php echo $form->error($model, 'controller'); ?>
</div>

<div class="row sticky">
    <?php echo $form->labelEx($model, 'baseControllerClass'); ?>
    <?php echo $form->dropDownList($model, 'baseControllerClass', $model->getBbaseControllerClassList(), ['style' => 'width: 484px;']); ?>
    <div class="tooltip">
        От этого класса будет унаследован новый класс контроллера CRUD.<br/>
        Пожалуйста, убедитесь, что класс существует и может быть автоматически загружаются.
    </div>
    <?php echo $form->error($model, 'baseControllerClass'); ?>
</div>

<br/>

<h2>Единственное число</h2>

<br/>
<label>Именительный (кто? что? есть ...)</label>
<?php echo $form->textField($model, 'im', ['size' => 65]); ?>
<br/>
<label>Родительный (Кого? Чего? нет ...)</label><?php echo $form->textField($model, 'rod', ['size' => 65]); ?>
<br/>
<label>Дательный (Кому? Чему? дам ...)</label><?php echo $form->textField($model, 'dat', ['size' => 65]); ?>
<br/>
<label>Винительный (Кого? Что? вижу ...)</label><?php echo $form->textField($model, 'vin', ['size' => 65]); ?>
<br/>
<label>Творительный (Кем? Чем? горжусь ...)</label><?php echo $form->textField($model, 'tvor', ['size' => 65]); ?>
<br/>
<label>Предложный (О ком? О чем? думаю о ...)</label><?php echo $form->textField($model, 'pre', ['size' => 65]); ?>
<br/>  <br/>
<h2>Множественное число</h2>
<br/>
<label>Именительный (кто? что? есть ...)</label><?php echo $form->textField($model, 'mim', ['size' => 65]); ?>
<br/>
<label>Родительный (Кого? Чего? нет ...)</label><?php echo $form->textField($model, 'mrod', ['size' => 65]); ?>
<br/>
<label>Творительный (Кем? Чем? горжусь ...)</label><?php echo $form->textField($model, 'mtvor', ['size' => 65]); ?>
<br/>

<?php $this->endWidget(); ?>