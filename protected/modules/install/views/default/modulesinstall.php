<?php
/**
 * Отображение для modulesinstall:
 * 
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id'                     => 'modulesinstall-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'inlineErrors'           => true,
    )
);

Yii::app()->clientScript->registerScript(
    'tooltip', "jQuery('body').tooltip({'selector':'[rel=tooltip]'});",
    CClientScript::POS_READY
);


?>

    <?php $this->widget('install.widgets.GetHelpWidget');?>

    <div class="alert alert-block alert-info">
        <p><?php echo Yii::t('InstallModule.install', 'Please check modules you want to be installed.'); ?></p>
        <p><?php echo Yii::t('InstallModule.install', 'Addition modules you can install/activate from control panel.'); ?></p>
    </div>

    <div class="alert alert-block alert-success">
        <?php
        echo Yii::t(
            'InstallModule.install', 'Summary modules: {all}, checked for install: {checked}', array(
                '{all}'     => '<small class="label label-info">' . count($data['modules']) . '</small>',
                '{checked}' => '<small class="label label-info checked-count">0</small>',
            )
        ); ?>
    </div>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButtonGroup', array(
            'type'        => 'info',
            'buttons'     => array(
                array('label' => Yii::t('InstallModule.install', 'Recommended'), 'url' => '#', 'htmlOptions' => array('id' => 'recom-check')),
                array('label' => Yii::t('InstallModule.install', 'Only basic modules'), 'url' => '#', 'htmlOptions' => array('id' => 'basic-check')),
                array('label' => Yii::t('InstallModule.install', 'All'), 'url' => '#', 'htmlOptions' => array('id' => 'all-check')),
            ),
        )
    ); ?>

    <table id="module-list" class="table table-striped table-vmiddle">
        <thead>
        <tr>
            <th></th>
            <th></th>
            <th style="width: 32px;"><?php echo Yii::t('InstallModule.install', 'Version'); ?></th>
            <th style="width: 32px;"></th>
            <th style="width: 150px;"><?php echo Yii::t('InstallModule.install', 'Name'); ?></th>
            <th><?php echo Yii::t('InstallModule.install', 'Description'); ?></th>
            <th><?php echo Yii::t('InstallModule.install', 'Dependencies'); ?></th>
        </tr>
        </thead>
        <tbody>
            <?php
            $post = Yii::app()->getRequest()->getIsPostRequest();
            $modulesSelection = array(
                'all'   => array(),
                'recom' => array(),
                'basic' => array(),
            );
            foreach ($data['modules'] as $module) :
                if(!is_object($module)){
                    continue;
                }
                $modulesSelection['all'][] = '#module_' . $module->getId();
                if ($module->getIsInstallDefault()) {
                    $modulesSelection['recom'][] = '#module_' . $module->getId();
                }
                if ($module->getIsNoDisable()) {
                    $modulesSelection['basic'][] = '#module_' . $module->getId();
                }
            ?>
                <tr>
                    <td>
                        <?php echo CHtml::checkBox('module_' . $module->getId(),
                            ($post && !$module->getIsNoDisable() )
                                ? (isset($_POST['module_' . $module->getId()]) && $_POST['module_' . $module->getId()])
                                : ($module->getIsInstallDefault() ? true : false),
                            $module->getIsNoDisable()
                                ? array('onclick' => 'this.checked=true')
                                : array()
                        ); ?>
                    </td>
                    <td><?php echo ($module->icon ? ("<i class='icon-" . $module->icon . "'>&nbsp;</i> ") : ""); ?></td>
                    <td>
                        <small class='label'> <?php echo $module->version; ?></small>
                    </td>
                    <td>
                        <?php if ($module->isMultiLang()) : ?>
                            <i class="icon-globe" title="<?php echo Yii::t('InstallModule.install', 'Multilanguage module'); ?>"></i>
                        <?php endif; ?>
                    </td>
                    <td>
                        <small style="font-size: 80%;"><?php echo $module->category; ?></small><br />
                        <span><?php echo $module->name; ?></span>
                    </td>
                    <td style="font-size: 80%;">
                        <?php echo $module->description; ?>
                        <br />
                        <small>
                            <b><?php echo Yii::t('InstallModule.install', 'Author:'); ?></b> <?php echo $module->author; ?>
                            (<a href="mailto:<?php echo $module->authorEmail; ?>">
                                <?php echo $module->authorEmail; ?>
                            </a>) 
                            <b><?php echo Yii::t('InstallModule.install', 'Module site:'); ?></b>
                            <?php echo CHtml::link($module->url, $module->url); ?>
                        </small><br />
                    </td>
                    <td class="check-label" style="font-size: 10px;">
                        <?php
                            $tabs = array();

                            if ($module->getId() != 'yupe' && count($module->getDependencies())) {
                                $deps = $module->getDependencies();
                                foreach($deps as &$dep){
                                    $dep = $data['modules'][$dep]->name;
                                }
                                $tabs[] = array(
                                    'label'   => Yii::t('InstallModule.install', 'Depends from'),
                                    'content' => implode(', ', $deps),
                                    'count'   => count($deps),
                                );
                            }
                            if( $module->getId() == 'yupe')
                                $tabs[] = array(
                                    'label'   => Yii::t('InstallModule.install', 'Dependent'),
                                    'content' => Yii::t('InstallModule.install', 'All modules'),
                                    'count'   => Yii::t('InstallModule.install', 'All'),
                                );
                            else
                                if(count($deps = $module->getDependent())) {
                                    foreach($deps as &$dep)
                                        $dep = $data['modules'][$dep]->name;
                                    $tabs[] = array(
                                        'label'   => Yii::t('InstallModule.install', 'Dependent'),
                                        'content' => implode(', ', $deps),
                                        'count'   => count($deps),
                                    );
                                }
                            foreach ($tabs as $t)
                                echo $t['label'] . " " . CHtml::tag('span', array(
                                    'class' => 'label label-info',
                                    'rel'   => 'tooltip',
                                    'title' => $t['content'],
                                ), CHtml::tag('small', array(), $t['count'])).'</br>';
                            ?>
                        <br />

                        <?php echo $module->getIsNoDisable()
                            ? '<span class="label label-warning" style="font-size: 10px;">' . Yii::t('InstallModule.install', 'System module. (Can\'t disable)') . '</span>'
                            : ''
                        ?>
                        <span class="label label-warning dependents" style="display: none; font-size: 10px;">
                            <?php echo Yii::t('InstallModule.install', 'Disable depends modules,<br/>which you would not like to install.'); ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    $dependencies              = $module->getDependenciesAll();
    $keyDependencies           = implode(', #module_', array_keys($dependencies));

    $jsArray                   = CJavaScript::encode($dependencies);
    $jsArrayRevert             = CJavaScript::encode($module->getDependents());
    $jsArrayNoDisable          = CJavaScript::encode($module->getModulesNoDisable());

    $modulesSelection['recom'] = implode(', ', $modulesSelection['recom']);
    $modulesSelection['all']   = implode(', ', $modulesSelection['all']);
    $modulesSelection['basic'] = implode(', ', $modulesSelection['basic']);

    $js = <<<EOF
        var array          = {$jsArray},
            arrayRevert    = {$jsArrayRevert},
            arrayNoDisable = {$jsArrayNoDisable};

        function checkedCount() {
            $('.checked-count').text($('#module-list').find("input:checked").length);
        }
        checkedCount();

        $.each(arrayRevert, function(i, val) {
            if ($.inArray(i, arrayNoDisable) == -1)
            {
                $.each(val, function(iRevert, valRevert) {
                    if ($('#module_' + valRevert).attr('checked')) {
                        $('#module_' + i).attr('checked', true).attr('onclick', "this.checked=true");
                        $('#module_' + i).parent().siblings('.check-label').find('.dependents').show();
                        return false;
                    }
                });
            }
        });

        $(document).on('change', '#module_{$keyDependencies}', function() {
            checkedCount();
            var id = $(this).attr('id').replace('module_', '');
            if ($(this).attr('checked')) {
                $.each(array[id], function(i, val) {
                    $('#module_' + val).attr('checked', true).attr('onclick', "this.checked=true");
                });
            } else {
                $.each(array[id], function(i, val) {
                    if ($.inArray(val, arrayNoDisable) == -1) {
                        var all = false;
                        $.each(arrayRevert[val], function(iRevert, valRevert) {
                            if ($('#module_' + valRevert).attr('checked')) {
                                all = true;
                                return false;
                            }
                        });
                        if (!all)
                            $('#module_' + val).attr('onclick', '');
                    }
                });
            }
        });

        $(document).on('click', '#recom-check, #all-check, #basic-check', function() {
            $("{$modulesSelection['all']}").prop('checked', false);
            switch ($(this).attr('id')) {
                case 'recom-check':
                    $("{$modulesSelection['recom']}").prop('checked', true);
                    break;
                case 'all-check':
                    $("{$modulesSelection['all']}").prop('checked', true);
                    break;
                case 'basic-check':
                    $("{$modulesSelection['basic']}").prop('checked', true);
                    break;
            }
            checkedCount();
        });
        $(document).on('show', '#modules-modal', function() {
            $('#modules-modal-list').find("i").each(function() {
                $(this).removeClass("icon-ok").addClass("icon-minus");
            });
            $('#module-list').find("input:checked").each(function() {
                var id = $(this).attr('id').replace('module_', 'modal_');
                $('#' + id + ' i').removeClass("icon-minus").addClass("icon-ok");
            });
        });
        $(document).on('click', '#modal-confirm', function() {
            $('#modulesinstall-form').submit();
        });
EOF;
    Yii::app()->clientScript->registerScript(__CLASS__ . '#dependencies', $js, CClientScript::POS_END);
    ?>

    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modules-modal')); ?>
        <div class="modal-header">
            <h4>
                <?php echo Yii::t('InstallModule.install', 'Will be installed <small class="label label-info checked-count">0</small> modules. Do you want to continue?'); ?>
            </h4>
        </div>
        <div id="modules-modal-list" class="modal-body row">
            <div class="span3">
                <?php
                    $moduleCountTr = ceil(count($data['modules']) / 2);
                    $i = 0;
                    foreach ($data['modules'] as $module) {
                        if ($moduleCountTr == $i) {
                            echo '</div><div class="span3">';
                        }
                        echo '<div id="modal_' . $module->getId() . '"><i class="icon-minus"> </i> ' . $module->name . '</div>';
                        $i++;
                    }
                ?>
            </div>
        </div>
        <div class="modal-footer">
            <?php
            $this->widget(
                'bootstrap.widgets.TbButton', array(
                    'label'       => Yii::t('InstallModule.install', 'Cancel'),
                    'url'         => '#',
                    'htmlOptions' => array('data-dismiss' => 'modal'),
                )
            ); ?>
            <?php
            $this->widget(
                'bootstrap.widgets.TbButton', array(
                    'buttonType'  => 'submit',
                    'type'        => 'primary',
                    'label'       => Yii::t('InstallModule.install', 'Continue >'),
                    'htmlOptions' => array(
                        'data-dismiss' => 'modal',
                        'id'           => 'modal-confirm'
                    ),
                )
            ); ?>
        </div>
    <?php $this->endWidget(); ?>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'label' => Yii::t('InstallModule.install', '< Back'),
            'url'   => array('/install/default/dbsettings'),
        )
    ); ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'type'       => 'primary',
            'label'      => Yii::t('InstallModule.install', 'Continue >'),
            'htmlOptions' => array(
                'data-toggle' => 'modal',
                'data-target' => '#modules-modal',
            ),
        )
    ); ?>

<?php $this->endWidget(); ?>
