<?php
/* @var $attributes array */
?>

<?php $this->beginWidget(
    'application.modules.store.widgets.filters.AttributesFilterWidget', [
        'attributes' => $attributes,
        'category' => $category
    ]
) ?>

    <div class="catalog-filter__button"><input type="submit" value="Подобрать" class="btn btn_wide"/></div>

<?php $this->endWidget();?>
