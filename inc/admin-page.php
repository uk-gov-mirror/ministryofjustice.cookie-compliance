<?php

defined("ABSPATH") || exit();

add_action("admin_menu", "cookie_compliance_settings_page");
add_action("admin_init", "cookie_compliance_settings_init");

function cookie_compliance_settings_page()
{
	add_options_page(
		"Cookie Compliance",
		"Cookie Compliance",
		"manage_options",
		"cookie-compliance",
		"cookie_compliance_plugin_settings",
	);
}

function cookie_compliance_settings_init()
{
	register_setting("cookie_compliance_plugin", "cookie_compliance_settings");
	add_settings_section(
		"cookie_compliance_settings_section",
		__("Settings", "wordpress"),
		"cookie_compliance_section_intro",
		"cookie_compliance_plugin",
	);

	add_settings_field(
		"gtm_code",
		__("GTM Code", "wordpress"),
		"cookie_compliance_input_field_render",
		"cookie_compliance_plugin",
		"cookie_compliance_settings_section",
		["field_id" => "gtm_code", "field_hint" => ""],
	);
}

function cookie_compliance_section_intro()
{
	echo __("", "wordpress");
}

function cookie_compliance_input_field_render($args)
{
	if (!empty($args) && array_key_exists("field_id", $args)) {

		$options = get_option("cookie_compliance_settings");
		$field_value = "";
		if (!empty($options) && array_key_exists($args["field_id"], $options)) {
			$field_value = $options[$args["field_id"]];
		}
		?>
        <input type="text" value="<?= $field_value ?>" name='cookie_compliance_settings[<?= $args["field_id"] ?>]'>
        <?php echo $args["field_hint"];
	}
}

function cookie_compliance_plugin_settings()
{
	$options = get_option("cookie_compliance_settings");

	if (!empty($options) && array_key_exists("gtm_code", $options) && !empty($options["gtm_code"])) {
		flush_rewrite_rules();
	}
	?>
    <h1>Cookie Compliance</h1>
    <form action='options.php' method='post'>
        
        <?php
        settings_fields("cookie_compliance_plugin");
        do_settings_sections("cookie_compliance_plugin");
        submit_button();?>

    </form>
    <?php
}
