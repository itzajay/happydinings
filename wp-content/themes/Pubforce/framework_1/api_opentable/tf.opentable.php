<?php
/*
 * Open Table Integration
 * ---------------------------------------------
 *
 * This is a pretty light integration to see how visitors will use it. This will not degrade for mobile.
 *
*/

/**
 * Returns Open Table bar at top of the website (fixed position)
 *
 * @return string DOM output
 */
function tf_opentable_bar() {
    
    ob_start();
    
    if ( get_option('tf_opentable_bar_enabled' ) == 'true') {
            $opentable = trim(get_option(tf_opentable_id));
            echo '<!-- opentable bar -->';
            echo '<div id="opentablebar">';
            echo '<div id="opentablebar-center">';
            echo '<script type="text/javascript" src="http://www.opentable.com/frontdoor/default.aspx?rid='. $opentable. '&restref='. $opentable. '&bgcolor=F6F6F3&titlecolor=0F0F0F&subtitlecolor=0F0F0F&btnbgimage=http://www.opentable.com/frontdoor/img/ot_btn_red.png&otlink=FFFFFF&icon=dark&mode=wide"></script>';
            echo '<style type="text/css">.OT_wrapper{background:none;border:none;} .OT_day, .OT_time, .OT_party, .OT_submit {border:none;} .OT_searchTimeField, .OT_searchDateField, .OT_searchPartyField {padding: 1px 3px 2px 5px !important;}</style>';
            echo '</div></div>';
            echo '<!-- / opentable bar -->';
        } else {
            echo '<!-- opentable bar disabled  -->'; 
        }
        
    $output = ob_get_contents();
    ob_end_clean();    
    echo $output;

};

add_action('tf_body_top', 'tf_opentable_bar', 12);