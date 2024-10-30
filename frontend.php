<?php

class Collroll_Frontend
{

	var $merged_options;
	var $merged_translations;
	
	function page_callback()
	{		
		$merged_options = $this->merged_options;
		extract( $merged_options );
						
		$cats = get_terms('link_category', array(
			'name__like' => $category_name, 
			'include' => 	$category, 
			'exclude' => 	$exclude_category, 
			'orderby' => 	$category_orderby, 
			'order' => 		$category_order, 
			'hierarchical' => 0));
			
		// get the translations		
		extract( $this->merged_translations );
	
		if ( "yes" == $sow_expand_collapse_line )
		{
			$output .= '<div style="margin-bottom:5px; margin-top:10px;"><img style="height:0.8em; margin-right:5px;" src="'. COLLROLL_URLPATH .'images/hand.png">';
			$output .= '<span id="collroll_collapse_all" class="collroll_expand_line" style="'. (('yes' == $collapsed) ? "display:none;" : "display:inline;") .'">'. $collapse_all .'</span>
  						<span id="collroll_expand_all" class="collroll_expand_line" style="'. (('no' == $collapsed) ? "display:none;" : "") .'">'. $expand_all .'</span>';
			$output .= "</div>";
		}
		
		$output .= '<div class="collroll">';
		
		// walk for each category through the bookmark list
		foreach ( (array) $cats as $cat ) 
		{
			// merge the category id into the settings
			$params = array_merge($merged_options, array('category'=>$cat->term_id));
			$bookmarks = get_bookmarks($params);
			
			if ( empty($bookmarks) )
				continue;
	
			
			// TODO: change h4 into something else. To not break the html hierarchy of the theme 
			// title
			$output .= '<h4 class="collroll_cat_header" 
							onclick="jQuery(\'#collroll_cat_'. $cat->term_id .'\').toggle();">';
						
			// show category name
			$output .= $cat->name;
			
			// show category description
			if ( "yes" == $show_category_description && !empty($cat->description) )
				$output .= "&nbsp;&nbsp;&nbsp;( $cat->description )";
			
			$output .= "</h4>";
			
			// link list
			$output .= '<div class="collroll_cat_links" id="collroll_cat_'. $cat->term_id .'" style="'; 
			$output .= ('yes' == $collapsed) ? "display:none;" : ""; 
			$output .= '">';
			$output .= '<ul>'. _walk_bookmarks($bookmarks, $merged_options) .'</ul>';
			$output .= '</div>';
		}
		
		$output .= '</div>';
		
		// website snapshot
		$output .= '<div id="collroll_link_preview">
					<img style="margin-left:95px; margin-top:15px; margin-bottom:10px;" id="collroll_snapshot" src="">
					<span style="margin-left:95px;" id="collroll_link_short"></span>
					</div>';
	
		return $output;
	}
	
	// page is only used for backward compatibility
	function page($content)
	{
		if ( strpos($content, '<!--catlinkspage-->') !== false ) 
			$content = "<!-- Collapsing Blogroll -->" . $this->page_callback();

	  	return $content;
	}
	
	function shortcode_collroll( $atts, $content = null )
	{
		return "<!-- Collapsing Blogroll ". COLLROLL_VERSION ." -->" . $this->page_callback();
	}
	
	function header()
	{		
		$merged_options = $this->merged_options;
		
		extract( $merged_options );
		
		$catids = get_terms('link_category', array(
			'name__like' => $category_name, 
			'include' => $category, 
			'exclude' => $exclude_category, 
			'orderby' => $category_orderby, 
			'order' => $category_order, 
			'hierarchical' => 0)
			);
			
		
		/*
		TODO: It could be better to read the css from the database. A css schema has to be created
		and change the css properties on the fly depending on the settings made by the user.
		*/
		echo "\n".'
			<style type="text/css">
			  .collroll_cat_links { position:relative; top:0px; left:0px; z-index:2; }
			  #collroll_link_preview { 
	  				background-image:url(\'/'. PLUGINDIR .'/'. COLLROLL_FOLDER .'/images/frame.png\');
			  		background-repeat:no-repeat; 
			  		position:fixed;
			  		width:320px; height:205px; 
			  		top:200px; left:-300px;  
			  		z-index:1;
			  		color: white;
			  		}
			  .collroll_expand_line{ cursor:pointer; }
			  .collroll_cat_header 
			  	{ ';
				
				echo ( "yes" == $use_color ) ? "background-color: #$color;" : '';
				echo ( "yes" == $use_color_text ) ? "color: #$colorText;" : '';
				echo 'width:'. $width .';';
				
				if ( !empty( $category_title_size ) )
					echo "font-size: $category_title_size;";
				
				echo '
				padding:4px 0px 4px 10px;
				cursor: pointer;
				}
			</style>
			';

	}
	
	function enqueue_scripts()
	{
		wp_enqueue_script('collroll-js','/' . PLUGINDIR . '/collroll/js/collroll-js.js', array('jquery'), '1.0', true );
	}

	/**
	* PHP 4 Compatible Constructor
	*/
	function Collroll_Frontend()
	{
		$this->__construct();
	}
	
	
	/**
	* PHP 5 Constructor
	*/		
	function __construct()
	{
		// load settings
		global $collroll_default_options;
		global $collroll_default_settings;
		$options = get_option('collroll');
		
		
		// merge all together
		$defaults = wp_parse_args( $collroll_default_options, $collroll_default_settings );		
		$this->merged_options = wp_parse_args( $options, $defaults );
		
		// load translations
		global $collroll_default_translations;
		$translations = get_option('collroll_translations');
		
		
		if ( empty($translations['expand_all']) || empty($translations['collapse_all']) )
			$this->merged_translations = $collroll_default_translations;			
		else
			$this->merged_translations = $translations;

		
		/*-----------------------------------------------------*/
		add_action('wp_head', array( &$this, 'header'), 1);
		add_filter('the_content', array( &$this, 'page') );
		add_shortcode('collroll', array( &$this, 'shortcode_collroll') );
		add_action('wp_print_scripts', array( &$this, 'enqueue_scripts') );
		/*-----------------------------------------------------*/		
	}

} // end of class

?>