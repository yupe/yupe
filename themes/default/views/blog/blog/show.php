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

<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
                                                                                              'type' => 'button',
                                                                                              'services' => 'all'
                                                                                         ));?>
</div>

