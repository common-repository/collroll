<?php
/*
Plugin Name: 	Collapsing Blogroll
Plugin URI: 	http://slopjong.de/2009/01/13/collapsing-blogroll/
Description:  	Output the built-in blogroll where the shortcode [collroll] is placed in the post/page. The categories can be collapsed.
Author: 		Romain Schmitz
Author URI: 	http://slopjong.de
License:     	GNU General Public License
Last Change: 	19.4.2009
Version: 		0.4

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

/******************************
 TODOS
 
  - font color
done  - link description
  - colums to show blogroll links (asked by ramon)
  - sidebar widget ( -> Collapsing Links )
  - default colors related to h1, h2, h3 from css (asked by misterjaytee)
done  - target the links to a new window
  - excluding categories
done  - link cat descriptions (asked by Chris Taylor)
  
 ******************************/

define('COLLROLL_VERSION',"0.6");

// TODO: Rename the constants to COLLROLL_XXXX
define('COLLROLL_FOLDER', dirname(plugin_basename(__FILE__)));
define('COLLROLL_URLPATH', get_option('siteurl').'/wp-content/plugins/' . COLLROLL_FOLDER.'/');

require_once(dirname(__FILE__) . '/colorpicker/colorpicker.php');
require_once(dirname(__FILE__) . '/settings.php');
require_once(dirname(__FILE__) . '/backend.php');
require_once(dirname(__FILE__) . '/frontend.php');

if ( is_admin() )
{
	if ( class_exists('Collroll_Backend') )
	{
		$backend = new Collroll_Backend();
		register_activation_hook( __FILE__, array( &$backend, 'activate') );
	}
}
else
{
	if ( class_exists('Collroll_Frontend') )
		$frontend = new Collroll_Frontend();
}

?>
