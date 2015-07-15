<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Интересно</h3>
    </div>
    <div class="panel-body">
        <?=   CHtml::link(
            CHtml::image(
                Yii::app()->getTheme()->getAssetsUrl() . '/images/elisdn.png',
                'Авторские вебинары по Yii2 !',
                ['style' => 'width: 100%']
            ),
            'http://www.elisdn.ru/blog/70/programming-webinars?utm_source=yupe&utm_medium=banner&utm_campaign=blog',
            ['title' => 'Авторские вебинары по Yii2 !', 'target' => '_blank']
        );?>
        <hr/>
        <?= $item; ?>
    </div>
</div>
