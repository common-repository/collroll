<?php

// These are the default values of the option 'collroll' which is stored in the database
$collroll_default_options = array(
			'version' => COLLROLL_VERSION,
	
			// show the "Expand | Collapse" line?
			'sow_expand_collapse_line' => 'yes',
			
			// categories collapsed by default?
			'collapsed' => 'yes', 
			
			// width of the category title
			'width' => '100%', 
			
			// default colors for title and title background
			
			'color' => 'ffffff',
			'colorText' => '000000',
			
			// title size. By default the header size h4 is used which depends on your theme css.
			'category_title_size' => '',
		
			// Using the colors?
			'use_color' => 'yes',
			'use_color_text' => 'no',

			// Order of the categories
			'category_orderby' => 'name', // order | name | ... 

			// Order of the links
			'orderby' => 'name', // name | id | ...
			
			// Show description
			'show_description' => '0',
			
			// Seperator
			'between' => ' - ',
			
			// Show category description
			'show_category_description' => 'no',
			
			// Exclude categories
			'exclude_category' => '',
			
			// Show link preview?
			'show_link_preview' => 'no'
		);
		

// Not stored in the database. This means that modifications are overwritten by the next update.
$collroll_default_settings = array(	

			/* some are not used */
			
			'category_order' => 'ASC',
			'order' => 'ASC',
			
			'before' => '<li class="collroll_link_line"><span class="collroll_link">',
			'after'  => '</span></li>',
			
			'link_before' => '',
			'link_after' => '',
			
			'show_images' => 0,
			'limit' => -1, 
			'category' => '', 
			'category_name' => '', 
			'hide_invisible' => 1,
			'show_updated' => 0, 
			'echo' => 1,
			'categorize' => 1, 
			'title_li' => 'Bookmarks',
			'title_before' => '<h4>', 
			'title_after' => '</h4>',
			
			'class' => 'linkcat', 
			'category_before' => '',
			'category_after' => ''
		);

$collroll_default_translations = array(
			'expand_all' => 'Expand alles',
			'collapse_all' => 'Collapse alles'
		);
?>