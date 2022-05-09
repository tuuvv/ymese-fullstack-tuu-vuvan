<?php
/**
 * Plugin Name: unittest
*/

add_action('admin_notices', function(){
    printf('<div class="notice notice-success"><p>Meaning of life?</p></div>');
}); 

global $plugintestdir;
$plugintestdir = untrailingslashit(plugin_dir_path(__FILE__));

// include_once $plugintestdir . '/simple_html_dom.php';
