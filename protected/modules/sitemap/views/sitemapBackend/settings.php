<?php

$this->breadcrumbs = [
    Yii::t('YupeModule.yupe', 'Yupe!') => ['/yupe/backend/index'],
    Yii::t('YupeModule.yupe', 'Modules') => ['/yupe/backend/settings'],
    $this->getModule()->name,
];
?>

<h1>
    <?= Yii::t('YupeModule.yupe', 'Module settings'); ?> "<?= CHtml::encode($this->getModule()->name); ?>"
    <small><?= Yii::t('YupeModule.yupe', 'version'); ?> <?= CHtml::encode($this->getModule()->version); ?></small>
</h1>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => Yii::t('SitemapModule.sitemap', 'Regenerate sitemap'),
        'id' => 'regenerate-site-map',
    ]
); ?>

<h3>
    <?= Yii::t('SitemapModule.sitemap', 'Pages') ?>
</h3>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#add-toggle">
        <i class="glyphicon glyphicon-plus">&nbsp;</i>
        <?= Yii::t('SitemapModule.sitemap', 'Add'); ?>
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
        <?= Yii::t('SitemapModule.sitemap', 'Fields with'); ?>
        <span class="required">*</span>
        <?= Yii::t('SitemapModule.sitemap', 'are required.'); ?>
    </div>

    <?= $form->errorSummary($page); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->textFieldGroup($page, 'url'); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->textFieldGroup($page, 'priority'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->dropDownListGroup(
                $page,
                'changefreq',
                [
                    'widgetOptions' => [
                        'data' => SitemapHelper::getChangeFreqList(),
                    ],
                ]
            ); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->dropDownListGroup(
                $page,
                'status',
                [
                    'widgetOptions' => [
                        'data' => $page->getStatusList(),
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
        'dataProvider' => $pages,
        'filter' => $pages,
        'sortField' => 'order',
        'actionsButtons' => false,
        'columns' => [
            [
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name' => 'url',
                'editable' => [
                    'url' => $this->createUrl('/sitemap/sitemapBackend/inlinePage'),
                    'mode' => 'inline',
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken,
                    ],
                ],
                'filter' => CHtml::activeTextField($page, 'url', ['class' => 'form-control']),
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
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken,
                    ],
                ],
                'filter' => CHtml::activeDropDownList($page, 'changefreq', SitemapHelper::getChangeFreqList(),
                    ['class' => 'form-control', 'empty' => '']),
                'htmlOptions' => ['style' => 'width: 250px;'],
            ],
            [
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name' => 'priority',
                'editable' => [
                    'url' => $this->createUrl('/sitemap/sitemapBackend/inlinePage'),
                    'mode' => 'inline',
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken,
                    ],
                ],
                'filter' => CHtml::activeTextField($page, 'priority', ['class' => 'form-control']),
                'htmlOptions' => ['style' => 'width: 250px;'],
            ],
            [
                'class' => 'yupe\widgets\EditableStatusColumn',
                'name' => 'status',
                'url' => $this->createUrl('/sitemap/sitemapBackend/inlinePage'),
                'source' => $page->getStatusList(),
                'options' => [
                    SitemapPage::STATUS_ACTIVE => ['class' => 'label-success'],
                    SitemapPage::STATUS_NOT_ACTIVE => ['class' => 'label-default'],
                ],
                'htmlOptions' => ['style' => 'width: 150px;'],
                'filter' => CHtml::activeDropDownList($page, 'status', $page->getStatusList(),
                    ['class' => 'form-control', 'empty' => '']),
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
                'template' => '{front_view}{delete}',
                'frontViewButtonUrl' => function ($data) {
                    return Yii::app()->createAbsoluteUrl($data->url);
                },
                'buttons' => [
                    'front_view' => [
                        'visible' => function ($row, $data) {
                            return $data->status == SitemapPage::STATUS_ACTIVE;
                        },
                    ],
                ],
            ],
        ],
    ]
);
?>

<script type="text/javascript">
    $('#regenerate-site-map').on('click', function (event) {
        event.preventDefault();
        $.post('<?= Yii::app()->createUrl('/sitemap/sitemapBackend/regenerate');?>', {
            'do': true,
            '<?= Yii::app()->getRequest()->csrfTokenName?>': '<?= Yii::app()->getRequest()->csrfToken;?>'
        }, function (response) {
            window.location.reload();
        }, 'json')
    });
</script>
