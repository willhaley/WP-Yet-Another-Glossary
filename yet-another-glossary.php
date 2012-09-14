<?php

/**
 * @package yet-another-glossary
 */
/*
Plugin Name: ABT Ext Tooltips / Glossary
Plugin URI:  http://thefifthone.com/wordpress-plugins/yet-another-glossary
Description: Simple Definition / Glossary Plugin.
Version: 1.0.3
Author:  Will Haley, ABT
Author URI: http://atlanticbt.com
*/
/*
 This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

require_once("yag-functions.php");

add_action('admin_menu', 'yaggerfy_the_admin');

add_action('wp_head', 'yagged_in_the_hEEd');
add_action('the_content','yaggerfy_words');
add_action('the_content','yaggerfy_page');
add_action('wp_footer','yagger_up_js');

?>