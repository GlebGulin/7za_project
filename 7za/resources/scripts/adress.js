
 $(document).ready(function(){

	
	$('#Delivery').on('change', function(event){
		
		if ($('#Delivery').val() === 'Kyiv')
		{
			$('.adr').hide(700);
		}
		else
		{
			$('.adr').show(700);
		}
	})
	
})