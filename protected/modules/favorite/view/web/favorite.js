/*добавление/удаление товаров в избранное*/
$(document).ready(function () {
    $(document).on('click', '.yupe-store-favorite-add', function (event) {
        event.preventDefault();
        var $this = $(this);
        var product = parseInt($this.data('id'));
        var data = {'id': product};
        data[yupeTokenName] = yupeToken;
        $.post(yupeStoreAddFavoriteUrl, data, function (data) {
            if (data.result) {
                $('#yupe-store-favorite-total').html(data.count);
                $this.removeClass('yupe-store-favorite-add')
                    .addClass('yupe-store-favorite-remove').addClass('text-error');
                $this.children('i').removeClass('fa-heart-o').addClass('fa-heart');
            }
            showNotify($this, data.result ? 'success' : 'danger', data.data);
        }, 'json');
    });

    $(document).on('click', '.yupe-store-favorite-remove', function (event) {
        event.preventDefault();
        var $this = $(this);
        var product = parseInt($this.data('id'));
        var data = {'id': product};
        data[yupeTokenName] = yupeToken;
        $.post(yupeStoreRemoveFavoriteUrl, data, function (data) {
            if (data.result) {
                $('#yupe-store-favorite-total').html(data.count);
                $this.removeClass('yupe-store-favorite-remove')
                    .removeClass('text-error').addClass('yupe-store-favorite-add');
                $this.children('i').removeClass('fa-heart').addClass('fa-heart-o');
            }
            showNotify($this, data.result ? 'success' : 'danger', data.data);
        }, 'json');
    });
});