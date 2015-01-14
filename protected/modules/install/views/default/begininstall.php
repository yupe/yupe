<?php
/**
 * Отображение для begininstall:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
?>
<h1><?php echo Yii::t('InstallModule.install', 'Installation in progress...'); ?></h1>

<?php $this->widget('install.widgets.GetHelpWidget'); ?>

<div class="alert alert-info">
    <p><?php echo Yii::t(
            'InstallModule.install',
            'On this step Yupe trying to install modules you checked. This process can take several minutes...'
        ); ?></p>
</div>
<div id="msg"></div>
<div class="progress progress-striped active">
    <div class="progress-bar bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
         style="width: 0%">
    </div>
</div>
<small id="modstate"></small>
<?php
$this->widget(
    'bootstrap.widgets.TbPanel',
    [
        'title'       => Yii::t('InstallModule.install', 'Backlog journal'),
        'headerIcon'  => 'fa fa-fw fa-list',
        'content'     => '',
        'id'          => 'log-content',
    ]
); ?>
<script type="text/javascript">
    <?php
    // Выясним, какие модули нам нужно постараться поставить первыми
    $morder = ['user' => 99999, 'yupe' => 99998];

    foreach ($modules as $mid => $m) {
        $dep = $m->getDependencies();
        if (!empty($dep)) {
            foreach ($dep as $d) {
                $morder[$d] = isset($morder[$d]) ? ($morder[$d] + 1) : 1;
            }
        }
    }

    // Отсортируем модули, чтобы по очереди ставились
    uksort(
        $modules,
        function ($a, $b) use ($morder) {
            return ((isset($morder[$a]) ? $morder[$a] : 0) < (isset($morder[$b]) ? $morder[$b] : 0));
        }
    );

    echo "var total=" . count($modules) . ";\n var modules = {\n";
    foreach ($modules as $m) {echo "'" . $m->id . "':{ installed:false, id:\"" . $m->id . "\", description: " . CJSON::encode($m->name) . ", icon:'" . $m->icon . "'},\n";}
    echo "\n};";
    ?>

    function log(msg) {
        $("#log-content").append(msg.replace("\n", "<br/>"));
    }

    var ic = 1;
    function setModuleProgress(installed, message) {
        $('div.bar').css('width', (total ? (installed * 100 / total) : 100) + "%");
        $('#msg').html(message);
        $('small#modstate').text(installed + " / " + total);
    }

    function installNext() {
        var ic = 0;
        $.each(modules, function (i, m) {
            ic++;
            if (!m.installed) {
                setModuleProgress(ic, "<i class='" + m.icon + "'>&nbsp;</i>&nbsp; <?php echo Yii::t('InstallModule.install', 'Installing module'); ?> <b>" + m.description + "</b>");
                $.ajax({
                    url: "<?php echo $this->createUrl('/install/default/moduleinstall') ?>",
                    data: {'name': m.id},
                    dataType: 'json',
                    success: function (data, status) {
                        if (typeof(data.installed) != undefined) {
                            // установить флаги на пришедших модулях
                            modules[m.id].installed = true;
                            if (typeof (data.log) != undefined)
                                log(data.log);
                            setModuleProgress(ic, "<i class='" + m.icon + "'>&nbsp;</i>&nbsp; <?php echo Yii::t('InstallModule.install', 'Module was installed'); ?> <b>" + m.description + "</b>");
                            // проверить, остались ли еще не установленные
                            if (ic < total)
                                installNext();
                            else {
                                $('#modules-modal').modal('show');
                                $('div.buttons').slideDown();
                            }

                        }
                    },
                    error: function (e) {
                        log(e.responseText);
                        $('#modules-fail').modal('show');
                        $('nextButton').hide();
                        $('div.buttons').slideDown();
                    }
                });

                return false;
            }
        });
    }

    $(document).ready(function () {
        setModuleProgress(0, "Начало установки");
        installNext();
    });
</script>
<?php $this->beginWidget('bootstrap.widgets.TbModal', ['id' => 'modules-modal']); ?>
<div class="modal-header">
    <h4>
        <?php echo Yii::t('InstallModule.install', 'Installation completed'); ?>
    </h4>
</div>
<div id="modules-modal-list" class="modal-body row">
    <?php echo Yii::t('InstallModule.install', 'Congratulations, modules which you checked installed successfully!'); ?>
</div>
<div class="modal-footer">
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'label'       => Yii::t('InstallModule.install', 'Look journal'),
            'url'         => '#',
            'htmlOptions' => [
                'data-dismiss' => 'modal',
            ],
        ]
    ); ?>
    <?php echo CHtml::link(
        Yii::t('InstallModule.install', 'Continue >'),
        ['/install/default/createuser'],
        ['class' => 'btn btn-primary nextButton']
    ); ?>
</div>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', ['id' => 'modules-fail']); ?>
<div class="modal-header">
    <h4>
        <?php echo Yii::t('InstallModule.install', 'Ошибка!'); ?>
    </h4>
</div>
<div id="modules-modal-list" class="modal-body row">
    <?php echo Yii::t(
        'InstallModule.install',
        'There is an error occured when installing modules. You can watch errors in backlog journal.'
    ); ?>
</div>
<div class="modal-footer">
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'label'       => Yii::t('InstallModule.install', 'Look journal'),
            'url'         => '#',
            'htmlOptions' => [
                'data-dismiss' => 'modal',
            ],
        ]
    );
    /**
     * @tutorial Здесь не должно быть кнопок продолжить и прочее.
     *           Это модальное окно об ошибке при установке.
     **/
    ?>
</div>
<?php $this->endWidget(); ?>

<div class='buttons' style='display: none'>
    <?php echo CHtml::link(
        Yii::t('InstallModule.install', '< Back'),
        ['/install/default/modulesinstall'],
        ['class' => 'btn btn-default']
    ); ?>
    <?php echo CHtml::link(
        Yii::t('InstallModule.install', 'Continue >'),
        ['/install/default/createuser'],
        ['class' => 'btn btn-primary nextButton']
    ); ?>
</div>
