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
            'slug'=> $model->slug
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
    'htmlOptions'=> array( 'class' => 'well' ),
));
?>
<fieldset class="inline">
    <div class="alert alert-info">
        <?php echo Yii::t('PageModule.page', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('PageModule.page', 'обязательны.'); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('category_id') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'category_id', CHtml::listData($this->module->getCategoryList(), 'id', 'name'), array('class' => 'span7 popover-help','empty' => Yii::t('NewsModule.news', '--выберите--'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('order') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'order', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('order'), 'data-content' => $model->getAttributeDescription('order'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('slug') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'slug', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('slug'), 'data-content' => $model->getAttributeDescription('slug'))); ?>
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
