<div class="view">

    <h3><?php echo CHtml::link(CHtml::encode($data->name),array('/blog/blog/show/','slug' => $data->slug)); ?></h3>

    <b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->createUser->getFullName()),array('/user/people/userInfo/','username' => $data->createUser->nick_name)); ?>
    <?php echo CHtml::encode($data->create_date); ?>    
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
    <?php echo $data->description; ?>


    <b>Записей:</b>
    <?php echo $data->postsCount; ?>
    <br/>

    <?php if($data->membersCount > 0)
        echo "<b>Участников:</b>" . $data->membersCount;?>
    <br/>

    <a href="<?php /* @todo Не работает */ echo $data->id;?>" class="join-blog">Вступить в блог</a>
    
</div>
