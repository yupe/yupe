<?php
/* @var $attributes array */
?>

<div class="filter-block">
    <div class="filter-attributes">
        <?php $this->widget(
            'application.modules.store.widgets.filters.AttributesFilterWidget',
            ['attributes' => $attributes]
        ) ?>
    </div>
    <br/>

    <div>
        <input type="submit" value="Подобрать" class="btn btn-primary"/>
        <input type="reset" value="Очистить" class="btn btn-default" onclick="$('#store-filter').reset();"/>
    </div>
</div>
