<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '#post-updatecomments', function(){
            var link = $(this);
            link.addClass('ajax-loading');
            $.ajax({
                url: '<?php echo Yii::app()->baseUrl;?>/comment/comment/updatecomments',
                data: {'<?php echo Yii::app()->request->csrfTokenName ?>':'<?php echo Yii::app()->request->csrfToken;?>','model':'<?php echo $this->model?>','modelId':'<?php echo $this->modelId;?>'},
                dataType: 'json',
                type: 'post',
                success: function(data){
                    if (data.result && data.data.content) {
                        $('#comments').replaceWith(data.data.content);
                        $('#comments').before(
                            "<div class='flash'><div class='flash-success'><b>" + data.data.message + "</b></div></div>"
                        );
                    } else {
                        $('.comments').before("<div class='flash'><div class='flash-error'><b>" + data.data.message + "</b></div></div>");
                    }
                    link.removeClass('ajax-loading');
                }
            });
            setTimeout(function(){
                $('.flash').remove();
            }, 3000);
            return false;
        });
    });
</script>

<?php if(!$this->comment):?>
    <div id="comments">
<?php endif;?>

<?php if(count($comments)):?>
    <?php if (!$this->comment):?>
        <strong><?php echo $this->label; ?> <?php echo count($comments); ?></strong>
        <?php echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/web/images/rss.png'),array('/comment/rss/feed','model' => $this->model, 'modelId' => $this->modelId));?>
    <?php endif;?>

    <?php foreach ($comments as $commentArray):?>

        <?php if(!$this->comment && isset($commentArray['childOf'])):?>
            <?php $comment = $commentArray['row'];?>
            <?php $level = count($commentArray['childOf']);?>
        <?php else:?>
            <?php $comment = $this->comment;?>
            <?php $level = 1;?>
        <?php endif;?>

        <div style="margin-left: <?php echo (20 * $level); ?>px; " level="<?php echo $level; ?>">
            <div class="well well-small" id="comment_<?php echo $comment->id;?>_<?php echo str_replace(' ', '_', $comment->creation_date); ?>">
                <div class="avatar">
                    <?php echo $comment->getAuthorAvatar();?>
                </div>
                <div class="comment-body">
                    <div class="author">
                        <?php echo $comment->getAuthorLink();?> <?php echo Yii::t('comment', 'написал');?>
                        <span style="float: right">
                            <?php echo CHtml::link(
                                '<i class="icon-bullhorn"></i>', 'javascript:void(0);', array(
                                    'rel'     => $comment->id,
                                    'data-id' => $comment->id . '_' . str_replace(' ', '_', $comment->creation_date),
                                    'class'   => 'commentParrent',
                                    'title'   => Yii::t('comment','Ответить')
                            ));?>
                        </span>
                    </div>
                    <div class="time"> <?php echo $comment->creation_date; ?> </div>
                    <div class="content"> <?php echo $comment->getText() ;?> </div>
                </div>
            </div>
        </div>

    <?php endforeach;?>


<?php else:?>
    <p><?php echo $this->label; ?> <?php echo Yii::t('comment', 'пока нет, станьте первым!');?>;
<?php endif;?>


<?php if(!$this->comment):?>
    </div>
<?php endif;?>