<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('page')->getCategory() => array(),
        Yii::t('PageModule.page', 'Страницы') => array('/page/default/index'),
        $model->title => array('/page/default/view', 'id' => $model->id),
        Yii::t('PageModule.page', 'Изменение'),
    );

    $this->pageTitle = Yii::t('PageModule.page', 'Редактирование страницы');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('PageModule.page', 'Управление страницами'), 'url' => array('/page/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('PageModule.page', 'Добавить страницу'), 'url' => array('/page/default/create')),
        array('label' => Yii::t('PageModule.page', 'Страница') . ' «' . mb_substr($model->title, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('PageModule.page', 'Редактирование страницы'), 'url' => array(
            '/page/default/update',
            'id'=> $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('PageModule.page', 'Просмотр страницы'), 'url' => array(
            '/page/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('PageModule.page', 'Удалить эту страницу'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/page/default/delete', 'id' => $model->id),
            'confirm' => Yii::t('PageModule.page', 'Вы уверены, что хотите удалить страницу?'),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PageModule.page', 'Редактирование записи'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'page-form',
    'enableAjaxValidation' => false,
    //'htmlOptions'=> array( 'class' => 'well' ),
));
?>
<fieldset class="inline">
    <div class="alert alert-info"><?php echo Yii::t('PageModule.page', 'Поля, отмеченные * обязательны для заполнения')?></div>
    <div class="row-fluid control-group">
        <div class="span3">
            <?php echo $form->labelEx($model, 'category_id' ); ?>
            <?php echo $form->dropDownList($model, 'category_id', CHtml::listData($this->module->getCategoryList(), 'id', 'name'), array( 'empty' => Yii::t('news', '--выберите--'))); ?>
        </div>
        <div class="span3">
            <?php echo $form->labelEx($model, 'parent_id' ); ?>
            <?php echo $form->dropDownList($model, 'parent_id', $pages); ?>
        </div>
    </div>
    <div class="row-fluid control-group">
        <div class="span3 popover-help" data-content="<?php echo Yii::t('PageModule.page', "<span class='label label-success'>Опубликовано</span> &ndash; Страницу видят все посетители сайта, режим по-умолчанию.<br /><br /><span class='label label-default'>Черновик</span> &ndash; Данная страница еще не окончена и не должна отображаться.<br /><br /><span class='label label-info'>На модерации</span> &ndash; Данная страница еще не проверена и не должна отображаться."); ?>" data-original-title="<?php echo $model->getAttributeLabel('status'); ?>" >
            <?php echo $form->labelEx($model, 'status' ); ?>
            <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
        </div>
        <div class="span3 popover-help" data-content="<?php echo Yii::t('PageModule.page', "Чем большее числовое значение вы укажете в этом поле, тем выше будет позиция данной страницы в меню."); ?>" data-original-title="<?php echo $model->getAttributeLabel('order'); ?>" >
            <?php echo $form->labelEx($model, 'order' ); ?>
            <?php echo $form->textField($model, 'order', array('size' => 10, 'maxlength' => 10)); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'order'); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model-> hasErrors('slug') ? 'error' : '' ?>">
        <div class="span7  popover-help" data-content="<?php echo Yii::t('PageModule.page', "Краткое название страницы латинскими буквами, используется для формирования её адреса.<br /><br /> Например (выделено темным фоном): <pre>http://site.ru/page/<span class='label'>contacts</span>/</pre> Если вы не знаете, для чего вам нужно это поле &ndash; не заполняйте его, заголовка страницы будет достаточно."); ?>" data-original-title="<?php echo $model->getAttributeLabel('slug'); ?>" >
            <?php echo $form->labelEx($model, 'slug'); ?>
            <?php echo $form->textField($model, 'slug', array('size' => 60, 'maxlength' => 150, 'placeholder' => Yii::t('PageModule.page', 'Оставьте пустым для автоматической генерации'))); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'slug'); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model-> hasErrors('is_protected') ? 'error' : '' ?>">
        <div class="span7  popover-help" data-content="<?php echo Yii::t('PageModule.page', "Страница будет видна только авторизованным пользователям"); ?>" data-original-title="<?php echo $model->getAttributeLabel('is_protected'); ?>" >
            <?php echo $form->labelEx($model, 'is_protected'); ?>
            <?php echo $form->checkBox($model, 'is_protected'); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'is_protected'); ?>
        </div>
    </div>

    <?php
        $items = array();
        foreach ($langs as $l)
            $items[] = array(
                'label'       => "[" . $l . "] " . mb_convert_case(Yii::app()->locale->getLocaleDisplayName($l), MB_CASE_TITLE, 'UTF-8'),
                'url'         => '#tab-' . $l,
                'linkOptions' => array("data-toggle" => "tab"),
                'active'      => $l == $model->lang,
            );

        $this->widget('bootstrap.widgets.TbMenu', array(
            'type'        => 'tabs', // '', 'tabs', 'pills' (or 'list')
            'stacked'     => false,  // whether this is a stacked menu
            'items'       => $items ,
            'htmlOptions' => array('style' => 'margin-bottom:0;'),
        ));

        echo CHtml::openTag("div", array(
            "class" => "tab-content",
            'style' => 'background-color: whiteSmoke; padding: 5px; border-bottom: 1px solid #DDD; border-left: 1px solid #DDD; border-right: 1px solid #DDD;'
        ));
        foreach ($langs as $l)
        {
            echo CHtml::openTag("div", array("class" => "tab-pane " . ($l == $model->lang ? "active" : ""), "id" => "tab-" . $l));
            echo $this->renderPartial('_mform', array('model' => $models[$l], 'pages' => $pages, 'form' => $form ));
            echo CHtml::closeTag("div");
        }
        echo CHtml::closeTag("div");
    ?>
</fieldset>

<?php
    echo "<br />";
    echo CHtml::submitButton($model->isNewRecord
        ? Yii::t('PageModule.page', 'Добавить страницу и продолжить редактирование')
        : Yii::t('PageModule.page', 'Сохранить и продолжить редактирование'), array('class' => 'btn btn-primary')
    );
    echo "&nbsp;";
    echo CHtml::submitButton($model->isNewRecord
        ? Yii::t('PageModule.page', 'Добавить и закрыть')
        : Yii::t('PageModule.page', 'Сохранить и закрыть'), array('name' => 'saveAndClose', 'id' => 'saveAndClose', 'class' => 'btn btn-info')
    );

    $this->endWidget();
?>
