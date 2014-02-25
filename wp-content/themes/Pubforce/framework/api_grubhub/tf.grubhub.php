<?php
/*
 * GrubHub Integration
 * ---------------------------------------------
 *
 * This is a pretty light integration to see how visitors will use it. Similar to Yelp, the feature
 * will degrade for mobile
 *
*/


/**
 * Returns DOM CTA for Desktop
 *
 * @return string DOM output
 */
function tf_grubhub_desktop() {

        // A/B Testing

        if ( date('j') % 2 ) { // day of month will likely be less biased then day of week, or hour of day.
            //even
        } else {
            //odd
        }

        // Arguments

        $args = array(

            "tracklinks" => true,
            "mp_target" => "a#cta-header",
            "mp_name" => "Clicked Call to Action (Main)",
            "partner" => "grubhub",
            "revenue_type" => "onlineordering",
            "placement" => "header",
            "device" => "desktop",
            "headline" => "Order Online",
            "color" => "default"

        );

        $id = trim(get_option(tf_grubhub_id));

        // Display

        ?>

        <a style="margin-bottom: 80px;" href="http://www.grubhub.com/order_redir.jsp?custId=<?php echo $id; ?>&amp;affId=#detailsInfo" id="cta-header" class="cta-desktop cta-<?php echo $args["color"]; ?>">
            <span class="cta-icon icon-cart"></span> <span class="cta-headline"><?php echo $args["headline"]; ?></span>
            <div class="poweredby-grubhub-desktop"></div>
        </a>


        <script>mixpanel.track("Viewed Page");</script>

        <?php tf_cta_mixpanel($args); ?>

        <div class="clearfix"></div>



        <?php

}

if ( get_option( 'tf_grubhub_enabled' ) == 'true') {

    add_action( 'tf_body_desktop_cta', 'tf_grubhub_desktop', 12);

}

/**
 * Returns DOM CTA for Mobile
 *
 * @return string DOM output
 */
function tf_grubhub_mobile() {

    // Arguments

    $args = array(

        "tracklinks" => true,
        "mp_target" => "a.cta-mobile",
        "mp_name" => "Clicked Call to Action (Main)",
        "partner" => "grbuhub",
        "revenue_type" => "online ordering",
        "placement" => "header",
        "device" => "mobile",
        "headline" => "Order Online",
        "color" => "default"

    );

    $id = trim(get_option(tf_grubhub_id));

    // Display

    if ( get_option( 'tf_grubhub_enabled' ) == 'true') {

            ?>

            <a style="margin-bottom: 50px;" href="http://www.grubhub.com/order_redir.jsp?custId=<?php echo $id; ?>&amp;affId=#detailsInfo" class="cta-mobile cta-<?php echo $args["color"]; ?>">
                <span class="cta-icon icon-cart"></span> <span class="cta-headline"><?php echo $args["headline"]; ?></span>
                <div class="poweredby-grubhub-mobile"></div>
            </a>

            <div class="clearfix"></div>

            <script>mixpanel.track("Viewed Page");</script>

            <?php tf_cta_mixpanel($args); ?>

            <?php

        }

}

if ( get_option( 'tf_grubhub_enabled' ) == 'true') {

    add_action( 'tf_body_mobile_cta', 'tf_grubhub_mobile', 12);

}