<?php

class ECKEditorWidget extends CInputWidget
{
    public $options;

    public function run()
    {
        parent::run();

        $this->widget(
            'bootstrap.widgets.TbCKEditor',
            array(
                'model' => $this->model,
                'attribute' => $this->attribute,
                'editorOptions' => $this->options
            )
        );
    }
}