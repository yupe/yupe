<?php

$this->breadcrumbs = [
    Yii::t('YupeModule.yupe', 'Yupe!') => ['/yupe/backend/index'],
    Yii::t('YupeModule.yupe', 'Modules') => ['/yupe/backend/settings'],
    $this->getModule()->name,
];
?>

<h1>
    <?php echo Yii::t('YupeModule.yupe', 'Module settings'); ?> "<?php echo CHtml::encode($this->getModule()->name); ?>"
    <small><?php echo Yii::t('YupeModule.yupe', 'version'); ?> <?php echo CHtml::encode($this->getModule()->version); ?></small>
</h1>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => Yii::t('SitemapModule.sitemap', 'Regenerate sitemap'),
        'id' => 'regenerate-site-map'
    ]
); ?>

<h3>
    <?= Yii::t('SitemapModule.sitemap', 'Pages') ?>
</h3>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#add-toggle">
        <i class="glyphicon glyphicon-plus">&nbsp;</i>
        <?php echo Yii::t('SitemapModule.sitemap', 'Add'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="add-toggle" class="collapse out add-form">
    <?php
    $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        [
            'id' => 'sitemap-page-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'action' => ['/sitemap/sitemapBackend/createPage'],
            'type' => 'vertical',
            'htmlOptions' => ['class' => 'well'],
        ]
    ); ?>
    <div class="alert alert-info">
        <?php echo Yii::t('SitemapModule.sitemap', 'Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('SitemapModule.sitemap', 'are required.'); ?>
    </div>

    <?php echo $form->errorSummary($sitemapPage); ?>

    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($sitemapPage, 'url'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <?php echo $form->dropDownListGroup(
                $sitemapPage,
                'changefreq',
                [
                    'widgetOptions' => [
                        'data' => SitemapHelper::getChangeFreqList(),
                    ],
                ]
            ); ?>
        </div>
        <div class="col-sm-2">
            <?php echo $form->textFieldGroup($sitemapPage, 'priority'); ?>
        </div>
        <div class="col-sm-2">
            <?php echo $form->dropDownListGroup(
                $sitemapPage,
                'status',
                [
                    'widgetOptions' => [
                        'data' => $sitemapPage->getStatusList(),
                    ],
                ]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <?php $this->widget(
                'bootstrap.widgets.TbButton',
                [
                    'buttonType' => 'submit',
                    'context' => 'primary',
                    'label' => Yii::t('SitemapModule.sitemap', 'Add'),
                ]
            ); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'page-grid',
        'dataProvider' => $sitemapPage->search(),
        'filter' => $sitemapPage,
        'sortField' => 'order',
        'template' => "{multiaction}\n{items}\n{pager}",
        'actionsButtons' => false,
        'columns' => [
            [
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name' => 'url',
                'editable' => [
                    'url' => $this->createUrl('/sitemap/sitemapBackend/inlinePage'),
                    'mode' => 'inline',
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'filter' => CHtml::activeTextField($sitemapPage, 'url', ['class' => 'form-control']),
            ],
            [
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name' => 'changefreq',
                'editable' => [
                    'url' => $this->createUrl('/sitemap/sitemapBackend/inlinePage'),
                    'mode' => 'inline',
                    'type' => 'select',
                    'source' => SitemapHelper::getChangeFreqList(),
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'filter' => CHtml::activeDropDownList($sitemapPage, 'changefreq', SitemapHelper::getChangeFreqList(), ['class' => 'form-control', 'empty' => '']),
                'htmlOptions' => ['style' => 'width: 250px;'],
            ],
            [
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name' => 'priority',
                'editable' => [
                    'url' => $this->createUrl('/sitemap/sitemapBackend/inlinePage'),
                    'mode' => 'inline',
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'filter' => CHtml::activeTextField($sitemapPage, 'priority', ['class' => 'form-control']),
                'htmlOptions' => ['style' => 'width: 250px;'],
            ],
            [
                'class' => 'yupe\widgets\EditableStatusColumn',
                'name' => 'status',
                'url' => $this->createUrl('/sitemap/sitemapBackend/inlinePage'),
                'source' => $sitemapPage->getStatusList(),
                'options' => [
                    SitemapPage::STATUS_ACTIVE => ['class' => 'label-success'],
                    SitemapPage::STATUS_NOT_ACTIVE => ['class' => 'label-default'],
                ],
                'htmlOptions' => ['style' => 'width: 150px;'],
            ],
        ],
    ]
);
?>

<script type="text/javascript">
    $('#regenerate-site-map').on('click', function(event){
        event.preventDefault();
        $.post('<?= Yii::app()->createUrl('/sitemap/sitemapBackend/regenerate');?>', {
            'do' : true,
            '<?= Yii::app()->getRequest()->csrfTokenName?>' : '<?= Yii::app()->getRequest()->csrfToken?>'
        }, function(response){
                 window.location.reload();
        }, 'json')
    });
</script>
