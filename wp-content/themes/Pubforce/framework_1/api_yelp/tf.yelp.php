<?php
/*
 * Yelp Bar Integration
 * ---------------------------------------------
 *
 * Adds Yelp bar containing ratings (will degrade gracefully for mobile)
 *
*/

/**
 * Get Yelp API Response
 *
 * @return array|mixed|null Fresh API Response
 */
function tf_yelp_api() {

    $api_key = get_option( 'tf_yelp_api_key' );
    $api_phone = get_option( 'tf_yelp_phone' );
    $api_cc = get_option( 'tf_yelp_country_code' );

    $api_response = wp_remote_get( "http://api.yelp.com/phone_search?phone={$api_phone}&cc={$api_cc}&ywsid={$api_key}" );
    $yelpfile = wp_remote_retrieve_body( $api_response );
    $yelp = json_decode( $yelpfile );
	
	//error checking
	if ( !isset( $yelp->message->code ) || $yelp->message->code != 0 )
		return null;
	
    return $yelp;
}

/**
 * Check Yelp API Transient
 *
 * @return array|mixed|null Transient API Response
 */
function tf_yelp_transient() {

    // - get transient -
    $json = get_transient( 'themeforce_yelp_json' );

    // - refresh transient -
    if ( !$json ) {
        $json = tf_yelp_api();
        set_transient('themeforce_yelp_json', $json, 180);
	}

    // - data -
    return $json;
}


/**
 * Delete & Update the Transient upon settings update.
 */
function tf_delete_yelp_transient_on_update_option() {
	
	delete_transient( 'themeforce_yelp_json' );

}
add_action( 'update_option_tf_yelp_api_key', 'tf_delete_yelp_transient_on_update_option' );
add_action( 'update_option_tf_yelp_phone', 'tf_delete_yelp_transient_on_update_option' );
add_action( 'update_option_tf_yelp_country_code', 'tf_delete_yelp_transient_on_update_option' );


/**
 * Display Yelp Bar
 *  - Follows Yelp Display Requirements
 *  - Schema enhanced now ( Thing > Intangible > Rating > AggregateRating )
 *
 * @return mixed DOM Output
 */
function tf_yelp_bar() {

    if ( get_option('tf_yelp_enabled' ) == 'true') {

        $yelp = tf_yelp_transient();

        if ( !$yelp ) {

                return;

            } else {

                // Shows Response Code for Debugging (as HTML Comment)

                ?>

                <!-- yelp bar -->

                <div id="yelpbar">
                    <div id="yelpcontent" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                        <div class="yelpimg">
                            <a href="http://www.yelp.com">
                                <img src ="<?php echo TF_URL . '/assets/images/yelp_logo_50x25.png'; ?>" alt="Yelp">
                            </a>
                        </div>
                        <div class="yelptext"><?php _e('users have rated our establishment', 'themeforce'); ?></div>
                        <a href="<?php echo $yelp->businesses[0]->url; ?>">
                            <div class="yelpimg" itemprop="ratingValue"><img src="<?php echo $yelp->businesses[0]->rating_img_url;  ?>" alt="<?php echo $yelp->businesses[0]->avg_rating; ?>" style="padding-top:7px;" /><meta itemprop="bestRating" content="5" /></div>
                        </a>
                        <div class="yelptext"><?php _e('through', 'themeforce'); ?></div>
                        <div class="yelptext">
                            <a href="<?php echo $yelp->businesses[0]->url; ?>" target="_blank">
                                <span itemprop="ratingCount"><?php echo $yelp->businesses[0]->review_count; ?></span>&nbsp;<?php _e( 'Reviews', 'themeforce' ); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- / yelp bar -->

                <?php

            }
        }

};

add_action('tf_body_top', 'tf_yelp_bar', 12);