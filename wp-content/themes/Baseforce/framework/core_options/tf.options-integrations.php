<?php

/**
 * Load Accordion UI on Reservations Page
 *
 */
function themeforce_integrations_scripts() {

    wp_enqueue_script( 'jquery-ui-accordion' );

}

if (isset($_GET['page']) && $_GET['page'] == 'themeforce_integrations') {

    add_action( 'admin_print_scripts', 'themeforce_integrations_scripts' );

}

/**
 * Display Reservations Options
 *
 */
function themeforce_integrations_page() {

    ?>

<div class="wrap accordion-wrap">

    <p>We have a number of reservation and online ordering integrations going live in the coming weeks, in the meantime, <a href="http://<?php echo DOMAIN_CURRENT_SITE; ?>/contact-us/" target="_blank">let us know</a> who you already use.</p>

    <h3>Online Reservations</h3>

        <!-- not translated yet, still need to finalize -->

        <div class="accordion">
            <!-- Display Checked if Venue ID in -->

            <div class="accordion-header">
            <a class="accordion-expand  accordion-<?php if ( get_option('tf_opentable_id') != '' ) { echo 'checked'; } else { echo 'unchecked'; } ?>" href="#">OpenTable</a>
                <div class="accordion-desc">USA & 18 Countries</div>
                <!--  <div class="accordion-link"><a href="http://www.opentable.com" target="_blank">Sign-up</a></div> -->
            </div>
            <div class="accordion-content"><?php themeforce_opentable_page(); ?></div>

            <!-- Display Checked if API & Phone in -->

            <div class="accordion-header">
                <a class="accordion-expand  accordion-<?php if ( get_option('tf_localina_api') && get_option('tf_localina_phone') ) { echo 'checked'; } else { echo 'unchecked'; } ?>" href="#">Localina</a>
                <div class="accordion-desc">Switzerland</div>
                <!--  <div class="accordion-link">Sign-up</div> -->
            </div>
            <div class="accordion-content"><?php themeforce_localina_page(); ?></div>

        </div>

        <h3>Online Ordering</h3>

        <div class="accordion">

            <div class="accordion-header">
                <a class="accordion-expand  accordion-<?php if ( get_option('tf_grubhub_id') ) { echo 'checked'; } else { echo 'unchecked'; } ?>" href="#">GrubHub</a>
                <div class="accordion-desc">USA</div>
            </div>
            <div class="accordion-content"><?php themeforce_grubhub_page(); ?></div>

        </div>

        <div class="accordion">

            <div class="accordion-header">
                <a class="accordion-expand  accordion-<?php if ( get_option('tf_opendining_app_id') && get_option('tf_opendining_rest_id') ) { echo 'checked'; } else { echo 'unchecked'; } ?>" href="#">Open Dining</a>
                <div class="accordion-desc">Global & Free Plans</div>
               <!--  <div class="accordion-link">More Information</div> -->
            </div>
            <div class="accordion-content"><?php themeforce_opendining_page(); ?></div>

        </div>

        <h3>Other</h3>

        <div class="accordion">

            <?php if ( tf_is_premium_active() ): ?>
                <div class="accordion-header">
                    <a class="accordion-expand  accordion-<?php if ( get_option('tf_ua_analytics') ) { echo 'checked'; } else { echo 'unchecked'; } ?>" href="#">Google Analytics</a>
                    <div class="accordion-desc"></div>
                </div>
                <div class="accordion-content"><?php themeforce_analytics_page(); ?></div>
            <?php endif; ?>

            <div class="accordion-header">
                <a class="accordion-expand  accordion-<?php if ( get_option('tf_googleapps') ) { echo 'checked'; } else { echo 'unchecked'; } ?>" href="#">Google Apps & Webmaster</a>
                <div class="accordion-desc"></div>
            </div>
            <div class="accordion-content"><?php themeforce_google_page(); ?></div>

            <div class="accordion-header">
                <a class="accordion-expand  accordion-<?php if ( get_option('tf_mailchimp_api_key') ) { echo 'checked'; } else { echo 'unchecked'; } ?>" href="#">MailChimp</a>
                <div class="accordion-desc">Global & Free Plans</div>
                <!-- <div class="accordion-link">More Information</div> -->
            </div>
            <div class="accordion-content"><?php themeforce_mailchimp_page(); ?></div>

        </div>

    </div>

    <script>

        jQuery(document).ready(function() {
            jQuery(".accordion").accordion({ active: false, collapsible: true, autoHeight: false});
        });

    </script>
    <?php


}

?>