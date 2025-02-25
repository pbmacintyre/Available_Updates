<?php 
/*
 Plugin Name: Available Updates
 Plugin URI:  https://paladin-bs.com/plugins/
 Description: Plugin to add a simple menu item under the Plugins menu to take the admin user directly to the update plugins page.
 Author:      Peter MacIntyre
 Version:     1.4
 Author URI:  https://paladin-bs.com/peter-macintyre/
 Details URI: https://paladin-bs.com
 License:     GPL2 
 License URI: https://www.gnu.org/licenses/gpl-2.0.html

Available Updates is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Available Updates is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
See License URI for full details.

*/

function add_au_menu() {
		
    remove_submenu_page( 'plugins.php', 'plugins.php' ); // Plugins - Installed Plugins
    remove_submenu_page( 'plugins.php', 'plugin-install.php' ); // Plugins - Add New Plugins
    remove_submenu_page( 'plugins.php', 'plugin-editor.php' ); // Plugins - Editor
    
    $destination = "/plugins.php?plugin_status=upgrade" ;
	
	add_plugins_page (
			# add_plugins_page( $page_title, $menu_title, $capability, $menu_slug);
			# add_plugins_page automatically adds this menu item as a sub-menu item to the plugins menu
			'Available Updates',
			'Available Updates',
			'manage_options', // if manage_sites only super admin can see it even if activated.
			$destination );
	
	add_plugins_page('Installed Plugins', 'Installed Plugins', 'manage_options', 'plugins.php');
	add_plugins_page('Add New', 'Add New', 'manage_options', 'plugin-install.php');
	add_plugins_page('Editor', 'Editor', 'manage_options', 'plugin-editor.php');	
}

add_action('admin_menu', 'add_au_menu');

add_filter('plugin_row_meta', 'available_updates_add_plugin_links', 10, 2);

//Add a link on the plugin control line after 'view details' 
function available_updates_add_plugin_links($links, $file) {
    if ( $file == plugin_basename(dirname(__FILE__).'/available-updates.php') ) {
        // $links[] = '<a href="https://duplicate-post.lopo.it/">' . esc_html__('Documentation', 'duplicate-post') . '</a>';
        $links[] = '<a href="https://paladin-bs.com/plugin-donation/" target="_blank">' . esc_html__('Donate', 'available-updates') . '</a>';
    }
    return $links;
}
/* ============================= */
/* redirect admin login directly */ 
/* to the Available Updates page */ 
/* saves another click !         */
/* ============================= */

function admin_login_landing($username, $user){
    if(array_key_exists('administrator', $user->caps)){
        wp_redirect(admin_url('plugins.php?plugin_status=upgrade'));
        exit;
    }
}
add_action('wp_login', 'admin_login_landing', 10, 2);
