<div class="row">
    <div class="col-sm-12">
        <h4>
            <strong>
                <?= CHtml::link(CHtml::encode($data->title), $data->getUrl()); ?>
            </strong>
        </h4>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <p>
            <?= $data->getImageUrl() ? CHtml::image($data->getImageUrl(), CHtml::encode($data->title), ['class' => 'img-responsive']) : ''; ?>
        </p>

        <p><?= strip_tags($data->getQuote()); ?></p>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <p></p>

        <p>
            <i class="glyphicon glyphicon-user"></i> <?= CHtml::link($data->createUser->nick_name, ['/user/people/userInfo', 'username' => $data->createUser->nick_name]); ?>
            | <i class="glyphicon glyphicon-pencil"></i> <?= CHtml::link(CHtml::encode($data->blog->name), $data->blog->getUrl()); ?>
            | <i class="glyphicon glyphicon-calendar"></i> <?= Yii::app()->getDateFormatter()->formatDateTime($data->publish_time, "short", "short"); ?>
            | <i class="glyphicon glyphicon-comment"></i>  <?= CHtml::link($data->commentsCount, $data->getUrl(['#' => 'comments'])); ?>
            | <i class="glyphicon glyphicon-tags"></i>
            <?php if (($tags = $data->getTags()) != []) : ?>
                <?php foreach ($tags as $tag): ?>
                    <?php $tag = CHtml::encode($tag); ?>
                    &nbsp;
                    <span class="label label-info">
                        <?= CHtml::link($tag, ['/posts/', 'tag' => $tag]) . ' ' ?>
                    </span>
                <?php endforeach ?>
            <?php endif; ?>
        </p>
    </div>
</div>
<hr>
