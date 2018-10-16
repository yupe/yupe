<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name">
            <span>
                <?php echo CHtml::hiddenField('ajax', 'ajax') ?>
    <?php echo CHtml::activeLabel($this->model, 'name'); ?>
    <?php echo CHtml::activeTextField(
            $this->model,
            'name',
            ['value' => '{%=file.name%}', 'name' => 'Image[{%=file.name%}][name]', 'class' => 'form-control']
        ) . "\n"; ?>
            </span>
        </td>
        <td class="name">
            <span>
                <?php echo CHtml::activeLabel($this->model, 'alt'); ?>
    <?php echo CHtml::activeTextField(
            $this->model,
            'alt',
            ['value' => '{%=file.name%}', 'name' => 'Image[{%=file.name%}][alt]', 'class' => 'form-control']
        ) . "\n"; ?>
            </span>
        </td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress"><div class="bar progress-bar progress-bar-success progress-bar-striped active" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="fa fa-fw fa-upload"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="fa fa-fw fa-ban"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}




</script>
