jQuery(document).ready(function(){

	var selected_tab = 0;
	var action = '';
	
	if(document.location.hash!='')
	{
       	selected_tab = document.location.hash.substr(1,document.location.hash.length);
       	
       	// TODO: This doesn't work. Fix it!
       	// Tell the form which tab is selected to reselect it after the next save
       	action = jQuery("#colorform").attr('action');
		jQuery("#colorform").attr( 'action', action + '#' + selected_tab );
    }

	jQuery("#tabs").tabs({ event: 'mouseover' });
	jQuery("#tabs").tabs('select', selected_tab-1);	
	
	jQuery("#tabs").bind( 'tabsshow', function(){
		var tabs = jQuery('#tabs').tabs();
		var index = tabs.tabs('option', 'selected') + 1;
		
		action = jQuery("#colorform").attr('action');
		var new_action = action.replace( /#\d/ , "") + "#" + index;
		jQuery("#colorform").attr('action', new_action );
		
	});
	
});