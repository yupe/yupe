<?=  "<?php\n"; ?>
/**
 * Файл настроек для модуля <?=  $this->moduleID."\n"; ?>
 *
 * @author yupe team <team@yupe.ru>
 * @link https://yupe.ru
 * @copyright 2009-<?= date('Y'); ?> amyLabs && Yupe! team
 * @package yupe.modules.<?=  $this->moduleID; ?>.install
 * @since 0.1
 *
 */
return [
    'module'    => [
        'class' => 'application.modules.<?=  $this->moduleID; ?>.<?=  $this->moduleClass; ?>',
    ],
    'import'    => [],
    'component' => [],
    'rules'     => [
        '/<?=  $this->moduleID; ?>' => '<?=  $this->moduleID; ?>/<?=  $this->moduleID; ?>/index',
    ],
];