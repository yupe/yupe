<div class="view">    
    <b><a href="<?php echo $this->createUrl('/user/people/userinfo/',array('username' => $data->nick_name));?>"><?php echo CHtml::image( $data->getAvatar( 100 ),$data->getFullName());?></a></b>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('nick_name'))?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->nick_name), array('/user/people/userInfo', 'username'=>$data->nick_name)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>:</b>
    <?php echo CHtml::encode($data->creation_date); ?>
    <br/>
</div>