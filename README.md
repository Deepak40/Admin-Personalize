# Admin-Personalize

Allows you to configure WordPress logo on login and register page and WordPress icon on WordPress dashboard, Remove WordPress setup version number, Hide WordPress Admin Bar and configure the default email address and name used for emails sent by WordPress.

Description
------------

1. This plugin allows you to set the email address and name used on email sent by WordPress by setting the *From:* header.

It is an updated and fully re-worked version of the [WP Mail From](http://wordpress.org/extend/plugins/wp-mailfrom/) plugin by Tristan Aston and now works with the latest versions of WordPress.

2. This plugin allows you to configure the WordPress logo on login and register page by setting the *Wordpress Logo:* header.

3. This plugin allows you to configure the WordPress icon on Dashbord by setting the *Wordpress icon:* header.

4. This plugin allows you to remove version no of WordPress by setting the *Remove Wordpress setup Information:* header.

5. This plugin allows you to hide Admin Bar from WordPress frontend.

6. This plugin allows you to change width of WordPress custom logo on login panel.

* Adds a "Admin Personalize" section in the "Settings" menu.
* The plugin uses the filter hooks `admin_personalize_from` and `admin_personalize_from_name`.
* The priority for the hooks is set to 1 to allow for other plugins that may hook these with the default priority of 10 to override this plugin.

Installation
------------

Either install via the WordPress admin plugin installer or...

1. Unzip `admin-personalize.zip` in the `/wp-content/plugins/` directory, making sure the folder is called `admin-personalize`.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Visit the admin settings page `Settings > Admin Personalize` and save your preferred name and email address.


Upgrading from the old WP Mail From plugin
------------------------------------------

This version is pretty much a complete re-write, fixes loads of bugs and works with the most recent versions of WordPress.

If upgrading from the [WP Mail From](http://wordpress.org/extend/plugins/wp-mailfrom/) plugin your current name an email settings should be copied across but please check.
To upgrade simply activate this plugin then deactivate the old WP Mail From plugin.

You should now use:

`get_option( 'admin_personalize_name' );
get_option( 'admin_personalize_email' );`


Frequently Asked Questions
--------------------------

How can I change width of WordPress logo on WordPress login panel?

By changing of width of WordPress custom Logo you can change width of logo on login panel. Default it's set to 84px as WordPress default logo.


Why does the From address still show as the default or show up as 'sent on behalf of' the default address?

Possibly your mail server has added a *Sender:* header or is configured to always set the *envelope sender* to the user calling it.


Why are emails not being sent?

Some hosts may refuse to relay mail from an unknown domain. See [http://trac.wordpress.org/ticket/5007](http://trac.wordpress.org/ticket/5007) for more details.


Changelog
---------

### 1.1

* Add options to change width of WordPress logo on login panel.

### 1.0

* Add options to override default WordPress email address and admin email address.
* Add option to configure the WordPress logo on login and register page and WordPress icon on WordPress Dashboard.
* Add option to hide WordPress version number and prevent online tools to detect your website is a Wordpress site.
* Add option to hide WordPress admin bar from frontend.
