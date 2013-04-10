jQuery(document).ready(function($) {
    $(document).on("click", '#wcml', function(event){
        event.preventDefault();
        $("div.comment-form").remove();
        $("#comment-form-wrap").show();
    });

    $(document).on('keyup', '#comment-form textarea, #comment-form input[type=text]', function(event){
        if (event.ctrlKey && event.keyCode == 13) {
            $(this).parents('#comment-form').submit();
        }
    });

    $(document).on('submit', '#comment-form', function(){
        var backdrop = '<div class="backdrop"></div>';
        var submit = $(this).find('input[type=submit]');
        var curForm = this;
        var messageBox = false;
        var appendData = null;
        var container = $('#comments');
        $(this).addClass('loading');
        $(this).append(backdrop);
        submit.attr('disabled', 'disabled');
        $.ajax({
            type: 'post',
            url: $(curForm).attr('action'),
            data: $(curForm).serialize(),
            success: function(data) {
                $(curForm).removeClass('loading');
                $(backdrop).remove();
                submit.removeAttr('disabled');
                if (typeof data.result != 'undefined' && data.result) {
                    if (typeof data.data.commentContent !== 'undefined' && data.data.commentContent.length > 0) {
                        if (data.data.comment.parent_id > 0)
                            container = $('div[id*="comment_' + data.data.comment.parent_id + '"]');
                        appendData = data.data.commentContent;
                    }
                    curForm.reset();
                    messageBox = '<div id="messageBox" class="flash"><div class="flash-success"><b>' + data.data.message + '</b></div></div>';
                } else {
                    messageBox = '<div id="messageBox" class="flash"><div class="flash-error"><b>' + data.data.message + '</b></div></div>';
                }
                if (container.attr('id') != 'comments')
                    container = $(container.parent('div')[0]);

                container.append(messageBox).append(appendData);

                if ($('.captcha-refresh-link').length > 0)
                    $('.captcha-refresh-link').click();

                if (typeof data.result != 'undefined' && data.result) {
                    $('#wcml').click();
                }

                setTimeout(function() {
                    $("#messageBox").fadeOut('slow').remove();
                }, 3000);
            },
            error: function(data) {
                $(curForm).removeClass('loading');
                $(backdrop).remove();
                $(curForm).find('input[type=submit]').removeAttr('disabled');
                if (typeof data.data != 'undefined' && typeof data.data.message != 'undefined')
                    message = data.data.message;
                else
                    message = errorMessage;
                messageBox = '<div id="messageBox" class="flash"><div class="flash-error"><b>' + message + '</b></div></div>';
                $(curForm).before(messageBox);
                setTimeout(function() {
                    $("#messageBox").fadeOut('slow').remove();
                }, 3000);
            },
            dataType: 'json'
        });
        return false;
    });
});