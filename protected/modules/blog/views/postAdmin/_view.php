<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('blog_id')); ?>:</b>
    <?php echo CHtml::encode($data->blog->name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('create_user_id')); ?>:</b>
    <?php echo CHtml::encode($data->createUser->getFullName()); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('update_user_id')); ?>:</b>
    <?php echo CHtml::encode($data->updateUser->getFullName()); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
    <?php echo CHtml::encode($data->create_date); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('update_date')); ?>:</b>
    <?php echo CHtml::encode($data->update_date); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('slug')); ?>:</b>
    <?php echo CHtml::encode($data->slug); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('publish_date')); ?>:</b>
    <?php echo CHtml::encode($data->publish_date); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
    <?php echo CHtml::encode($data->title); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('quote')); ?>:</b>
    <?php echo CHtml::encode($data->quote); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('link')); ?>:</b>
    <?php echo CHtml::encode($data->link); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode($data->getStatus()); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('comment_status')); ?>:</b>
    <?php echo CHtml::encode($data->getCommentStatus()); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('access_type')); ?>:</b>
    <?php echo CHtml::encode($data->getAccessType()); ?>
    <br />

</div>