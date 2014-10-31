<?php
/**
 * The file upload form used as target for the file upload widget
 *
 * @var TbFileUpload $this
 * @var array $htmlOptions
 */
?>
<?php echo CHtml::beginForm($this->url, 'post', $this->htmlOptions); ?>
<div class="fileupload-buttonbar row">
    <div class="col-sm-7">
        <!-- The fileinput-button span is used to style the file input field as button -->
		<span class="btn btn-success fileinput-button"> <i
                class="fa fa-fw fa-plus"></i> <span><?php echo Yii::t(
                    'GalleryModule.gallery',
                    'Add...'
                ); ?></span>
            <?php
            if ($this->hasModel()) :
                echo CHtml::activeFileField($this->model, $this->attribute, $htmlOptions) . "\n";
            else :
                echo CHtml::fileField($name, $this->value, $htmlOptions) . "\n";
            endif;
            ?>
		</span>
        <button type="submit" class="btn btn-primary start">
            <i class="fa fa-fw fa-upload"></i>
            <span><?php echo Yii::t('GalleryModule.gallery', 'Start uploading'); ?></span>
        </button>
        <button type="reset" class="btn btn-warning cancel">
            <i class="fa fa-fw fa-ban"></i>
            <span><?php echo Yii::t('GalleryModule.gallery', 'Cancel uploading'); ?></span>
        </button>
        <button type="button" class="btn btn-danger delete">
            <i class="fa fa-fw fa-trash-o"></i>
            <span><?php echo Yii::t('GalleryModule.gallery', 'Remove'); ?></span>
        </button>
        <input type="checkbox" class="toggle">
    </div>
    <div class="col-sm-5 fileupload-progress fade">
        <!-- The global progress bar -->
        <div class="progress">
            <div class="bar progress-bar progress-bar-success progress-bar-striped active" style="width:0%;"></div>
        </div>
        <!-- The extended global progress information -->
        <div class="progress-extended">&nbsp;</div>
    </div>
</div>
<!-- The loading indicator is shown during image processing -->
<div class="fileupload-loading"></div>
<br>
<div class="row">
    <div class="col-sm-12">
        <div class="dragndrop"></div>
        <table class="table table-striped">
            <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
        </table>
    </div>
</div>
<?php echo CHtml::endForm(); ?>
