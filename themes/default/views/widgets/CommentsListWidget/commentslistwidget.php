<div id="comments">
    <?php if (count($comments)): ?>
    <h3><?php echo $this->label;?>: <?php echo count($comments);?></h3>
    <?php foreach ($comments as $comment): ?>
        <div id="c2" class="comment">
            <div class="author">
                <?php if ($comment->url): ?>
                <a href="<?php echo $comment->url;?>">
                    <?php if($author = $comment->getAuthor()):?>
                        <?php echo CHtml::link($comment->name,array('/user/people/userinfo/','username' => $author->nick_name));?>
                    <?php else:?>
                        <?php echo $comment->name;?>
                    <?php endif;?>
                </a>
                написал:
                <?php else: ?>
                <?php if($author = $comment->getAuthor()):?>
                    <?php echo CHtml::link($comment->name,array('/user/people/userInfo/','username' => $author->nick_name));?>
                    <?php else:?>
                    <?php echo $comment->name;?>
                    <?php endif;?> написал:
                <?php endif;?>
            </div>

            <div class="time"><?php echo $comment->creation_date;?></div>

            <div class="content"><?php echo $comment->text;?></div>
        </div><!-- comment -->
        <?php endforeach; ?>
    <?php else: ?>
    <p><?php echo $this->label;?> пока нет, станьте первым!</p>
    <?php endif;?>
</div>
  
