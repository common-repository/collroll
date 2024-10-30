<?php

class Collroll_Backend
{
	// Used for sending the form data to the admin target page
	var $target_page;

	function collroll_menu()
	{  
		if ( $_GET['page'] == "collapsing-blogroll" ) 
		{
			// Load libraries and scripts for the colorpicker
			wp_enqueue_script('prototype');
			
			wp_register_script('cp_colorMethods', COLLROLL_URLPATH . 'colorpicker/ColorMethods.js');
			wp_enqueue_script('cp_colorMethods');
			
			wp_register_script('cp_colorValuePicker', COLLROLL_URLPATH . 'colorpicker/ColorValuePicker.js');
			wp_enqueue_script('cp_colorValuePicker');
		
			wp_register_script('cp_slider', COLLROLL_URLPATH . 'colorpicker/Slider.js');
			wp_enqueue_script('cp_slider');
			
			wp_register_script('cp_colorPicker', COLLROLL_URLPATH . 'colorpicker/ColorPicker.js');
			wp_enqueue_script('cp_colorPicker');
			
			// Load the required scripts and styles for the tabs
			wp_enqueue_script('jquery-ui-tabs');
			
			wp_enqueue_script('collroll_admin_tabs', COLLROLL_URLPATH .'admin/js/admin_tabs.js');
			wp_enqueue_style('collroll_admin_tabs_css', COLLROLL_URLPATH .'admin/css/admin_tabs.css');
			
			// Using thickbox for the install frame of "My Link Order" and other plugins
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
			
			// Load the scripts for drag and drop
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-droppable');
			wp_enqueue_script('collroll_admin_dragdrop', COLLROLL_URLPATH .'admin/js/exclude_categories.js');
		}
		
		if (function_exists('add_submenu_page'))
	        add_submenu_page( $this->collroll_getTarget(), 'Collapsing Blogroll', 'Collapsing Blogroll', 5, "collapsing-blogroll", array( &$this, 'collrollAdmin') );
	}

	//Switch page target depending on version
	function collroll_getTarget() 
	{
		return $this->target_page = "options-general.php";
		
		// This will be ignored
		global $wp_version;
		if (version_compare($wp_version, '2.6.5', '>'))
			return $this->target_page = "link-manager.php";
		else
			return $this->target_page = "options-general.php";
	}

