<?=  "<?php\n"; ?>
/**
* Отображение для <?=  $this->moduleID; ?>Backend/index
*
* @category YupeView
* @package  yupe
* @author   Yupe Team <team@yupe.ru>
* @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
* @link     https://yupe.ru
**/
$this->breadcrumbs = [
    Yii::t('<?=  $this->moduleClass; ?>.<?=  $this->moduleID; ?>', '<?=  $this->moduleID; ?>') => ['/<?=  $this->moduleID; ?>/<?=  $this->moduleID; ?>Backend/index'],
    Yii::t('<?=  $this->moduleClass; ?>.<?=  $this->moduleID; ?>', 'Index'),
];

$this->pageTitle = Yii::t('<?=  $this->moduleClass; ?>.<?=  $this->moduleID; ?>', '<?=  $this->moduleID; ?> - index');

$this->menu = $this->getModule()->getNavigation();
?>

<div class="page-header">
    <h1>
        <?=  "<?php"; ?> echo Yii::t('<?=  $this->moduleClass; ?>.<?=  $this->moduleID; ?>', '<?=  $this->moduleID; ?>'); ?>
        <small><?=  "<?php"; ?> echo Yii::t('<?=  $this->moduleClass; ?>.<?=  $this->moduleID; ?>', 'Index'); ?></small>
    </h1>
</div>