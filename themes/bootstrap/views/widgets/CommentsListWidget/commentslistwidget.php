<div id="comments">
    <?php if (count($comments)): ?>
    <h3>Комментариев: <?php echo count($comments);?></h3>
    <?php foreach ($comments as $comment): ?>
        <div id="c2" class="comment">
            <div class="author">
                <?php if ($comment->url): ?>
                <a href="<?php echo $comment->url;?>"><?php echo $comment->name;?></a>
                написал:
                <?php else: ?>
                <?php echo $comment->name; ?> написал:
                <?php endif;?>
            </div>

            <div class="time"><?php echo $comment->creation_date;?></div>

            <div class="content"><?php echo $comment->text;?></div>
        </div><!-- comment -->
        <?php endforeach; ?>
    <?php else: ?>
    <p>Комментариев пока нет, станьте первым!</p>
    <?php endif;?>
</div>
  
