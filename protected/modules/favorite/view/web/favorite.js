/*добавление/удаление товаров в избранное*/
$(document).ready(function () {
    $(document).on('click', '.yupe-store-favorite-add', function (event) {
        event.preventDefault();
        var product = parseInt($(this).data('id'));
        var data = {'id': product};
        var $this = $(this);
        data[yupeTokenName] = yupeToken
        $.post(yupeStoreAddFavoriteUrl, data, function (data) {
            if (data.result) {
                $('#yupe-store-favorite-total').html(data.count);
                $this.removeClass('yupe-store-favorite-add')
                    .addClass('yupe-store-favorite-remove').addClass('text-error');
            }
            showNotify($this, data.result ? 'success' : 'danger', data.data);
        }, 'json');
    });

    $(document).on('click', '.yupe-store-favorite-remove', function (event) {
        event.preventDefault();
        var product = parseInt($(this).data('id'));
        var data = {'id': product};
        var $this = $(this);
        data[yupeTokenName] = yupeToken
        $.post(yupeStoreRemoveFavoriteUrl, data, function (data) {
            if (data.result) {
                $('#yupe-store-favorite-total').html(data.count);
                $this.removeClass('yupe-store-favorite-remove')
                    .removeClass('text-error').addClass('yupe-store-favorite-add');
            }
            showNotify($this, data.result ? 'success' : 'danger', data.data);
        }, 'json');
    });
});