<?php

// Output Business Address (in Schema)
// Use in templates: do_shortcode( '[tf-address]' );

function tf_shortcode_address()
{
	$streetaddress = get_option( 'tf_address_street' );
	$locality = get_option( 'tf_address_locality' );
	$region = get_option( 'tf_address_region' );
	$postalcode = get_option( 'tf_address_postalcode' );
	$country = get_option( 'tf_address_country');
	$googleaddress = $streetaddress . ' ' . $locality . ' ' . $region . ' ' . $postalcode . ' ' . $country;
        $googleaddress = preg_replace( '![^a-z0-9]+!i', '+', $googleaddress);
        
	ob_start(); 
	if ($streetaddress != '')
        {
            echo '<a href="http://maps.google.com/maps?q=' . $googleaddress . '" target="_blank" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" style="display:inline">';
                    echo '<span itemprop="streetAddress">' . $streetaddress . '</span>';
                    if ($locality != '') { echo ', <span itemprop="addressLocality">' . $locality . '</span> ';}
                    if ($postalcode != '') { echo ', <span itemprop="postalCode">' . $postalcode . '</span>';}      
                    if ($region != '') { echo '<span itemprop="addressRegion">' . $region . '</span>';}
                    if ($country != '') { echo ', <span itemprop="postalCode">' . $country . '</span>';}
            echo '</a>';
        } else {
            // Fallback - Pre 3.2.2
            echo get_option( 'tf_business_address' );
        }
               
        $output = ob_get_contents();
        ob_end_clean();
        return $output;	
}

add_shortcode( 'tf-address', 'tf_shortcode_address' );

// Output Phone Number (in Schema)
// Use in templates: do_shortcode( '[tf-phone]' );

function tf_shortcode_phone()
{
	$phone = get_option( 'tf_business_phone' );
    $mobilephone = preg_replace('/|\s|[^0-9\s]/','', $phone);
	$output = '<a href="tel:' . $mobilephone . '" itemprop="telephone">' . $phone . '</a>';
	return $output;
}

add_shortcode( 'tf-phone', 'tf_shortcode_phone' );
	
?>