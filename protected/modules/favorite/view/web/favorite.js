/*добавление/удаление товаров в избранное*/
$(document).ready(function () {
    $(document).on('click','div.yupe-store-favorite-add', function (event) {
        event.preventDefault();
        var product = parseInt($(this).data('id'));
        var data = {'id':product};
        data[yupeTokenName] = yupeToken
        $.post(yupeStoreAddFavoriteUrl, data, function(data){
            if(data.result) {
                var count = parseInt($('#yupe-store-favorite-total').html());
                $('#yupe-store-favorite-total').html(count += 1);
            }
            showNotify($(this), data.result ? 'success' : 'danger', data.data);
        }, 'json');
    });
});