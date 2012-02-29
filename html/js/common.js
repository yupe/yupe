
$(document).ready(function(){
	
	$('.sel').change(function(){
		var val=$(this).find('select option:selected').text();
		$(this).find('span').text(val);
	});
	

			
	 $('.collection-container .items span.name').click(function(){
	  $(this ).parent().find('ul').toggleClass('display-none');
	 });
	 
})