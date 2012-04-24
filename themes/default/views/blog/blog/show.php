<div class="post">
    <div class="title">
        <?php echo $blog->name; ?>
    </div>
    <div class="author">
        Создал: <b><?php echo $blog->createUser->nick_name?></b>
        дата: <?php echo $blog->create_date; ?>
    </div>
    <br/>

    <div class="content">
        <p><?php echo $blog->description; ?></p>
    </div>    
</div>

<p>Последние записи</p>

<?php if(count($posts)):?>
    <ul>
    <?php foreach ($posts as $post):?>
        <li><?php echo CHtml::link($post->title,array('/blog/post/show/','slug' => $post->slug));?></li>
    <?php endforeach;?>
    </ul>
<?php endif;?>

<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
                                                                                              'type' => 'button',
                                                                                              'services' => 'all'
                                                                                         ));?>
</div>

