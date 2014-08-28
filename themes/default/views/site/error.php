<?php $this->pageTitle = Yii::t('default', 'Error') . ' ' . $error['code'] . ' - ' . $this->yupe->siteName; ?>

<h2><?php echo Yii::t('default', 'Error') . ' ' . $error['code']; ?>!</h2>

<?php
switch ($error['code']) {
    case '404':
        $msg = Yii::t(
            'default',
            'Page you try to request, was not found. You can go out from this page and {link}.',
            array(
                '{link}' => CHtml::link(
                        Yii::t('default', 'go to home page'),
                        $this->createUrl("/" . Yii::app()->defaultController . '/index'),
                        array(
                            'title' => Yii::t('default', 'go to home page'),
                            'alt'   => Yii::t('default', 'go to home page'),
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

<p class="alert alert-danger">
    <?php echo $msg; ?>
</p>
