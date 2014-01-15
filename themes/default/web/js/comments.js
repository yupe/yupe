$(document).ready(function() {
    // нажатите "ответить"
    $(document).on("click", "a.reply", function() {
        $this = $(this);
        $('#wcml').show();
        $("div.comment-form").remove();
        var htmlForm = $("#comment-form-wrap").clone();
        htmlForm.addClass("comment-form").show();
        $("#comment-form-wrap").hide();
        $this.parents("div.comments-item").after(htmlForm);
        $("#Comment_level").val(
            parseInt($this.parents("div.well").parent("div").attr('level'), 0) + 1
        );
        $("#Comment_parent_id").val($this.attr("rel"));
    });

    $(document).on("click", '#wcml', function(event){
        event.preventDefault();
        $("div.comment-form").remove();
        $("#comment-form-wrap").show();
        $(this).hide();
    });

    $(document).on('keyup', '#comment-form textarea, #comment-form input[type=text]', function(event){
        if (event.ctrlKey && event.keyCode == 13) {
            $(this).parents('#comment-form').submit();
        }
    });

    $(document).on('submit', '#comment-form', function(event){
        event.preventDefault();
        var $form = $(this);
        var $submit = $form.find('input[type=submit]');
        var $container = $('#comments');
        $.post($form.attr('action'), $form.serialize(), function(response){           
            var cssClass = response.result ? 'alert-success' : 'alert-error';            
            var $result  = $('#comment-result');            
            $result.removeClass('alert-error').removeClass('alert-success')
               .addClass(cssClass).html(response.data.message).fadeIn().fadeOut(3000);
            if(response.data.commentContent) {                
                if (response.data.comment.parent_id > 0){
                    $container = $('#comment-' + response.data.comment.parent_id).parents('.comments-item');                    
                }
            }
            $('#Comment_text').val('');  
            $('#wcml').click();          
            if ($container.attr('id') != 'comments') {               
                $container.after(response.data.commentContent);
            }else{
                $container.append(response.data.commentContent);
            }
        },'json');
        return false;
    });       
});