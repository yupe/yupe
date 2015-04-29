(function ($) {
    $(function () {
        var $widget = $('.comments-widget'),
            $formWrap = $('.comment-form-wrap'),
            $form = $formWrap.find('form'),
            $pid = $form.find('#Comment_parent_id'),
            $text = $form.find('#Comment_text'),
            $notifications = $('#notifications');

        function clearForm() {
            $form[0].reset();
            if ($.fn.redactor !== undefined) {
                $text.redactor('insert.set', '');
            }
        }

        function insertComment(pid, content) {
            if (!pid) {
                $widget.append(content);
                return;
            }

            var $parent = $widget.find('[data-id="' + pid + '"]'),
                $lastChild = $widget.find('[data-pid="' + pid + '"]:last');

            if ($lastChild.length > 0) {
                $lastChild.after(content);
            } else {
                $parent.after(content);
            }
        }

        $widget.on('click', 'a.reply', function (event) {
            var $this = $(this),
                $item = $this.parents('.comments-item');

            event.preventDefault();
            if ($this.attr('rel') != $pid.val()) {
                clearForm();
                $item.after($formWrap);
                $form.find('#close-comment').show();
                $pid.val($this.attr('rel'));
            }
        });

        $widget.on('keyup', 'textarea, input[type=text]', function (event) {
            if (event.ctrlKey && event.keyCode == 13) {
                $form.submit();
            }
        });

        $form.on('click', '#close-comment', function () {
            $(this).hide();
            clearForm();
            $widget.append($formWrap);
        });

        $form.on('submit', function (event) {
            event.preventDefault();

            if (!$text.val()) {
                $notifications.notify({message: {text: 'Комментарий пуст =('}, 'type': 'danger'}).show();
                return;
            }

            $.post($form.attr('action'), $form.serialize(), function (response) {
                $notifications.notify({
                    message: {text: response.data.message},
                    'type': response.result ? 'success' : 'danger'
                }).show();

                $('#captcha-refresh').trigger('click');

                if (response.result) {
                    insertComment(response.data.comment.parent_id, response.data.commentContent);
                    clearForm();
                    $widget.append($formWrap);
                    $form.find('#close-comment').hide();
                }
            }, 'json');
        });
    });
})(jQuery);