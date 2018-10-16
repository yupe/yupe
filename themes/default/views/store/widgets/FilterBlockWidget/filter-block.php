<?php
/* @var $attributes array */
?>

<div class="filter-block">
    <div class="filter-attributes">
        <?php $this->widget(
            'application.modules.store.widgets.filters.AttributesFilterWidget', [
                'attributes' => $attributes,
                'category' => $category,
            ]
        ) ?>
    </div>
    <?php if (!empty($attributes) || !empty($category)): ?>
        <div>
            <input type="submit" value="Подобрать" class="btn btn-primary"/>
        </div>
    <?php endif; ?>
</div>