	function collrollAdmin()
	{
		global $collroll_default_options;
		global $collroll_default_translations;
		
		// For debugging
		//print_r($collroll_default_options); 
		
		$options = get_option('collroll');
		$merged_options = wp_parse_args( $options, $collroll_default_options );
				
		$translations = get_option('collroll_translations');
		$merged_translations = wp_parse_args( $translations, $collroll_default_translations );
		
		$msg = '';
		

		if ( $_POST['menu-submit'] ) 
		{
			//print_r($_POST);
			
			// Create a new array for the new settings. A new array is needed because the query
			// could contain more stuff than needed.
		    $newoptions['color'] = 				$_POST['color'];
		    $newoptions['colorText'] = 			$_POST['colorText'];
			$newoptions['use_color'] =			$_POST['use_color'];
			$newoptions['use_color_text'] =		$_POST['use_color_text'];
		    $newoptions['category_orderby'] = 	$_POST['category_orderby'];
		    $newoptions['orderby'] = 			$_POST['orderby'];
		    $newoptions['width'] = 				$_POST['width'];
		    $newoptions['collapsed'] =          $_POST['collapsed'];
		    // TODO: fix the "sow" bug
		    $newoptions['sow_expand_collapse_line'] = $_POST['sow_expand_collapse_line'];
		    $newoptions['category_title_size'] = $_POST['category_title_size'];
		    $newoptions['show_description'] =  $_POST['show_description'];
		    $newoptions['between'] =            $_POST['between'];
   		    $newoptions['show_category_description'] =  $_POST['show_category_description'];
   		    
   		    
   		    // If no category was selected set an empty string
   		    if ( isset( $_POST['exclude_category'] ))
   		    	$newoptions['exclude_category'] = implode( ',', $_POST['exclude_category'] );
   		    else
   		    	$newoptions['exclude_category'] = '';
			
		    // merge newoptions into merged_options
		    $merged_options = wp_parse_args( $newoptions, $merged_options );
		    
		    /******************************************************************/
				
			$new_translations['expand_all'] = $_POST['expand_all'];
			$new_translations['collapse_all'] = $_POST['collapse_all'];
			
			//merge new_translations into merged_translations
		    $merged_translations = wp_parse_args( $new_translations, $merged_translations );
		    

		    /******************************************************************/
		    
		   	// save new settings if any changed 
		    // update_option returns false if the option hasn't changed.
			if ( ! update_option('collroll', $newoptions) && ! update_option('collroll_translations', $new_translations) ) 
				$error_message = '<div id="collroll_message" class="updated fade" style="padding:4px;" ><strong>NO CHANGE</strong>&nbsp;&nbsp;&nbsp;Either you didn\'t change anything or an error occured!</div>';
		}
		
		 
		extract( $merged_options );
		extract( $merged_translations );
		
		$update = $this->fetch_update_message();
		if ($update)
			extract( $update );
			
		// $version is the new one if any and COLLROLL_VERSION is the local one.
		if( $update && version_compare( $version, COLLROLL_VERSION, '>' ) )
			$new_version = "(<a href='plugins.php'>$version</a> available)";
	?>
		<div class="wrap">
	
			<h2>Collapsing Blogroll <?= $new_version ?></h2>
			
			<?php
			
				$special_note = trim( $this->fetch_special_note() );
				
				if ( ! empty( $special_note ) )
					echo '<div class="ui-widget">
								<div style="margin-bottom:8px;" class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
									<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
									 '. $special_note .'</p>
				
								</div>
							</div>';
				
				// If the options haven't changed or an error occured an error message is output
				if ( ! empty( $error_message ) )
				/*	// conflict: error_message contains a div that uses the classes updated and fade
					echo '<div class="ui-widget">
							  	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
								  <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
								  '. $error_message .'</p>
								</div>			  
						  </div>'; 
				*/
					echo $error_message;
			?>
			
			<form id="colorform" action="<?= $this->target_page ?>?page=collapsing-blogroll" method="post">
			

			<div id="tabs">    
				<ul>
					<li><a href="#tab-1"><span>Expanding/Collapsing</span></a></li>
					<li><a href="#tab-2"><span>Descriptions</span></a></li>
					<li><a href="#tab-3"><span>Colors & Fonts</span></a></li>
					<li><a href="#tab-4"><span>Order & Exclusion</span></a></li>
					<li><a href="#tab-6"><span>Related Plugins</span></a></li>
					<li><a href="#tab-5"><span>Other</span></a></li>
				</ul>
				
<!-- Expanding/Collapsing -->				
				<div id="tab-1"> 

					<h4>Should the categories be collapsed by default?</h4>
					<input type="radio" name="collapsed" value="yes" <?= ( "yes" == $collapsed ) ? "checked" : "";?> > Yes
					<input type="radio" name="collapsed" value="no" <?= ( "no" == $collapsed ) ? "checked" : "";?>> No

					<h4>Should the <em>Expand | Collapse</em> line be visible?</h4>
					<input type="radio" name="sow_expand_collapse_line" value="yes" <?= ( "yes" == $sow_expand_collapse_line ) ? "checked" : "";?> > Yes
					<input type="radio" name="sow_expand_collapse_line" value="no" <?= ( "no" == $sow_expand_collapse_line ) ? "checked" : "";?>> No

				</div>

<!-- Descriptions -->				
				<div id="tab-2"> 

					<h4>Show descriptions?</h4>
					<input type="radio" name="show_description" value="1" <?= ( 1 == $show_description ) ? "checked" : "";?> > Yes
					<input type="radio" name="show_description" value="0" <?= ( 0 == $show_description ) ? "checked" : "";?>> No

					<h4>Delimiter</h4>
					<input type="text" size="8" name="between" value="<?= $between ?>"/> This is put between the link and description.
					<h4>Show category description?</h4>
					<input type="radio" name="show_category_description" value="yes" <?= ( "yes" == $show_category_description ) ? "checked" : "";?> > Yes
					<input type="radio" name="show_category_description" value="no" <?= ( "no" == $show_category_description ) ? "checked" : "";?>> No

				</div>
				
<!-- Colors & Fonts -->
				<div id="tab-3"> 
					<script type="text/javascript">
					<!--
					function setColorField( $element, $color )
					{
						document.getElementById( 'vf' + $element ).style.backgroundColor = '#'+$color;
						document.getElementById( 'hf' + $element ).value = $color;
					}
					-->
					</script>
					
					<?php 
					 
						// TODO: Quick and dirty. Better to realise only one window that is configurable instead of two fix windows.
					?>
					<div id="wdcp1" style="position:absolute; left:370px; top:180px; background-color:white; padding:10px; padding-top:-10px; border:solid 1px black; display:none;">
						<h4>Title background</h4>
						<?php collroll_colorpicker( $color, 1); ?>
						<script type="text/javascript">
						<!--
						var wdcp1 = document.getElementById('wdcp1');
						cp1.hide();
						-->
						</script>
						<input onclick="cp1.hide(); setColorField( 'Color', document.getElementById('cp1_Hex').value ); wdcp1.style.display='none';" style="margin-top:4px;" type="button" name="menu-submit" class="button-primary" value="Select Color" />
						<input onclick="cp1.hide(); wdcp1.style.display='none';" style="margin-top:4px;" type="button" class="button-primary" value="Cancel" />
					</div>
					
					
					<div id="wdcp2" style="position:absolute; left:370px; top:180px; background-color:white; padding:10px; padding-top:-10px; border:solid 1px black; display:none;">
						<h4>Category title</h4>
						<?php collroll_colorpicker( $colorText, 2); ?>
						<script type="text/javascript">
						<!--
						var wdcp2 = document.getElementById('wdcp2');
						cp2.hide();
						-->
						</script>
						<input onclick="cp2.hide(); setColorField( 'ColorText', document.getElementById('cp2_Hex').value ); wdcp2.style.display='none';" style="margin-top:4px;" type="button" name="menu-submit" class="button-primary" value="Select Color" />
						<input onclick="cp2.hide(); wdcp2.style.display='none';" style="margin-top:4px;" type="button" class="button-primary" value="Cancel" />
					</div>
					
					<h4>Background colors</h4>
					<table>
					<tr><td>Title background</td><td style="width:20px;" ></td><td id="vfColor" onclick="wdcp1.style.display=''; cp1.show(); cp2.hide(); wdcp2.style.display='none';" style="cursor:pointer; width:50px; border:solid 1px black; background-color:#<?= $color ?>;"></td><td><input style="margin-left:20px;" type="checkbox" name="use_color" value="yes" <?= ( 'yes' == $use_color ) ? 'checked' : ''; ?>> Use this color</td></tr>
					<tr><td>Category title</td><td style="width:20px;" ></td><td id="vfColorText" onclick="wdcp2.style.display=''; cp2.show(); cp1.hide(); wdcp1.style.display='none';" style="cursor:pointer; width:50px; border:solid 1px black; background-color:#<?= $colorText ?>;"></td><td><input style="margin-left:20px;" type="checkbox" name="use_color_text" value="yes" <?= ( 'yes' == $use_color_text ) ? 'checked' : ''; ?>> Use this color</td></tr>
					</table>
					
					<input id="hfColor" type="hidden" name="color" value="<?= $color ?>" />
					<input id="hfColorText" type="hidden" name="colorText" value="<?= $colorText ?>" />
					
					
					<h4>Category font size</h4>
					<p>
						<input type="text" size="8" name="category_title_size" value="<?= $category_title_size ?>"/> Example: 10pt
					</p>
					If empty the default header size is h4 which depends on your theme css. Valid units are <a href="http://www.thesug.org/Blogs/kyles/archive/2009/04/17/CSS_FontSize_em_vs_px_vs_pt_vs_percent.aspx.aspx" target="_blank">em, px, pt and %</a>.
				</div>

<!-- Links & Categories -->				
				<div id="tab-4"> 
					<h4>Order</h4>
					<div style="width:300px; margin-top:-20px;">
					
						<div style="float:left;">
						<h5>Categories</h5>
						<input type="radio" name="category_orderby" value="name" <?= ( $category_orderby == "name" ) ? 'checked="checked"' : ''; ?>> Alphabetical<br>
						<input type="radio" name="category_orderby" value="order" <?= ( $category_orderby == "order" ) ? 'checked="checked"' : ''; ?>> User defined.<br>
						</div>
						
						<div style="float:right;">
						<h5>Links</h5>
						<input type="radio" name="orderby" value="name" <?= ( $orderby == "name" ) ? 'checked="checked"' : ''; ?>> Alphabetical<br>
						<input type="radio" name="orderby" value="id" <?= ( $orderby == "id" ) ? 'checked="checked"' : ''; ?>> User defined.<br>
						</div>
	
				
					</div>
						<br style="clear:both;" /><br />			
	
						Select <i>User defined</i> if you manage the order on your own by using a plugin like
						
						<ul style="list-style:circle; margin:5px auto auto 5px;">
							<li>My Link Order ( <a href="plugin-install.php?tab=plugin-information&plugin=my-link-order&KeepThis=true&TB_iframe=true&height=400&width=640" class="thickbox">Install</a> or <a href="http://wordpress.org/extend/plugins/my-link-order/" target="_blank">download</a> it now ) </li>
						</ul>
				
					<h4>Exclude Categories</h4>
						
						<?php	
							global $wpdb;
							// get the cats
							$cat_ids = $wpdb->get_col("SELECT term_id FROM $wpdb->term_taxonomy WHERE taxonomy='link_category'");

							if( !empty( $exclude_category ) )
								$hidden_cats = explode( ',', $exclude_category );
							else
								$hidden_cats = array();

							$visible_cats = array_diff( $cat_ids, $hidden_cats );						
						?>

					<div style="width:500px;">
						<div class="box" id="not_shown">
						<div>Hidden</div>
								<?php
									foreach( $hidden_cats as $cat_id ) 
										echo '<div id="cat'. $cat_id .'" class="drag">'. $wpdb->get_var("SELECT name FROM $wpdb->terms WHERE term_ID=$cat_id") .'</div>';
								?>
						</div>

						<div class="box" id="shown">
							<div>Visible</div>
							<div style="width:100px;"></div>
							
								<?php 
									foreach( $visible_cats as $cat_id ) 
										echo '<div id="cat'. $cat_id .'" class="drag">'. $wpdb->get_var("SELECT name FROM $wpdb->terms WHERE term_ID=$cat_id") .'</div>';
								?>
						</div>
						
						<br style="clear:both;" />
					</div>
					
				</div>
				
<!-- Other -->				
				<div id="tab-5"> 
					<h4>Width of Collroll</h4>
					<input type="text" size="8" name="width" value="<?= $width ?>"/> Examples: 300px or 75%
					
					<h4>Translations</h4>
					<p>
						<input type="text" size="16" name="expand_all" value="<?= $expand_all ?>"/> Expand all <br/>
						<input type="text" size="16" name="collapse_all" value="<?= $collapse_all ?>"/> Collapse all <br/>
					</p>

				</div>

<!-- Related Plugins -->				
				<div id="tab-6"> 
				<h4>Related Plugins</h4>
				The author of <strong>Collapsing Blogroll</strong> is <strong>not responsible</strong> for these plugins.
					<?php $admin_images = COLLROLL_URLPATH . 'admin/images'; ?>
					
						<div style="width:500px;">
						<h5>My Link Order</h5>	
							<div style="float:left; margin-right:20px;">
								<img style="border:solid 1px #dddddd;" src="<?php echo $admin_images; ?>/related_plugins_order_links.png" height="200" width="200" />
							</div>
							<div>
								<p>My Link Order allows you to set the order in which links and link categories will appear in the sidebar, post or page. Uses a drag and drop interface for ordering.</p>
								<p><a href="plugin-install.php?tab=plugin-information&plugin=my-link-order&KeepThis=true&TB_iframe=true&height=400&width=640" class="thickbox">Install</a> or <a href="http://wordpress.org/extend/plugins/my-link-order" target="_blank">download</a> it now.</p>
							</div>
						</div>
						
						<br style="clear:both;" />


						<div style="width:500px; margin-top:20px;">
						<h5>Collapsing Links</h5>
							<div style="float:left; margin-right:20px;">
								<img style="border:solid 1px #dddddd;" src="<?php echo $admin_images; ?>/related_plugins_collapsing_links.png" height="200" width="200" />
							</div>
							<div>
								<p>This is a very simple plugin that uses Javascript to form a collapsable set of links in the sidebar for the links (blogroll). Every link corresponding to a given link category will be expanded.</p>
								<p><a href="plugin-install.php?tab=plugin-information&plugin=collapsing-links&KeepThis=true&TB_iframe=true&height=400&width=640" class="thickbox">Install</a> or <a href="http://wordpress.org/extend/plugins/collapsing-links" target="_blank">download</a> it now.</p>
							</div>
						</div>
						
						<br style="clear:both;" />
				</div>

				<!--
				<div id="fragment-">
				</div>
				-->
				
			</div>

			<br/>
			
			<input type="submit" name="menu-submit" class="button-primary" value="Save Changes" />
			</form>
		</div>
	<?php
	
	}
	
