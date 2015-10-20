<?php
/* @var $attributes array */
?>

<?php $this->widget(
    'application.modules.store.widgets.filters.AttributesFilterWidget',
    ['attributes' => $attributes]
) ?>

<div class="catalog-filter__button"><input type="submit" value="Подобрать" class="btn btn_wide"/></div>