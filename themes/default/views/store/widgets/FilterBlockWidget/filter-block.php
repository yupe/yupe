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
    </div>
</div>
