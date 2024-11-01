<?php
/*
Plugin Name: wpSermons
Plugin URI: http://www.peteranglea.com/wpsermons/
Description: WordPress plugin for publishing recorded mp3 sermons on the web via a church website.
Version: 0.8.2
Author: Peter Anglea
Author URI: http://www.peteranglea.com
*/

/*  Copyright 2007  Peter Anglea  (email : peter@peteranglea.com)

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
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

global $wpdb;
$table_name = $wpdb->prefix."wpsermons";


function wpsermons_add_menu_pages(){
		add_management_page('Sermon Management', 'Sermons', 8, 'wpsermons/managesermons.php');
}
function wpsermons_install(){
		include_once("installsql.php");
		wpsermons_installsql();
}

add_action('admin_menu', 'wpsermons_add_menu_pages');
add_action('activate_wpsermons/wpsermons.php', 'wpsermons_install');

function wpsermons_show_sermons(){
				include_once("showsermons.php");
				}

function wpsermons_get_sermons ($content) {
  $content = preg_replace_callback('/\[sermons]/', 'wpsermons_show_sermons', $content);
  return $content;
}

add_filter('the_content', 'wpsermons_get_sermons');
//add_action('deactivate_wpsermons/wpsermons.php', 'wpsermons_uninstall');
?>