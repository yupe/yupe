<?php
/**
 * Отображение для begininstall:
 *
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
?>
<h1><?php echo Yii::t('InstallModule.install', 'Идет установка модулей...');?></h1>
<div class="alert alert-block alert-info">
    <p><?php echo Yii::t('InstallModule.install', 'На данном этапе Юпи! постарается установить выбранные вами модули. Установка может занять некоторое время...');?></p>
</div>
<div id="msg"></div>
<div class="progress progress-striped active">
    <div class="bar" style="width: 0%;"></div>
</div>
<small id="modstate"></small>
<?php
$this->widget(
    'bootstrap.widgets.TbBox', array(
        'title'       => Yii::t('InstallModule.install', 'Журнал установки'),
        'headerIcon'  => 'icon-list',
        'content'     => '',
        'id'          => 'log-content',
        'htmlOptions' => array('style' => 'margin-top: 20px; font-size: 10px; line-height: 12px;'),
    )
); ?>
<script type="text/javascript">
<?php
// Выясним, какие модули нам нужно постараться поставить первыми
$morder = array('yupe' => 99999, 'user' => 99998);

foreach ($modules as $mid => $m) {
    $dep = $m->getDependencies();
    if (!empty($dep)) {
        foreach ($dep as $d)
            $morder[$d] = isset($morder[$d]) ? ($morder[$d] + 1) : 1;
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
foreach ($modules as $m)
    echo "'" . $m->id . "':{ installed:false, id:\"" . $m->id . "\", description: " . CJSON::encode($m->name) . ", icon:'" . $m->icon . "'},\n";
echo "\n};";
?>

    function log(msg)
    {
        $("#log-content").append(msg.replace("\n", "<br/>"));
    }

    var ic = 1;
    function setModuleProgress(installed, message)
    {
        $('div.bar').css('width', (total ? (installed * 100 / total) : 100) + "%");
        $('#msg').html(message);
        $('small#modstate').text(installed + " / " + total);
    }

    function installNext()
    {
        var ic = 0;
        $.each(modules, function(i,m) {
            ic++;
            if (!m.installed) {
                setModuleProgress(ic, "<i class='icon-" + m.icon + "'>&nbsp;</i>&nbsp; <?php echo Yii::t('InstallModule.install', 'Устанавливаем модуль'); ?> <b>" + m.description + "</b>");
                $.ajax({
                    url:"<?php echo $this->createUrl('/install/default/moduleinstall') ?>",
                    data: { 'name':m.id},
                    dataType: 'json',
                    success: function(data,status) {
                        if (typeof(data.installed) != undefined) {
                            // установить флаги на пришедших модулях
                            modules[m.id].installed = true;
                            if (typeof (data.log) != undefined)
                                log(data.log);
                            setModuleProgress(ic, "<i class='icon-" + m.icon + "'>&nbsp;</i>&nbsp; <?php echo Yii::t('InstallModule.install', 'Установлен модуль'); ?> <b>" + m.description + "</b>");
                            // проверить, остались ли еще не установленные
                            if (ic<total)
                                installNext();
                            else {
                                $('#modules-modal').modal('show');
                                $('div.buttons').slideDown();
                            }

                        }
                    },
                    error: function(e) {
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

    $(document).ready(function() {
        setModuleProgress(0, "Начало установки");
        installNext();
    });
</script>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modules-modal')); ?>
    <div class="modal-header">
        <h4>
            <?php echo Yii::t('InstallModule.install', 'Установка завершена'); ?>
        </h4>
    </div>
    <div id="modules-modal-list" class="modal-body row">
        <?php echo Yii::t('InstallModule.install', 'Поздравляем, установка выбранных вами модулей завершена.<br/>Вы можете ознакомиться с журналом или продолжить установку.'); ?>
    </div>
    <div class="modal-footer">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton', array(
                'label'       => Yii::t('InstallModule.install', 'Смотреть журнал'),
                'url'         => '#',
                'htmlOptions' => array(
                    'data-dismiss' => 'modal',
                ),
            )
        ); ?>
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton', array(
                'type'  => 'primary',
                'htmlOptions' => array(
                    'class' => 'nextButton',
                ),
                'label' => Yii::t('InstallModule.install', 'Продолжить >'),
                'url'   => array('/install/default/createuser')
            )
        ); ?>
    </div>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modules-fail')); ?>
    <div class="modal-header">
        <h4>
            <?php echo Yii::t('InstallModule.install', 'Ошибка!'); ?>
        </h4>
    </div>
    <div id="modules-modal-list" class="modal-body row">
            <?php echo Yii::t('InstallModule.install', 'Во время установки выбранных Вами модулей произошла ошибка. Вы можете ознакомиться с журналом.'); ?>
    </div>
    <div class="modal-footer">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton', array(
                'label'       => Yii::t('InstallModule.install', 'Смотреть журнал'),
                'url'         => '#',
                'htmlOptions' => array(
                    'data-dismiss' => 'modal',
                ),
            )
        );
        /**
         * @tutorial Здесь не должно быть кнопок продолжить и прочее.
         *           Это модальное окно об ошибке при установке.
         **/
        ?>
    </div>
<?php $this->endWidget(); ?>

<div class='row-fluid buttons' style='display: none'>
<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
        'htmlOptions' => array(
            'class'       => 'prevButton',
        ),
        'label'       => Yii::t('InstallModule.install', '< Назад'),
        'url'         => array('/install/default/modulesinstall'),
    )
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton', array(
        'type'  => 'primary',
        'htmlOptions' => array(
            'class' => 'nextButton',
        ),
        'label' => Yii::t('InstallModule.install', 'Продолжить >'),
        'url'   => array('/install/default/createuser')
    )
); ?>
</div>
