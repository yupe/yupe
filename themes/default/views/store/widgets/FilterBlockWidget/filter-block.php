<?php
/* @var $attributes array */
?>

<div class="filter-block">
    <form>
        <div class="filter-attributes">
            <?php $this->widget('application.modules.store.widgets.AttributesFilterWidget', ['attributes' => $attributes]) ?>
        </div>
        <br/>
        <div>
            <input type="submit" value="Подобрать" class="btn btn-default"/>
        </div>
    </form>
</div>
