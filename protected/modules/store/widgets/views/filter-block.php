<?php
/* @var $attributes array */
?>

<div class="filter-block">
    <form>
        <div class="filter-attributes">
            <?php $this->widget('application.modules.store.widgets.AttributesFilterWidget', ['attributes' => $attributes]) ?>
        </div>
        <div>
            <input type="submit"/>
        </div>
    </form>
</div>
