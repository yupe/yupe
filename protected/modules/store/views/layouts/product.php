<?php
/**
 * @var $this ProductBackendController
 * @var $content string
 */
$cssPath = Yii::getPathOfAlias($this->module->assetsPath) . '/css/store-backend.css';
Yii::app()->getClientScript()->registerCssFile(Yii::app()->getAssetManager()->publish($cssPath));

$this->menu = array_merge([
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Products administration'), 'url' => ['/store/productBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Add a product'), 'url' => ['/store/productBackend/create']],
], $this->menu);
?>

<?php $this->beginContent($this->yupe->getBackendLayoutAlias('column2')); ?>
<?php echo $content; ?>
<?php $this->endContent(); ?>
