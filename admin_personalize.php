<?php
/**
 * Plugin Name:        Admin Personalize
 * Plugin URI:         http://www.ranosys.com/
 * Description:        Allows you to configure WordPress logo on login and register page and WordPress icon on WordPress dashboard, Remove WordPress setup version number, Hide WordPress Admin Bar and configure the default email address and name used for emails sent by WordPress
 * Version:            1.0
 * Author:             Deepak Soni
 * Author URI:         https://github.com/Deepak40/
 * Text Domain:        admin-personalize
 * License:            GPL-2.0+
 * License URI:        http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:        /languages
 * GitHub Plugin URI:  https://github.com/Deepak40/Admin-Personalize
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Require public files
 */
require_once( plugin_dir_path(__FILE__) . 'public/class-admin-personalize.php' );

/**
 * Register hooks that are fired when the plugin is activated.
 */
register_activation_hook(__FILE__, array('Admin_Personalize', 'activate'));

/**
 * Init.
 */
add_action('plugins_loaded', array('Admin_Personalize', 'get_instance'));

/**
 * Only load admin functionality in admin.
 */
if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX )) {
    require_once( plugin_dir_path(__FILE__) . 'admin/class-admin-personalize-admin.php' );
    add_action('plugins_loaded', array('Admin_Personalize_Admin', 'get_instance'));
}

/**
 *  For Image Uploading
 *
 * @since  1.0
 */
function admin_personalize_image_upload_script() {
    if (empty($_GET['page']) || "admin-personalize" !== $_GET['page']) {
	return;
    }
    wp_enqueue_media();
    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('custom-script', plugins_url() . '/admin-personalize/assets/js/imageScript.js');
    wp_enqueue_script('custom-script');
}

add_action('admin_enqueue_scripts', 'admin_personalize_image_upload_script');

/**
 * Remove WordPress Version
 *
 * @since  1.0
 */

if (!empty(get_option('admin_personalize_remove_wp_version'))) {

function remove_wp_version() {
    return '';
}

add_filter('the_generator', 'remove_wp_version');
}

/**
 * Hide admin bar
 *
 * @since  1.0
 */

if (!empty(get_option('admin_personalize_hide_admin_bar'))) {

add_filter('show_admin_bar', '__return_false');

}

/**
 * Configure WordPress logo
 *
 * @since  1.0
 */

if (!empty(get_option('admin_personalize_configure_wp_logo'))) {


function admin_personalize_custom_wp_logo() {
    ?>
    <style type="text/css">
        body.login div#login h1 a {
    	background-image: url('<?php echo get_option('admin_personalize_configure_wp_logo'); ?>');  //Add your own logo image in this url
    	padding-bottom: 10px;
    	height:100px;
    	backgroun-size:100px;
        }
    </style>
    <?php
}

add_action('login_enqueue_scripts', 'admin_personalize_custom_wp_logo');

}

/**
 * Configure WordPress icon
 *
 * @since  1.0
 */


if (!empty(get_option('admin_personalize_configure_wp_icon'))) {

    function admin_personalize_custom_wp_icon() {
	?>
	<style type="text/css">
	    #wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
		background-image: url('<?php echo get_option('admin_personalize_configure_wp_icon'); ?>') !important;
		background-position: 0 0;
		background-size: 100%;
		color:rgba(0, 0, 0, 0);
	    }
	    #wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
		background-position: 0 0;
	    }
	</style>
	<?php
    }

    add_action('wp_before_admin_bar_render', 'admin_personalize_custom_wp_icon');
    
}  
