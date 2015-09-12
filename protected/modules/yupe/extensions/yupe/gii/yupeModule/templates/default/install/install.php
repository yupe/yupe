<?php echo "<?php\n"; ?>
/**
 * Файл настроек для модуля <?php echo $this->moduleID."\n"; ?>
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-<?= date('Y'); ?> amyLabs && Yupe! team
 * @package yupe.modules.<?php echo $this->moduleID; ?>.install
 * @since 0.1
 *
 */
return [
    'module'    => [
        'class' => 'application.modules.<?php echo $this->moduleID; ?>.<?php echo $this->moduleClass; ?>',
    ],
    'import'    => [],
    'component' => [],
    'rules'     => [
        '/<?php echo $this->moduleID; ?>' => '<?php echo $this->moduleID; ?>/<?php echo $this->moduleID; ?>/index',
    ],
];