	// TODO: This update message is outputted above the core update message. The order should be changed.
	function update_message($plugin)
	{
		$options = get_option('collroll');
	
		if ( COLLROLL_FOLDER ."/collroll.php" == $plugin )
		{
			$update = $this->fetch_update_message();
			extract( $update );
			
			$message = trim( $message );
			
			// $version is the new one if any and COLLROLL_VERSION is the local one.
			if( $update && version_compare( $version, COLLROLL_VERSION, '>' ) && ! empty( $message ) )
				echo '<tr><td colspan="5" class="plugin-update" style="line-height:1.2em;">'. $message .'</td></tr>';			
		}
	}
	
	function fetch_update_message()
	{
			$messages = $this->fetch_extern_messages();
			
			// The update messages begins at position 1
			$newest_update = explode( '=>', $messages[1] );
			$version = trim( $newest_update[0] );
			$message = $newest_update[1];
			
			return array( 'version' => $version, 'message' => $message );
	}
	
	function fetch_special_note()
	{
		$messages = $this->fetch_extern_messages();
		
		// The special note is at position 0 with the format
		// Special note => Message content
		$special_message = explode( '=>', $messages[0] );
		
		return $special_message[1];
	}
	
	function fetch_extern_messages()
	{
		/* collroll.txt contains text with this format
		 * 0.2.1 => Message @@
		 * 0.2.0 => Message @@
		*/
		$file = "http://www.slopjong.de/wp-content/uploads/2009/01/collroll.txt";

		$opened_file = wp_remote_fopen($file);

		if($opened_file)
		{
			// It's intented to support more than one update message depending on the version.
			$messages = explode( '@@', $opened_file );
			return $messages;
		}
		
		return false;
	}

	function activate()
	{
		// TODO: Remove unneeded options
		
		/*
		$options = get_option('collroll');
		$options = wp_parse_args( array( 'version' => COLLROLL_VERSION ), $options );
		update_option( 'collroll', $options );
		*/
	}

	/**
	* PHP 4 Compatible Constructor
	*/
	function Collroll_Backend()
	{
		$this->__construct();
	}
	
	
	/**
	* PHP 5 Constructor
	*/		
	function __construct()
	{
		//error_reporting( E_ALL );
		/*-----------------------------------------------------*/
		add_action('admin_menu', array( &$this, 'collroll_menu') );
		add_action('after_plugin_row', array( &$this, 'update_message') );
		
		// TODO: Add an "upgrade" action to see if there are obsolete entries in the option collroll
		/*-----------------------------------------------------*/		
	}

} // end of class

?>