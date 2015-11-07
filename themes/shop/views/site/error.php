<?php $this->title = [Yii::t('default', 'Error') . ' ' . $error['code'], Yii::app()->getModule('yupe')->siteName]; ?>
<div class="main__title grid">
    <h1 class="h2"><?= Yii::t('default', 'Error') . ' ' . $error['code']; ?>!</h1>
</div>
<div class="main__product-description grid">
    <?php
    switch ($error['code']) {
        case '404':
            $msg = Yii::t(
                'default',
                'Page you try to request, was not found. You can go out from this page and {link}.',
                [
                    '{link}' => CHtml::link(
                        Yii::t('default', 'go to home page'),
                        $this->createUrl("/" . Yii::app()->defaultController . '/index'),
                        [
                            'title' => Yii::t('default', 'go to home page'),
                            'alt'   => Yii::t('default', 'go to home page'),
                        ]
                    ),

                ]
            );
            break;
        default:
            $msg = $error['message'];
            break;
    }
    ?>

    <p class="errorSummary"><?= $msg; ?></p>
</div>
