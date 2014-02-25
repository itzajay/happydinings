<?php
/*
 * Opendining Integration
 * ---------------------------------------------
 *
 * This is a pretty light integration to see how visitors will use it. Similar to Yelp, the feature
 * will degrade for mobile (not self-hosting for now, though code here: github.com/opendining/opendining-mobile)
 *
*/


/**
 * Returns JS Drop-in for Open Dining (fixed position button) for Desktop
 *
 * @return string DOM output
 */
function tf_localina_desktop() {

        // A/B Testing

        if ( date('j') % 2 ) { // day of month will likely be less biased then day of week, or hour of day.
            //even
        } else {
            //odd
        }

        // Arguments

        $args = array(

            "tracklinks" => false,
            "mp_target" => "a#cta-header",
            "mp_name" => "Clicked Call to Action (Main)",
            "partner" => "localina",
            "revenue_type" => "reservations",
            "placement" => "header",
            "device" => "desktop",
            "headline" => "Online Reservation",
            "color" => "default"

        );

        $api = trim(get_option(tf_localina_api));
        $phone = trim(get_option(tf_localina_phone));

        // Trigger Localine Fancybox after MixPanel hit

        $args['eval'] = "Localina.startBooking( '" . $phone . "', '" . $api . "', 'de' );";

        // Display

        ?>

        <a id="cta-header" class="cta-desktop cta-<?php echo $args["color"]; ?>">
            <span class="cta-icon icon-event"></span> <span class="cta-headline"><?php echo $args["headline"]; ?></span>
        </a>

        <script>mixpanel.track("Viewed Page");</script>

        <?php tf_cta_mixpanel($args); ?>

        <div class="clearfix"></div>

        <?php

}

if ( get_option( 'tf_localina_enabled' ) == 'true') {

    add_action( 'tf_body_desktop_cta', 'tf_localina_desktop', 12);

}

/**
 * Returns JS Drop-in for Open Dining (fixed position button) for Mobile
 *
 * @return string DOM output
 */
function tf_localina_mobile() {

    // Arguments

    $args = array(

        "tracklinks" => false,
        "mp_target" => "a.cta-mobile",
        "mp_name" => "Clicked Call to Action (Main)",
        "partner" => "localina",
        "revenue_type" => "reservations",
        "placement" => "header",
        "device" => "mobile",
        "headline" => "Online Reservation",
        "color" => "default"

    );

    $api = trim(get_option(tf_localina_api));
    $phone = trim(get_option(tf_localina_phone));

    // Trigger Localine Fancybox after MixPanel hit

    $args['eval'] = "Localina.startBooking( '" . $phone . "', '" . $api . "', 'de' );";

    // Display

    if ( get_option( 'tf_localina_enabled' ) == 'true') {

            ?>

            <a class="cta-mobile cta-<?php echo $args["color"]; ?>">
                <span class="cta-icon icon-event"></span> <span class="cta-headline"><?php echo $args["headline"]; ?></span>
            </a>

            <div class="clearfix"></div>

            <script>mixpanel.track("Viewed Page");</script>

            <?php tf_cta_mixpanel($args); ?>

            <?php

        }

}

if ( get_option( 'tf_localina_enabled' ) == 'true') {

    add_action( 'tf_body_mobile_cta', 'tf_localina_mobile', 12);

}

/**
 * Load Localina JS if active
 */
function load_localina_js() {

    wp_enqueue_script('localina', 'http://localina.com/code/localina.js', array('jquery'), TF_VERSION );

}

if ( get_option( 'tf_localina_enabled' ) == 'true') {

    add_action( 'wp_print_scripts', 'load_localina_js');

}