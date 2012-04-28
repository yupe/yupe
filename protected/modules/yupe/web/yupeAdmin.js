function ajaxSetStatus(elem, id){
    $.ajax({
        url: $(elem).attr('href'),
        success: function(){
            $('#'+id).yiiGridView.update(id);
        }
    });
}
