<div class="page-header">
    <h1><?php echo Yii::t('YupeModule.yupe', 'Панель управления "{app}"', array('{app}' => CHtml::encode(Yii::t('YupeModule.yupe', Yii::app()->name)))); ?><br/>
    <small><?php echo Yii::t('YupeModule.yupe', '{nick_name}, добро пожаловать в панель управления Вашим сайтом!',array(
        '{nick_name}' => Yii::app()->user->getState('nick_name')
        )); ?></small></h1>
</div>

<?php foreach ($modules as $module): ?>
    <?php if ($module->isActive): ?>
        <?php $messages = $module->checkSelf(); ?>
        <?php if (is_array($messages)): ?>
            <?php foreach ($messages as $key => $value): ?>
                <?php if (!is_array($value)) continue; ?>
                <div class="accordion" id="accordion<?php echo $module->id; ?>">
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a  class="accordion-toggle"
                                data-toggle="collapse"
                                data-parent="#accordion<?php echo $module->id; ?>"
                                href="#collapse<?php echo $module->id; ?>"
                            >
                                <?php echo Yii::t('YupeModule.yupe', 'Модуль {icon} "{module}", сообщений: {count}', array(
                                    '{icon}'   => $module->icon ? "<i class='icon-" . $module->icon . "'>&nbsp;</i> " : "",
                                    '{module}' => $module->getName(),
                                    '{count}'  => '<small class="label label-warning">' . count($value) . '</small>',
                                )); ?>
                            </a>
                        </div>
                        <div id="collapse<?php echo $module->id; ?>" class="accordion-body collapse">
                        <?php foreach ($value as $error): ?>
                            <div class="accordion-inner">
                                <div class="alert alert-<?php echo $error['type']; ?>">
                                    <h4 class="alert-heading">
                                        <?php echo Yii::t('YupeModule.yupe', 'Модуль "{module} ({id})"', array(
                                            '{module}' => $module->name,
                                            '{id}'     => $module->id,
                                        )); ?>
                                    </h4>
                                    <?php echo $error['message']; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; ?>

<br/>

<div class="alert">
    <p>
        <?php echo Yii::t('YupeModule.yupe','Вы используете Yii версии'); ?>
        <small class="label label-info" title="<?php echo Yii::getVersion(); ?>"><?php echo Yii::getVersion(); ?></small>,
        <?php echo CHtml::encode(Yii::app()->name); ?>
        <?php echo Yii::t('YupeModule.yupe', 'версии'); ?> <small class="label label-info" title="<?php echo Yii::app()->getModule('yupe')->version; ?>"><?php echo Yii::app()->getModule('yupe')->version; ?></small>,
        <?php echo Yii::t('YupeModule.yupe', 'php версии'); ?>
        <small class="label label-info" title="<?php echo phpversion(); ?>"><?php echo phpversion(); ?></small>
    </p>
    </br>
    <p>
        <?php
            $yiiCount    = count($yiiModules);
            $yupeCount   = count($modules);
            $allCount    = $yupeCount + $yiiCount;
            $enableCount = 0;
            foreach ($modules as $module) {
                if ($module->isActive || $module->isNoDisable)
                    $enableCount++;
            }
        ?>
        <?php echo Yii::t('YupeModule.yupe', 'Установлено'); ?>
        <small class="label label-info"><?php echo $allCount; ?></small>
        <?php echo Yii::t('YupeModule.yupe', 'модуль|модуля|модулей', $allCount); ?>
        (<?php echo Yii::t('YupeModule.yupe', 'включено'); ?>
        <small class="label label-info"><?php echo $enableCount + $yiiCount; ?></small>
        <?php echo Yii::t('YupeModule.yupe', 'модуль|модуля|модулей', $enableCount + $yiiCount); ?>,
        <?php echo Yii::t('YupeModule.yupe', 'выключено'); ?>
        <small class="label label-info"><?php echo $yupeCount - $enableCount; ?></small>
        <?php echo Yii::t('YupeModule.yupe', 'модуль|модуля|модулей', $yupeCount - $enableCount); ?>)
        <br>
        <small>
            <?php echo Yii::t('YupeModule.yupe', '( дополнительные модули всегда можно поискать на {link} или {order_link} )', array(
                '{link}'       => CHtml::link(Yii::t('YupeModule.yupe', 'официальном сайте'), 'http://yupe.ru/?from=mlist', array('target' => '_blank')),
                '{order_link}' => CHtml::link(Yii::t('YupeModule.yupe', 'заказать их разработку'), 'http://yupe.ru/feedback/index/?from=mlist', array('target' => '_blank')),
            )); ?>
        </small>
    </p>
</div>

<?php echo $this->renderPartial('_moduleslist', array('modules' => $modules)); ?>

<?php if (count($yiiModules)): ?>
    <br />
    <div class="page-header">
        <h6><?php echo Yii::t('YupeModule.yupe', 'Yii модули'); ?></h6>
    </div>
    <table  class="table table-striped">
        <thead>
            <tr>
                <th><?php echo Yii::t('YupeModule.yupe', 'id'); ?></th>
                <th><?php echo Yii::t('YupeModule.yupe', 'Название'); ?></th>
                <th><?php echo Yii::t('YupeModule.yupe', 'Описание'); ?></th>
                <th><?php echo Yii::t('YupeModule.yupe', 'Версия'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($yiiModules as $module): ?>
                <tr>
                    <td><?php echo $module->id; ?></td>
                    <td><?php echo $module->name; ?></td>
                    <td><?php echo $module->description; ?></td>
                    <td><?php echo $module->version; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php $this->menu = $modulesNavigation; ?>