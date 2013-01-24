<?php
    $this->breadcrumbs = array(
        $this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType()),
        Yii::t('SearchModule.search', 'Поиск'),
    );

    $this->pageTitle = Yii::t('SearchModule.search', 'Управление поиском');

    $this->menu = array(
        array('label' => Yii::t('SearchModule.search', 'Поиск'), 'items' => array(   
            array('icon' => 'list-alt', 'label' => Yii::t('SearchModule.search', 'Управление поиском'), 'url' => array('/search/defaultAdmin/index')),
        ))
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('SearchModule.search', 'Поиск'); ?>
        <small><?php echo Yii::t('SearchModule.search', 'управление'); ?></small>
    </h1>
</div>
<h2>В разработке</h2>