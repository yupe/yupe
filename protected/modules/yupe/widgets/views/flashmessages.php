<div id="<?php echo $this->divId; ?>" class="flash">
    <?php if (Yii::app()->user->hasFlash($this->warning)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert">×</a>
        <b><?php echo Yii::app()->user->getFlash($this->warning); ?></b>
    </div>
    <?php endif; ?>

    <?php if (Yii::app()->user->hasFlash($this->error)): ?>
    <div class="alert alert-error">
        <a class="close" data-dismiss="alert">×</a>
        <b><?php echo Yii::app()->user->getFlash($this->error); ?></b>
    </div>
    <?php endif; ?>

    <?php if (Yii::app()->user->hasFlash($this->notice)): ?>
    <div class="alert alert-success">
        <a class="close" data-dismiss="alert">×</a>
        <b><?php echo Yii::app()->user->getFlash($this->notice); ?></b>
    </div>
    <?php endif; ?>
</div>
