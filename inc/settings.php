<?php

defined("ABSPATH") || exit();

function cookie_compliance_scripts()
{
	wp_register_style(
		"cookie-compliance-tailwind",
		plugins_url("../dist/tailwind.css", __FILE__),
		[],
		COOKIE_COMPLIANCE_VERSION,
	);
	wp_enqueue_style("cookie-compliance-tailwind");

	wp_register_style(
		"cookie-compliance-styles",
		plugins_url("../dist/styles.css", __FILE__),
		[],
		COOKIE_COMPLIANCE_VERSION,
	);
	wp_enqueue_style("cookie-compliance-styles");

	wp_register_script(
		"cookie-consent-script",
		plugins_url("../dist/cookie-script.js", __FILE__),
		[],
		COOKIE_COMPLIANCE_VERSION,
	);

	$options = get_option("cookie_compliance_settings");

	wp_localize_script("cookie-consent-script", "cookie_consent_object", [
		"gtmcode" => $options["gtm_code"],
		"isSsl" => (int) is_ssl(),
	]);
	wp_enqueue_script("cookie-consent-script");
}

// Register query variable for endpoint
function cookie_compliance_register_query_vars($vars)
{
	$vars[] = "cookie_settings_page";
	return $vars;
}
add_filter("query_vars", "cookie_compliance_register_query_vars");

// Add rewrite rule for endpoint
function cookie_compliance_rewrite_rule()
{
	$options = get_option("cookie_compliance_settings");
	if (!empty($options) && array_key_exists("gtm_code", $options) && !empty($options["gtm_code"])) {
		add_rewrite_rule('^(?!.*-)\bcookies\b$', "index.php?cookie_settings_page=true", "top");
		add_action("template_redirect", "cookie_compliance_template_redirect");
		add_action("wp_body_open", "cookie_compliance_render_banner", 11);
		add_action("wp_enqueue_scripts", "cookie_compliance_scripts");
	}
}
add_action("init", "cookie_compliance_rewrite_rule");

// Handle the custom endpoint
function cookie_compliance_template_redirect()
{
	global $wp_query;

	if (isset($wp_query->query_vars["cookie_settings_page"])) {
		// Load specific template file
		include plugin_dir_path(dirname(__FILE__)) . "templates/cookie-settings-page.php";
		exit();
	}
}

function cookie_compliance_render_banner()
{
	include plugin_dir_path(dirname(__FILE__)) . "templates/cookie-banner.php";
}
