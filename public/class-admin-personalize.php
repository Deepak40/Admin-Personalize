<?php

/**
 * Admin Personalize Class
 *
 * This class should be used to work with the
 * public-facing side of the WordPress site.
 */
class Admin_Personalize {

    /**
     * Plugin version, used for cache-busting of style and script file references and db upgrades.
     *
     * @since  1.0
     *
     * @var    string
     */
    const VERSION = '1.0';

    /**
     * Unique identifier for your plugin.
     *
     * The variable name is used as the text domain when internationalizing strings
     * of text. Its value should match the Text Domain file header in the main
     * plugin file.
     *
     * @since  1.0
     *
     * @var    string
     */
    protected $plugin_slug = 'admin-personalize';

    /**
     * Instance of this class.
     *
     * @since  1.0
     *
     * @var    object
     */
    protected static $instance = null;

    /**
     * Constructor
     *
     * @since  1.0
     */
    private function __construct() {
	add_action('init', array($this, 'load_plugin_textdomain'));

	// Name and email filter
	add_filter('admin_personalize_from_name', array($this, 'admin_personalize_from_name'), 100);
	add_filter('admin_personalize_from', array($this, 'admin_personalize_from'), 100);
    }

    /**
     * Return an instance of this class.
     *
     * @since   1.0
     *
     * @return  object  A single instance of this class.
     */
    public static function get_instance() {

	// If the single instance hasn't been set, set it now.
	if (null == self::$instance) {
	    self::$instance = new self;
	}

	return self::$instance;
    }

    /**
     * Return the plugin slug.
     *
     * @since   1.0
     *
     * @return  Plugin slug variable.
     */
    public function get_plugin_slug() {
	return $this->plugin_slug;
    }

    /**
     * Load Text Domain Language Support
     *
     * @since  1.0
     */
    public function load_plugin_textdomain() {
	$plugin_basename = plugin_basename(plugin_dir_path(__DIR__) . $this->plugin_slug . '.php');
	load_plugin_textdomain('admin-personalize', false, dirname($plugin_basename) . '/languages/');
    }

    /**
     * Filter: admin_personalize_from_name
     *
     * @since   1.0
     *
     * @param   string  $name  Default name.
     * @return  string         WP Mail From name.
     */
    public function admin_personalize_from_name($name) {
	$admin_personalize_name = get_option('admin_personalize_name', '');
	if (!empty($admin_personalize_name) && !$this->is_default_from_name($admin_personalize_name)) {
	    return $admin_personalize_name;
	}
	return $name;
    }

    /**
     * Filter: admin_personalize_from
     *
     * @since   1.0
     *
     * @param   string $name  Default email.
     * @return  string        WP Mail From email.
     */
    public function admin_personalize_from($email) {
	$admin_personalize_email = get_option('admin_personalize_email', '');
	if (!empty($admin_personalize_email) && is_email($admin_personalize_email)) {
	    $override_default = get_option('admin_personalize_override_default', 0);
	    $override_admin = get_option('admin_personalize_override_admin', 0);

	    if ($override_default == 1 && $this->is_default_from($email)) {
		return $admin_personalize_email;
	    }
	    if ($override_admin == 1 && $this->is_admin_from($email)) {
		return $admin_personalize_email;
	    }
	}
	return $email;
    }

    /**
     * Is Default From Name
     *
     * Checks to see if the name is the default name assigned by WordPress.
     * This is defined in admin_personalize() in wp-includes/pluggable.php
     *
     * @since   1.0
     *
     * @param   string   $name  Name to check.
     * @return  boolean
     */
    public function is_default_from_name($name) {
	if ($name == 'WordPress')
	    return true;
	return false;
    }

    /**
     * Is Default From Email
     *
     * @since   1.0
     *
     * @param   string   $email  Email to check.
     * @return  boolean
     */
    public function is_default_from($email) {
	$default_email = $this->get_default_from();
	if ($email == $default_email)
	    return true;
	return false;
    }

    /**
     * Get Default From Email
     *
     * Checks to see if the email is the default address assigned by WordPress.
     * This is defined in admin_personalize() in wp-includes/pluggable.php
     *
     * The 'admin_personalize_default_from' filter is provided so you can add compatibility when
     * the pluggable admin_personalize() function is altered to use a different default email address.
     *
     * Also note, some hosts may refuse to relay mail from an unknown domain. See
     * http://trac.wordpress.org/ticket/5007
     *
     * @since   1.0
     *
     * @return  string  Default from email.
     */
    public function get_default_from() {
	$sitename = strtolower($_SERVER['SERVER_NAME']);
	if (substr($sitename, 0, 4) == 'www.') {
	    $sitename = substr($sitename, 4);
	}
	return apply_filters('admin_personalize_default_from', 'wordpress@' . $sitename);
    }

    /**
     * Is Admin From Email
     *
     * Checks to see if the email is the admin email address set in the WordPress options.
     *
     * Also note, some hosts may refuse to relay mail from an unknown domain. See
     * http://trac.wordpress.org/ticket/5007
     *
     * @since   1.0
     *
     * @param   string   $email  Email to check.
     * @return  boolean
     */
    public function is_admin_from($email) {
	$admin_email = get_option('admin_email');
	if ($email == $admin_email)
	    return true;
	return false;
    }

    /**
     * Register Activation
     *
     * Called when plugin is activated. Not called when plugin is auto-updated.
     *
     * @since  1.0
     */
    public static function activate() {

	// Copy values from original WP MailFrom if present and plugin optionsnot yet set.
	// http://wordpress.org/plugins/wp-mailfrom/
	$name = get_option('site_mail_from_name', '');
	$email = get_option('site_mail_from_email', '');
	$new_name = get_option('admin_personalize_name', '');
	$new_email = get_option('admin_personalize_email', '');

	if (!empty($name) && empty($new_name))
	    $name_updated = add_option('admin_personalize_name', $name);
	if (!empty($email) && empty($new_email))
	    $email_updated = add_option('admin_personalize_email', $email);
    }

}