<?php

function tf_googleplaces_search() {

    // Variables

    $key = 'AIzaSyCxLZPU4CM-NLMQ31yBj0rY1EW4BJTuDWY';
    $search_url = 'https://maps.googleapis.com/maps/api/place/search/json?';

    // clean data

    $raw_address = get_option( 'tf_address_street' ) . ' ' . get_option( 'tf_address_locality' ) . ' ' . get_option( 'tf_address_postalcode' ) . ' ' . get_option( 'tf_address_region' ) . ' ' . get_option( 'tf_address_country' );
    $clean_address = preg_replace( '![^a-z0-9]+!i', '+', $raw_address );
    $name = urlencode( get_option('tf_business_name') );

    // Geocode

    if( $clean_address ) {

        $geocode = @file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $clean_address . '&sensor=false');

        $output= json_decode($geocode);

        $lat = $output->results[0]->geometry->location->lat;
        $long = $output->results[0]->geometry->location->lng;

        $location = $lat . ',' .$long;

    }

    // Perform Search

    $api_response = wp_remote_get( $search_url . 'location=' . $location . '&radius=20000&name=' . $name . '&types=locality&sensor=false?api=' . $key );

    $json = wp_remote_retrieve_body( $api_response );

    $response = json_decode( $json );

    var_dump($response);

}

?>