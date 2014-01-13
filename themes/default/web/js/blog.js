$(document).ready(function($) {
    $('.list-expanding').on('click', function (){
    	if ($(this).hasClass('btn-disabled')) return false;    	
        $(this).closest('.blog-description-members').toggleClass('expand-list');
    }); 
});