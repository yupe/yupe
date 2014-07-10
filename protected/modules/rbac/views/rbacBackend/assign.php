<script type="text/javascript">
    $(document).ready(function () {
        $('input.root').click(function () {
            var data = $(this).is(':checked') ? true : false;
            $(this).closest('li').find('input').attr('checked', data);
        });
    });
</script>

<?php
$this->breadcrumbs = array(
    'Действия' => array('index'),
    'Назначение прав',
);
?>

<h3>Назначение прав пользователю "<?php echo $model->getFullName(); ?>"</h3>

<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'auth-item-assign-form',
        'enableAjaxValidation' => false,
    )
);

?>

<?php $this->widget('CTreeView', array('data' => $tree)); ?>

<div class="form-actions">
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => 'Сохранить',
        )
    );
    ?>
</div>

<?php $this->endWidget(); ?>