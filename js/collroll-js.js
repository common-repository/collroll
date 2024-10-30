jQuery(".collroll_expand_line").click(function () {
	jQuery(".collroll_expand_line").toggle();
	
	if ( jQuery("#collroll_expand_all").css('display') == 'none' ) 
		jQuery(".collroll_cat_links").show();
	else
		jQuery(".collroll_cat_links").hide();
});

jQuery(document).ready(function(){

	jQuery('span.collroll_link a').attr('target', '_blank');
	
	jQuery('span.collroll_link a').mouseover( function(){
				
		url = jQuery(this).attr('href');
		url_encoded = escape( url );

		jQuery('#collroll_snapshot').attr('src', 'http://images.websnapr.com/?url=' + url_encoded +'&size=s&nocache=15');

		if( url.length >= 33 )
			url = url.substr(7,37) + '...';
		else
			url = url.substr(7);
			
		jQuery('#collroll_link_short').html(url);	
		
		jQuery('#collroll_link_preview').animate( {
			marginLeft:"210px"}, "fast" );		
	
	});
	
	jQuery('span.collroll_link a').mouseout( function(){
		jQuery('#collroll_link_preview').animate( {
			marginLeft:"0px"}, "fast" );
	});

});