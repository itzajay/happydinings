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
function tf_bf_opendining_desktop() {

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
            "partner" => "opendining",
            "revenue_type" => "onlineordering",
            "placement" => "header",
            "device" => "desktop",
            "headline" => "Order Online",
            "color" => "default"

        );

        $appid = trim(get_option(tf_opendining_app_id));
        $restid = trim(get_option(tf_opendining_rest_id));

        // Display

        ?>

        <a href="http://www.opendining.net/app/locations/<?php echo $appid; ?>" id="cta-header" class="cta-desktop cta-<?php echo $args["color"]; ?> thumb-iframe">
            <span class="cta-icon icon-cart"></span> <span class="cta-headline"><?php echo $args["headline"]; ?></span>
        </a>

        <script>
            //mixpanel.track("Viewed Page");

            jQuery(document).ready(function($) {

                var userAgent = navigator.userAgent.toLowerCase().indexOf("ipad");

                if (userAgent > -1) {
                    $("a#cta-header").unbind('click.fb').removeClass("thumb-iframe");
                    $("a#cta-header").attr("href","http://www.opendining.net/m/<?php echo $restid; ?>");
                }

            });
        </script>

        <?php //tf_cta_mixpanel($args); ?>

        <div class="clearfix"></div>

        <?php

}

if ( get_option( 'tf_opendining_enabled' ) == 'true') {

    add_action( 'tf_body_desktop_cta', 'tf_bf_opendining_desktop', 12);

}

/**
 * Returns JS Drop-in for Open Dining (fixed position button) for Mobile
 *
 * @return string DOM output
 */
function tf_bf_opendining_mobile() {

    $args = array(

        "tracklinks" => true,
        "mp_target" => "a.cta-mobile",
        "mp_name" => "Clicked Call to Action (Main)",
        "partner" => "opendining",
        "revenue_type" => "onlineordering",
        "placement" => "header",
        "device" => "mobile",
        "headline" => "Order Online",
        "color" => "default"

    );

    if ( get_option( 'tf_opendining_enabled' ) == 'true') {

            $restid = trim(get_option(tf_opendining_rest_id));

            ?>

            <a href="http://www.opendining.net/m/<?php echo $restid; ?>" class="cta-mobile cta-<?php echo $args["color"]; ?>">
                <span class="cta-icon icon-cart"></span> <span class="cta-headline"><?php echo $args["headline"]; ?></span>
            </a>

            <div class="clearfix"></div>

            <script>mixpanel.track("Viewed Page");</script>

            <?php tf_cta_mixpanel($args); ?>

            <?php

        }

}

if ( get_option( 'tf_opendining_enabled' ) == 'true') {

    add_action( 'tf_body_mobile_cta', 'tf_bf_opendining_mobile', 12);

}

// LEGACY ( Fineforce & Pubforce )

function tf_opendining_desktop() {

    $output = '';

    if ( get_option( 'tf_opendining_enabled' ) == 'true') {

        $appid = trim(get_option(tf_opendining_app_id));
        $output .= '<!-- opendining (desktop) -->';
        $output .= '<script type="text/javascript">(function(){function b(){var c=document.createElement("script"),a=document.getElementsByTagName("script")[0];c.type="text/javascript";c.async=true;c.src=(("https:"==document.location.protocol)?"https":"http")+"://www.opendining.net/media/js/order-button.js?id=' . $appid . '";a.parentNode.insertBefore(c,a)}if(window.attachEvent){window.attachEvent("onload",b)}else{window.addEventListener("load",b,false)}})();</script>';
        $output .= '<!-- / opendining (desktop) -->';

    }

    echo $output;

};

if ( TF_THEME != 'baseforce') {

    add_action( 'tf_body_top', 'tf_opendining_desktop', 12);

}

/**
 * Returns JS Drop-in for Open Dining (fixed position button) for Mobile
 *
 * @return string DOM output
 */
function tf_opendining_mobile() {

    $output = '';

    if ( get_option( 'tf_opendining_enabled' ) == 'true') {

        $restid = trim(get_option(tf_opendining_rest_id));
        $output .= '<!-- opendining (mobile) -->';
        $output .= '<div class="opendining-mobile"><a style="color:white !important;" href="http://www.opendining.net/m/' . $restid . '">Order Online</a></div>';
        $output .= '<!-- / opendining (mobile) -->';

    }

    echo $output;

}

/**
 * Display OpenDining iFrame
 *
 * @param $restid
 */
function tf_opendining_displaymenu($restid) {

    echo '<div class="od_menu"><iframe src="http://opendining.net/menu/' . $restid . '?embed=true" border="0" id="order-frame" style="border:0;width:100%"></iframe><script src="http://opendining.net/media/js/order-frame.js"></script></div>';

}

/**
 * Shortcode to display OpenDining iFrame
 *
 * @param $atts
 */
function tf_opendining_displaymenu_shortcode( $atts ) {

        extract( shortcode_atts( array(
            'restid' => trim(get_option(tf_opendining_rest_id))
        ), $atts ) );

        tf_opendining_displaymenu($restid);

    }

add_shortcode( 'opendining-menu', 'tf_opendining_displaymenu_shortcode' );