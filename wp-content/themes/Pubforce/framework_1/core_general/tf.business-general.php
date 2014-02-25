<?php

/**
 * Create clean phone number (no spaces or special characters)
 *
 * @return mixed|null phone number
 */
function tf_business_phone_clean() {
    if ( get_option('tf_business_phone') ) {
        return preg_replace('/|\s|[^0-9\s]/','', get_option('tf_business_phone'));
    } else {
        return null;
    }
}

/**
 * Create clean address link for GMaps (no spaces or special characters)
 *
 * @return string google maps link
 */
function tf_business_address_clean() {

    // concatenate address
    $new_address = get_option('tf_address_street') . ', ' . get_option('tf_address_locality') . ', ' . get_option('tf_address_postalcode') . ' ' . get_option('tf_address_region') . ' ' . get_option('tf_address_country');

    // check if old address
    if (get_option('tf_address_street') . get_option('tf_address_country') !== '')
    {
        $valid_address = $new_address;
    } else {
        $valid_address = get_option('tf_business_address');
    }

    // clean address
    $address_url = preg_replace('![^a-z0-9]+!i', '+', $valid_address);

    return 'http://maps.google.com/maps?q=' . $address_url;
}

?>