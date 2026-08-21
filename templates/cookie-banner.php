<?php

defined('ABSPATH') || exit;

$site_name = !empty(get_bloginfo()) ? get_bloginfo() : "this site"; 
$site_url = get_home_url();
/* */
$display_cookie_banner = 1;

if ($display_cookie_banner) {
?>
<div id="cookie-compliance-banner" data-nosnippet="true" class="cc:print:hidden cc:text-black cc:dark:text-white cc:bg-gray-200 cc:dark:bg-neutral-700 cc:w-full cc:py-[1rem] cc:hidden cc:box-border cc:[&_*]:box-border">
    <div class="cc:mx-auto cc:w-[var(--cookie-banner-container-width,960px)] cc:max-w-[var(--cookie-banner-container-max-width,90%)]">
        <h2 class="cc:text-2xl cc:font-bold cc:!mt-0 cc:!mb-4">
            Cookies on <?php echo esc_html($site_name);?>
        </h2>
        <div class="cc:text-lg">
            <p class="cc:!mt-0 cc:!mb-4">
                We use some essential cookies to make this service work.
            </p>
            <p class="cc:!mt-0 cc:!mb-4">
                We’d also like to use analytics cookies so we can understand how you use the service and make improvements.
            </p>
        </div>
        <div>
            <button
                id="cookie-accept" type="submit"
                class="cc:text-white cc:bg-green-900 cc:hover:bg-green-950 cc:dark:bg-green-800 cc:dark:hover:bg-green-700
                    cc:font-medium cc:text-lg cc:px-5 cc:py-2.5 cc:me-2 cc:!mb-2 cc:cursor-pointer
                    cc:focus:text-black cc:focus:bg-yellow-400 cc:dark:focus:bg-yellow-400 cc:focus:outline-hidden
                    cc:w-full cc:sm:w-auto
                "
            >
                Accept analytics cookies
            </button>
            <button
                id="cookie-decline" type="submit"
                class="cc:text-white cc:bg-green-900 cc:hover:bg-green-950 cc:dark:bg-green-800 cc:dark:hover:bg-green-700
                    cc:font-medium cc:text-lg cc:px-5 cc:py-2.5 cc:me-2 cc:!mb-2 cc:cursor-pointer
                    cc:focus:text-black cc:focus:bg-yellow-400 cc:dark:focus:bg-yellow-400 cc:focus:outline-hidden
                    cc:w-full cc:sm:w-auto
                "
            >
                Reject analytics cookies
            </button>
            <a
                href="<?php echo esc_url($site_url);?>/cookies" id="cookie-page-link"
                class="cc:cookie-link
                    cc:text-sky-700 cc:dark:text-sky-300 cc:focus:bg-yellow-400 cc:hover:text-sky-900 cc:dark:hover:text-sky-200 cc:focus:text-black
                    cc:text-lg cc:underline cc:focus:no-underline cc:focus:outline-hidden
                    cc:px-3 cc:py-2.5
                    cc:inline-block cc:w-full cc:sm:w-auto cc:text-center
                "
            >
                View cookies
            </a>
        </div>
    </div>
</div>

<?php //*/
}
