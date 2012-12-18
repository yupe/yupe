<div class="page-header">
    <h1><?php echo Yii::t('yupe', 'Панель управления "{app}"', array('{app}' => CHtml::encode(Yii::app()->name))); ?><br/>
    <small><?php echo Yii::t('yupe', '{nick_name}, добро пожаловать в панель управления Вашим сайтом!',array(
        '{nick_name}' => Yii::app()->user->getState('nick_name')
        )); ?></small></h1>
</div>

<?php foreach ($modules as $module): ?>
<?php if (is_array($module->checkSelf())): ?>
    <?php $error = $module->checkSelf(); ?>
    <div class="alert alert-<?php echo $error['type']; ?>">
        <h4 class="alert-heading">
            <?php echo Yii::t('yupe', 'Модуль "{module} ({id})"', array(
                '{module}' => $module->name,
                '{id}'     => $module->id,
            )); ?>
        </h4>
        <?php echo $error['message'];?>
    </div>
    <?php endif; ?>
<?php endforeach; ?>

<p>
    <?php echo Yii::t('yupe','Вы используете Yii версии'); ?>
    <small class="label label-info" title="<?php echo Yii::getVersion(); ?>"><?php echo Yii::getVersion(); ?></small>,
    <?php echo CHtml::encode(Yii::app()->name); ?>
    <?php echo Yii::t('yupe', 'версии'); ?> <small class="label label-info" title="<?php echo Yii::app()->getModule('yupe')->version; ?>"><?php echo Yii::app()->getModule('yupe')->version; ?></small>,
    <?php echo Yii::t('yupe', 'php версии'); ?>
    <small class="label label-info" title="<?php echo phpversion(); ?>"><?php echo phpversion(); ?></small>
</p>

</br>

<p>
    <?php echo Yii::t('yupe', 'Установлено'); ?>
    <small class="label label-info"><?php echo $mn = count($modules) + count($yiiModules); ?></small>
    <?php echo Yii::t('yupe', 'модуль|модуля|модулей', $mn); ?>
    <small>
        <?php echo Yii::t('yupe', '( дополнительные модули всегда можно поискать на {link} или {order_link} )', array(
            '{link}'       => CHtml::link(Yii::t('yupe', 'официальном сайте'), 'http://yupe.ru/?from=mlist', array('target' => '_blank')),
            '{order_link}' => CHtml::link(Yii::t('yupe', 'заказать их разработку'), 'http://yupe.ru/feedback/contact/?from=mlist', array('target' => '_blank')),
        )); ?>
    </small>
</p>

<?php echo $this->renderPartial('_moduleslist', array('modules' => $modules)); ?>

<?php if (count($yiiModules)): ?>
    <br />
    <div class="page-header">
        <h6><?php echo Yii::t('yupe', 'Yii модули'); ?></h6>
    </div>
    <table  class="table table-striped">
        <thead>
            <tr>
                <th><?php echo Yii::t('yupe', 'id'); ?></th>
                <th><?php echo Yii::t('yupe', 'Название'); ?></th>
                <th><?php echo Yii::t('yupe', 'Описание'); ?></th>
                <th><?php echo Yii::t('yupe', 'Версия'); ?></th>
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