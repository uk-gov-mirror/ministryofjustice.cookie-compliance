<?php

/*
Plugin Name: Cookie Compliance
Plugin URI: https://github.com/ministryofjustice/cookie-compliance
Description: Cookie consent banner
Version: 1.3.5
Author: Ministry of Justice
Author URI: https://github.com/ministryofjustice
Text Domain: cookie-compliance
Domain Path: /languages
License: MIT

*/

defined('ABSPATH') || exit;

// Define the plugin version - to clear asset cache on plugin updates.
define('COOKIE_COMPLIANCE_VERSION', get_file_data(__FILE__, array('Version' => 'Version'), false)['Version']);

include 'inc/settings.php';

include 'inc/admin-page.php';

register_activation_hook( __FILE__, 'cookie_compliance_flush_rewrite_rules' );

function cookie_compliance_flush_rewrite_rules() {
    cookie_compliance_rewrite_rule();
    flush_rewrite_rules();
}
