<div class="portlet">
    <div class="portlet-decoration">
        <div class="portlet-title"><b>Юпи меню</b></div>
    </div>
    <div class="portlet-content">
        <?php
        $this->widget('zii.widget.CMenu', array(
            'items' => array(
                array('label' => 'СКАЧАТЬ ЮПИ', 'url' => 'https://github.com/yupe/yupe/tarball/master', 'active' => true),
                array('label' => 'Отослать ошибку', 'url' => 'https://github.com/yupe/yupe/issues/new'),
                array('label' => 'Юпи в твиттере', 'url' => 'https://twitter.com/YupeCms'),
            ),
        ));
        ?>
    </div>
</div>