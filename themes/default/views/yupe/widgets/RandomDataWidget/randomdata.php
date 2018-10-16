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
            'http://www.elisdn.ru/oop-week?utm_medium=affiliate&utm_source=yupe',
            ['title' => 'Авторские вебинары по Yii2 !', 'target' => '_blank']
        );?>
        <hr/>
        <?= $item; ?>
    </div>
</div>
