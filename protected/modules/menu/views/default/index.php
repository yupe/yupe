<?php
    $this->breadcrumbs = array(
        $this->module->id,
    );
?>
<h1><?=$this->uniqueId.'/'.$this->action->id?></h1>

<p>
    This is the view content for action "<?=$this->action->id?>".
    The action belongs to the controller "<?=get_class($this)?>"
    in the "<?=$this->module->id?>" module.
</p>
<p>
    You may customize this page by editing <tt><?=__FILE__?></tt>
</p>