<div id='<?php echo $this->divId;?>' class='flash'>
    <?php if (Yii::app()->user->hasFlash($this->warning)): ?>
    <div class='flash-notice'>
        <b><?php echo Yii::app()->user->getFlash($this->warning);?></b>
    </div>
    <?php endif;?>

    <?php if (Yii::app()->user->hasFlash($this->error)): ?>
    <div class='flash-error'>
        <b><?php echo Yii::app()->user->getFlash($this->error);?></b>
    </div>
    <?php endif;?>

    <?php if (Yii::app()->user->hasFlash($this->notice)): ?>
    <div class='flash-success'>
        <b><?php echo Yii::app()->user->getFlash($this->notice);?></b>
    </div>
    <?php endif;?>
</div>  