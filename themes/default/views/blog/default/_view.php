<div class="view">

    <h3><?php echo CHtml::link(CHtml::encode($data->name), array('/blog/'.$data->slug)); ?></h3>

    <b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->createUser->getFullName()), array(
        '/user/'.$data->createUser->nick_name,
    )); ?>
    <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->create_date, "short", "short"); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
    <?php echo $data->description; ?>

    <b><?php echo Yii::t('blog', 'Записей'); ?>:</b> <?php echo $data->postsCount; ?> | 

    <?php if ($data->membersCount > 0): ?>
        <b><?php echo Yii::t('blog', 'Участников'); ?>:</b> <?php echo $data->membersCount; ?>
     <?php endif; ?>

    <br /><br />

    <?php echo CHtml::link(Yii::t('blog', 'Вступить в блог'), array('/blog/'.$data->slug.'?act=join&blogId='.$data->id)); ?>
</div>
