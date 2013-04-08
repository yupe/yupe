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
        $(this).addClass('loading');
        $(this).find('.backdrop').remove();
        $(this).append('<div class="backdrop"></div>')
        $(this).find('input[type=submit]').attr('disabled', 'disabled');
        var curForm = this;
        $.ajax({
            type: 'post',
            url: $(curForm).attr('action'),
            data: $(curForm).serialize(),
            success: function(data) {
                $(curForm).removeClass('loading');
                $(curForm).find('.backdrop').remove();
                $(curForm).find('input[type=submit]').removeAttr('disabled');
                if (typeof data.result != 'undefined' && data.result) {
                    if (typeof data.data.commentContent !== 'undefined' && data.data.commentContent.length > 0) {
                        if (data.data.comment.parent_id > 0) {
                            container = $('div[id*="comment_' + data.data.comment.parent_id + '"]').parent('div');
                        } else {
                            container = $('#comments');
                        }

                        container.append(data.data.commentContent);
                    }
                    curForm.reset();
                    var messageBox = '<div id="messageBox" class="flash"><div class="flash-success"><b>' + data.data.message + '</b></div></div>';
                } else {
                    var messageBox = '<div id="messageBox" class="flash"><div class="flash-error"><b>' + data.data.message + '</b></div></div>';
                }
                $(curForm).before(messageBox);
                if ($('.captcha-refresh-link').length > 0)
                    $('.captcha-refresh-link').click();
                setTimeout(function() {
                    $("#messageBox").fadeOut('slow').remove();
                    if (typeof data.result != 'undefined' && data.result) {
                        $('#wcml').click();
                    }
                }, 3000);
            },
            error: function(data) {
                $(curForm).removeClass('loading');
                $(curForm).find('.backdrop').remove();
                $(curForm).find('input[type=submit]').removeAttr('disabled');
                if (typeof data.data != 'undefined' && typeof data.data.message != 'undefined')
                    message = data.data.message;
                else
                    message = errorMessage;
                var messageBox = '<div id="messageBox" class="flash"><div class="flash-error"><b>' + message + '</b></div></div>';
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