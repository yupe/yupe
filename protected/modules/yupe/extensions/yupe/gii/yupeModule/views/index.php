<h1><?=  Yii::t('YupeModule.yupe', 'Yupe! Generator module!'); ?></h1>

<p><?=  Yii::t('YupeModule.yupe', 'This generator will help you to generate base classes for the module Yupe.'); ?></p>

<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>

	<div class="row">
		<?=  $form->labelEx($model,'moduleID'); ?>
		<?=  $form->textField($model,'moduleID',array('size'=>65)); ?>
		<div class="tooltip">
			Module ID is case-sensitive. It should only contain word characters.
			The generated module class will be named after the module ID.
			For example, a module ID <code>forum</code> will generate the module class
			<code>ForumModule</code>.
		</div>
		<?=  $form->error($model,'moduleID'); ?>
	</div>

    <div class="row">
        <?=  $form->labelEx($model,'moduleCategory'); ?>
        <?=  $form->textField($model,'moduleCategory',array('size'=>65)); ?>
        <div class="tooltip">
            Каждый модуль должен принадлежать одной категории, именно по категориям делятся модули в панели управления.
            Примеры категорий: <code>Content</code>, <code>User</code>.
        </div>
        <?=  $form->error($model,'moduleCategory'); ?>
    </div>

    <div class="row">
        <?=  $form->labelEx($model,'moduleIcon'); ?>
        <?=  $form->textField($model,'moduleIcon',array('size'=>65)); ?>
        <div class="tooltip">
            Название иконки для меню админки. Примеры : <code>pencil</code>, <code>plus-square</code>.
        </div>
        <?=  $form->error($model,'moduleCategory'); ?>
        <p>Полный список можно посмотреть на сайте: <?=  CHtml::link('fontawesome.ru','http://fontawesome.ru/icons/'); ?></p>
    </div>

    <div class="row">
        <?=  $form->labelEx($model,'generateMigration'); ?>
        <?=  $form->checkBox($model,'generateMigration'); ?>
        <div class="tooltip">
            При включении данной опции, будет сгенерирован файл миграции.
        </div>
        <?=  $form->error($model,'generateMigration'); ?>
    </div>

<?php $this->endWidget(); ?>
