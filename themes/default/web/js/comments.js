$(document).ready(function () {
    // нажатите "ответить"
    $(document).on("click", "a.reply", function () {
        $this = $(this);
        if($this.attr("rel") != $("#Comment_parent_id").val()) {
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
        }
    });

    $(document).on("click", '#wcml', function (event) {
        event.preventDefault();
        $("div.comment-form").remove();
        $("#comment-form-wrap").show();
        $(this).hide();
    });

    $(document).on('keyup', '#comment-form textarea, #comment-form input[type=text]', function (event) {
        if (event.ctrlKey && event.keyCode == 13) {
            $(this).parents('#comment-form').submit();
        }
    });

    $(document).on('submit', '#comment-form', function (event) {
        event.preventDefault();
        var $form = $(this);
        var $container = $('#comments');
        if(!$('#Comment_text').val()){
            $('#notifications').notify({ message: { text: 'Комментарий пуст =(' }, 'type': 'danger' }).show();
            return false;
        }
        console.log($form.serialize());
        $.post($form.attr('action'), $form.serialize(), function (response) {
            var type = response.result ? 'success' : 'danger';
            $('#notifications').notify({ message: { text: response.data.message }, 'type': type }).show();
            if (response.data.commentContent) {
                if (response.data.comment.parent_id > 0) {
                    $container = $('#comment-' + response.data.comment.parent_id).parents('.comments-item');
                }
            }
            if(response.result) {
                $('#Comment_text').val('');
            }

            if ($container.attr('id') != 'comments') {
                $container.after(response.data.commentContent);
            } else {
                $container.append(response.data.commentContent);
            }
        }, 'json');
        return false;
    });
});
