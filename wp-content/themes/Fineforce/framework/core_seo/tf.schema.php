<?php

// Special Content (i.e. not easily added inline

function tf_schema_meta() {
    
	$cuisines = (array) get_option( 'tf_schema_cuisine', array() );
	$cuisine_all = implode( ', ', $cuisines );
	    
	echo '<!-- schema meta -->';
	echo '<meta itemprop="servesCuisine" content="' . $cuisine_all . '" />';
	echo '<meta itemprop="acceptsReservations" content="' . get_option( 'tf_schema_reservations' ) . '" />'; 
	echo '<meta itemprop="priceRange" content="' . get_option( 'tf_schema_pricerange' ) . '" />';
    echo '<!-- / schema meta -->';
}
add_action('tf_body_top', 'tf_schema_meta', 12);
