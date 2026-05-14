<?=  "<?php\n"; ?>
/**
* Отображение для <?=  $this->moduleID; ?>/index
*
* @category YupeView
* @package  yupe
* @author   Yupe Team <support@yupe.ru>
* @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
* @link     https://yupe.ru
**/
$this->pageTitle = Yii::t('<?=  $this->moduleClass; ?>.<?=  $this->moduleID; ?>', '<?=  $this->moduleID; ?>');
$this->description = Yii::t('<?=  $this->moduleClass; ?>.<?=  $this->moduleID; ?>', '<?=  $this->moduleID; ?>');
$this->keywords = Yii::t('<?=  $this->moduleClass; ?>.<?=  $this->moduleID; ?>', '<?=  $this->moduleID; ?>');

$this->breadcrumbs = [Yii::t('<?=  $this->moduleClass; ?>.<?=  $this->moduleID; ?>', '<?=  $this->moduleID; ?>')];
?>

<h1>
    <small>
        <?=  "<?php"; ?> echo Yii::t('<?=  $this->moduleClass; ?>.<?=  $this->moduleID; ?>', '<?=  $this->moduleID; ?>'); ?>
    </small>
</h1>