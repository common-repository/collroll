  jQuery(document).ready(function(){
  
   	jQuery("#shown div").draggable( 
   		{ 
   			helper: 'clone'
   		});
  
    

    jQuery("#shown").droppable(
    	{
			tolerance: 'touch',
		  
			drop: function(event, ui) 
				{ 
					// remove the first 3 characters (=cat) to get the id
					var id = ui.draggable.attr('id').substr(3);
					jQuery(this).append( jQuery(ui.draggable).draggable() );
					
					// remove the hidden text input
					jQuery('#excluded_cat_'+ id).remove();
				}
    	});
    	

    jQuery('#not_shown div').draggable(
       	{ 
   			helper: 'clone'
   		});
    
    jQuery("#not_shown").droppable(
    	{
			tolerance: 'touch',
		  
			drop: function(event, ui) 
				{ 
					// remove the first 3 characters (=cat) to get the id
					var id = ui.draggable.attr('id').substr(3);
					jQuery(this).append( jQuery(ui.draggable).draggable() );
					
					// add a hidden text input for the excluded category
					jQuery('#form_excluded_categories').append( '<input id="excluded_cat_'+ id +'" type="text" name="exclude_category[]" value="'+ id +'" />' );
				}
    	});
  });