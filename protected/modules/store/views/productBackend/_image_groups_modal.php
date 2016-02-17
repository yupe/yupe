<div class="modal fade" id="image-groups" tabindex="-1" role="dialog" aria-labelledby="image-groups-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="image-groups-label"><?= Yii::t("StoreModule.store", "Image groups"); ?></h4>
            </div>
            <div class="modal-body">
                <?php
                $form = $this->beginWidget(
                    '\yupe\widgets\ActiveForm',
                    [
                        'id' => 'image-group-form',
                        'action' => Yii::app()->createUrl('/store/groupBackend/create'),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'type' => 'vertical',
                        'clientOptions' => [
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:groupsSendForm'
                        ],
                    ]
                ); ?>
                <div class="row">
                    <div class="col-xs-9">
                        <?= $form->textFieldGroup($imageGroup, 'name', [
                            'labelOptions' => ['class' => 'hidden']
                        ]); ?>
                    </div>
                    <div class="col-xs-3">
                        <button type="submit" class="btn btn-success">
                            <?= Yii::t("StoreModule.store", "Add"); ?>
                        </button>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?php $this->renderPartial('_image_groups_grid', ['imageGroup' => $imageGroup]) ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <?= Yii::t("StoreModule.store", "Close"); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function groupsSendForm(form, data, hasError) {
        if (hasError) return false;

        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form.serialize(),
            success: function (response) {
                if (response.result) {
                    document.getElementById("image-group-form").reset();
                    $.fn.yiiGridView.update('group-grid');
                }
            },
            error: function (response) {
                console.log(response);
            }
        });
    }

    function updateGroupDropdown(){
        $.ajax({
            url: '<?= Yii::app()->createUrl('/store/groupBackend/data'); ?>',
            success: function (response) {
                if (!response.result) {
                    return false;
                }

                var options = '<option><?= Yii::t('StoreModule.store', '--choose--') ?></option>';

                $.each(response.data, function (i, item) {
                    options += '<option value="' + i + '">' + item + '</option>';
                });

                $('.image-group-dropdown').each(function(){
                    var selected = $(this).val();

                    $(this).html(options);

                    if (selected && $(this).find('option[value="' + selected + '"]').val() !== undefined) {
                        $(this).val(selected);
                    }
                });
            }
        });
    }
</script>