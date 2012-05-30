<div class="view">
    
    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->name),array('/blog/blog/show/','slug' => $data->slug)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->createUser->getFullName()),array('/user/people/userInfo/','username' => $data->createUser->nick_name)); ?>
    <?php echo CHtml::encode($data->create_date); ?>    
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
    <?php echo $data->description; ?>
    <br/>

    <b>Записей:</b>
    <?php echo $data->postsCount; ?>
    <br/>

    <b>Участников:</b>
    <?php echo $data->membersCount; ?>
    <br/>

    <a href="<?php echo $data->id;?>" class="join-blog">Вступить в блог</a>
    
</div>
