<?php $this->pageTitle = Yii::t('site','Ошибка') . ' ' . $error['code'] . ' - ' . $this->yupe->siteName; ?>

<h2><?php echo Yii::t('site','Ошибка') . ' ' . $error['code']; ?></h2>

<?php
    switch ($error['code']) {
        case '404':
            $msg = Yii::t(
                'site',
                'Страница которую Вы запросили не найдена. Вы можете покинуть данную страницу и {link}.',
                array(
                    '{link}' => CHtml::link(
                        Yii::t('site','перейти на главную страницу сайта'),
                        $this->createUrl("/" . Yii::app()->defaultController . '/index'),
                        array(
                            'title' => Yii::t('site','Перейти на главную страницу сайта'),
                            'alt'   => Yii::t('site','Перейти на главную страницу сайта'),
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
<p class="alert alert-error">
    <?php echo $msg; ?>
</p>