<?php

defined('ABSPATH') || exit;

// Block (FSE) themes have no header.php or footer.php, so get_header() and
// get_footer() fall through to wp-includes/theme-compat/*.php and render the
// old Kubrick markup. Build the document ourselves in that case.

if (!function_exists('cookie_compliance_block_part')) {
    // Return the rendered HTML for a block theme's header or footer template
    // part. Themes don't always name them plain 'header' and 'footer' (govwind
    // uses 'header-default'), so fall back to whatever theme.json declares for
    // the area.
    function cookie_compliance_block_part($area) {
        $part = get_block_template(get_stylesheet() . '//' . $area, 'wp_template_part');

        if (!$part) {
            $parts = get_block_templates(array('area' => $area), 'wp_template_part');
            $part = !empty($parts) ? $parts[0] : null;
        }

        return ($part && !empty($part->content)) ? do_blocks($part->content) : '';
    }
}

$is_block_theme = function_exists('wp_is_block_theme') && wp_is_block_theme();
$support_dark_mode = false;

if ($is_block_theme) {

    // Assume all block themes support dark mode and non-block themes don't
    $support_dark_mode = true;

    // Render the template parts before <head>, so blocks inside them can still
    // enqueue their styles in wp_head(). Core does the same in
    // wp-includes/template-canvas.php.
    $header_html = cookie_compliance_block_part('header');
    $footer_html = cookie_compliance_block_part('footer');
    ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php
    wp_body_open();
    // Classic themes such as Hale already open <main> in header.php.
    echo '<div class="wp-site-blocks"><header class="wp-block-template-part">' . $header_html . '</header><main lang="en" class="wp-block-group has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" style="margin-top: 0; padding-top: var(--wp--preset--spacing--60); padding-bottom: var(--wp--preset--spacing--60);">';
} else {
    get_header();
}
?>

