
<?php $this->pageTitle = Yii::t('yupe','Error') . ' ' . $error['code'] . ' - ' . $this->yupe->siteName; ?>

<h2><?php echo Yii::t('yupe','Error') . ' ' . $error['code']; ?>!</h2>

<?php
    switch ($error['code']) {
        case '404':
            $msg = Yii::t(
                'yupe',
                'Page you try to request, was not found. You can go out from this page and {link}.',
                array(
                    '{link}' => CHtml::link(
                        Yii::t('yupe','go to home page'),
                        $this->createUrl("/" . Yii::app()->defaultController . '/index'),
                        array(
                            'title' => Yii::t('yupe','go to home page'),
                            'alt'   => Yii::t('yupe','go to home page'),
                        )
                    ),
                        
                )
            );
            break;
        default:
            $msg = $error['message'];
            break;
    }
?>

<?php $this->widget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => $error['code'],
        'headerIcon' => 'icon-error',
        'content' => $msg,
    )
);?>
<p class="alert alert-error">
    <?php echo $msg;?>
</p>