<div id="cookie-settings-page" class="<?= esc_attr(apply_filters('cookie_compliance_settings_page_class', 'cc:px-3 cc:text-lg')) ?>">
    <div id="cookie-settings-confirmation" class="cc:mt-8 cc:mb-8 cc:hidden cc:w-full cc:w-max-[666px] <?php if ($support_dark_mode) echo "cc:!dark:text-white"; ?>">
    <div class="cc:bg-green-800 cc:border-solid cc:border-4 cc:border-green-800 <?php if ($support_dark_mode) echo "cc:dark:bg-[#429b34] cc:dark:border-[#429b34]";?>" role="alert">
        <div>
        <h2 class="cc:!text-white cc:text-lg cc:pt-[5px] cc:pb-[5px] cc:pl-[20px] cc:!m-0 has-text-color <?php if ($support_dark_mode) echo "cc:dark:text-black"; ?>">Success</h2>
        </div>
        <div class="cc:bg-white cc:p-[20px] <?php if ($support_dark_mode) echo "cc:dark:bg-neutral-700"; ?> ">
            <p class="cc:!m-0 cc:font-bold">
                You&rsquo;ve set your cookie preferences.
                <a id="cookie-confirmation-return" class='cc:hidden' href='#'>
                    Go back to the page you were looking at.
                </a>
            </p>
        </div>
    </div>
    </div>

    <h1 class="wp-block-heading">Cookies</h1>
    <p class="cc:w-full cc:w-max-[666px]">
        Cookies are small files saved on your computer, tablet or phone when you visit a website.
    </p>

    <p class="cc:w-full cc:w-max-[666px]">
        We use cookies to make this site work and collect information about how you use our service.
    </p>

    <h2 class="wp-block-heading">Essential cookies</h2>

    <p class="cc:w-full cc:w-max-[666px]">
        Essential cookies keep your information secure whilst you use this service.  We do not need to ask permission to use them.
    </p>
    <div class="cc:overflow-x-auto">
        <table class="cc:w-full cc:text-left cc:border-collapse cc:min-w-[500px]">
            <thead>
                <tr>
                    <th scope="col" class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        Cookie name
                    </th>
                    <th scope="col" class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        Purpose
                    </th>
                    <th scope="col" class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0 cc:whitespace-nowrap">
                        Expires
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr data-cookiename="cookie_consent">
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0 cc:whitespace-nowrap">
                        cookie_consent
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        This remembers your cookie consent decision
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        1 year
                    </td>
                </tr>
                <tr data-cookiename="wordpress_test_cookie">
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0 cc:whitespace-nowrap">
                        wordpress_test_cookie
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        This is used to test if your browser accepts cookies
                    </td>
                    <td class="cc:min-w-[75px] cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        When you close your browser
                    </td>
                </tr>
                <tr data-cookiename="PHPSESSID">
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0 cc:whitespace-nowrap">
                        PHPSESSID
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        This is used to link your device to the information sent to the server from your browser. It is typically used to avoid you having to retype information when moving from one page to another
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        When you close your browser
                    </td>
                </tr>
                <tr data-cookiename="info_banner_dismissed">
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0 cc:whitespace-nowrap">
                        info_banner_dismissed
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        This remembers if you've dismissed an information banner and prevents it from being displayed again
                    </td>
                    <td class="cc:min-w-[75px] cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        When you close your browser
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <h3 class="wp-block-heading">Logged-in users</h3>

    <p class="cc:w-full cc:w-max-[666px]">
        We use additional essential cookies that only apply to users who sign in to access our service.
    </p>

    <div class="cc:overflow-x-auto">
        <table class="cc:w-full cc:text-left cc:border-collapse cc:min-w-[500px]">
            <thead>
                <tr>
                    <th scope="col" class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        Cookie name
                    </th>
                    <th scope="col" class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        Purpose
                    </th>
                    <th scope="col" class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0 cc:whitespace-nowrap">
                        Expires
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr data-cookiename="wordpress_logged_in">
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0 cc:whitespace-nowrap">
                        wordpress_logged_in_[hash]
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        This shows the site that you’re signed in and who you are so you can access the functions you need
                    </td>
                    <td class="cc:min-w-[75px] cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        When you close your browser or when you sign out
                    </td>
                </tr>
                <tr data-cookiename="wordpress_sec">
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0 cc:whitespace-nowrap">
                        wordpress_sec_[hash]
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        If you are logged in as a site admin, this stores your authentication details
                    </td>
                    <td class="cc:min-w-[75px] cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        When you close your browser or when you sign out
                    </td>
                </tr>
                <tr data-cookiename="wp-settings-">
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0 cc:whitespace-nowrap">
                        wp-settings-{time}-[UID]
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        The number on the end [UID] is your individual user ID from the database of users
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        1 year
                    </td>
                </tr>
                <tr data-cookiename="wp_lang">
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0 cc:whitespace-nowrap">
                        wp_lang
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        This remembers language settings.
                    </td>
                    <td class="cc:min-w-[75px] cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        When you close your browser
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="wp-block-heading">Third-party cookies</h2>

    <h3 class="wp-block-heading">Video streaming</h3>
    <p class="cc:w-full cc:w-max-[666px]">
        We have no control over cookies set by third parties. You can turn them off, but not through us.
    </p>
    <h3 class="wp-block-heading">Social media</h3>
    <p class="cc:w-full cc:w-max-[666px]">
        If you share a link to a page, the service you share it on (for example, Facebook) may set a cookie.
    </p>

    <h2 class="wp-block-heading">Analytics cookies</h2>

    <p class="cc:w-full cc:w-max-[666px]">
        With your permission, we use
        <a class="cookie-link
            cc:text-sky-700 cc:dark:text-current cc:focus:bg-yellow-400 cc:hover:text-current cc:dark:hover:no-underline cc:focus:text-black cc:focus:bg-yellow
            cc:underline cc:focus:no-underline cc:focus:outline-hidden
            cc:focus:shadow-[0_-2px_oklch(0.852_0.199_91.936),0_4px_#000]
        " href="https://business.safety.google/privacy/">Google Analytics</a>
        to collect data about how you use
        this service.  This information helps us to improve our service.
    </p>

    <p class="cc:w-full cc:w-max-[666px]">
        We use Google Analytics in accordance with Google's data processing and privacy terms.
    </p>

    <p class="cc:w-full cc:w-max-[666px]">
        Google Analytics stores anonymised information about:
    </p>
    
    <ul class="cc:w-full cc:w-max-[666px]">
        <li>the pages you visit</li>
        <li>how long you spend on each page</li>
        <li>how you arrived at the site</li>
        <li>what you click on while you visit the site</li>
        <li>the device and browser you use</li>
    </ul>
    
    <div class="cc:overflow-x-auto">
        <table class="cc:w-full cc:text-left cc:border-collapse cc:min-w-[500px]">
            <thead>
                <tr>
                    <th scope="col" class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        Cookie name
                    </th>
                    <th scope="col" class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        Purpose
                    </th>
                    <th scope="col" class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0 cc:whitespace-nowrap">
                        Expires
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr data-cookiename="_ga">
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0 cc:whitespace-nowrap">
                        _ga
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        This is used to distinguish users and tell us if you have visited before
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        2 years
                    </td>
                </tr>
                <tr data-cookiename="_ga_">
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0 cc:whitespace-nowrap">
                        _ga_[hash]
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        This is used to persist session state
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        2 years
                    </td>
                </tr>
                <tr data-cookiename="_gid">
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0 cc:whitespace-nowrap">
                        _gid
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        This helps us count how many people visit by tracking if you have visited before
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        24 hours
                    </td>
                </tr>
                <tr data-cookiename="_gat_">
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0 cc:whitespace-nowrap">
                        _gat_[hash]
                    </td>
                    <td class="cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        This helps us manage how we collect analytics when we have lots of visitors on the site at one time
                    </td>
                    <td class="cc:min-w-[75px] cc:px-2 cc:md:px-6 cc:py-2 cc:md:py-3 cc:border-solid cc:border-t-0 cc:border-x-0 cc:border-b cc:border-current/90 cc:first:ps-0 cc:last:pe-0">
                        10 minutes
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="wp-block-heading">Change your cookie settings</h2>


    <div>
        <fieldset class="cc:border-none cc:!p-0 cc:mb-4">
            <legend class="cc:text-xl cc:font-bold cc:mb-4">
                Do you want to accept analytics cookies?
            </legend>
            <div id="analytical-cookies-control">
                <div class='cc:w-full cc:sm:w-[40%] cc:flex cc:flex-wrap cc:relative cc:mb-[10px] cc:last:mb-0'>
                    <input
                        id='accept-analytical-cookies'
                        class='cc:!w-[44px] cc:h-[44px] cc:m-0 cc:cursor-pointer cc:opacity-0 cc:[&:not(:checked)~*]:after:opacity-0 cc:[&:focus~*]:before:border-4 cc:[&:focus~*]:before:shadow-[0_0_0_4px_oklch(0.852_0.199_91.936)]'
                        type='radio'
                        name='analytical-cookie-options'
                        value='yes'
                    >
                    <label
                        for='accept-analytical-cookies'
                        class='cc:px-[7px] cc:py-[10px] cc:cursor-pointer cc:block cc:touch-manipulation cc:leading-[1.25]
                        cc:before:content-[""] cc:before:box-border cc:before:absolute cc:before:top-[2px] cc:before:left-[2px] cc:before:w-[40px] cc:before:h-[40px] cc:before:border-solid cc:before:border-2 cc:before:rounded-full cc:before:bg-transparent
                        cc:after:content-[""] cc:after:absolute cc:after:top-[12px] cc:after:left-[12px] cc:after:w-0 cc:after:h-0 cc:after:border-solid cc:after:border-10 cc:after:rounded-full cc:after:bg-black
                        '>
                        Yes
                    </label>
                </div>
                <div class='cc:w-full cc:sm:w-[40%] cc:flex cc:flex-wrap cc:relative cc:mb-[10px] cc:last:mb-0'>
                    <input
                        id='reject-analytical-cookies'
                        class='cc:!w-[44px] cc:h-[44px] cc:m-0 cc:cursor-pointer cc:opacity-0 cc:[&:not(:checked)~*]:after:opacity-0 cc:[&:focus~*]:before:border-4 cc:[&:focus~*]:before:shadow-[0_0_0_4px_oklch(0.852_0.199_91.936)]'
                        type='radio'
                        name='analytical-cookie-options'
                        value='no'
                    >
                    <label
                        for='reject-analytical-cookies'
                        class='cc:px-[7px] cc:py-[10px] cc:cursor-pointer cc:block cc:touch-manipulation cc:leading-[1.25]
                        cc:before:content-[""] cc:before:box-border cc:before:absolute cc:before:top-[2px] cc:before:left-[2px] cc:before:w-[40px] cc:before:h-[40px] cc:before:border-solid cc:before:border-2 cc:before:rounded-full cc:before:bg-transparent
                        cc:after:content-[""] cc:after:absolute cc:after:top-[12px] cc:after:left-[12px] cc:after:w-0 cc:after:h-0 cc:after:border-solid cc:after:border-10 cc:after:rounded-full cc:after:bg-black
                        '>
                        No
                    </label>
                </div>
            </div>
        </fieldset>
    </div>
    <input class="cc:hidden" type="text" name="previous" step="any" id="previous" value="">
    <button
        id="save-cookies-button" name="changes" type="submit" value="saved" data-module=""
        class="cc:text-white cc:bg-green-900 cc:hover:bg-green-950 cc:dark:bg-green-800 cc:dark:hover:bg-green-700
                cc:font-medium cc:text-lg cc:px-5 cc:py-2.5 cc:me-2 cc:mb-2 cc:cursor-pointer
                cc:focus:text-black cc:focus:bg-yellow-400 cc:dark:focus:bg-yellow-400 cc:focus:outline-hidden
                cc:w-full cc:sm:w-auto
            "
    >
        Save cookie settings
    </button>
</div>

<?php
if ($is_block_theme) {
    echo '</main>' . $footer_html . '</div>';
    wp_footer();
    echo '</body></html>';
} else {
    get_footer();
}

