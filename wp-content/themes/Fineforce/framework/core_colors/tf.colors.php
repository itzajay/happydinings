<?php
/*
 * Theme Force - Dynamic Color Palette Creation
 * --------------------------------------------
 * 
 * The basis for color extraction has been adopted from:
 * http://www.coolphptools.com/color_extract
 * which you can find in the file included below:
 */

require_once( TF_PATH . '/core_colors/colors.inc.php' );

/*
 * The remainder of the code was created for Theme Force with the majority
 * replicated from Drupal Color Module (i.e. unpack, rgb -> hsl, hsl -> rgb, pack)
 */

/*
 * Update Theme Colors based on Logo Image
 * TODO: Ability to update other themes (though they may require different color settings)
 */

function themeforce_update_logo_colors() {
    
    if ( isset($_POST['grab_logo_colors'] ) == '1') {

        $logo = get_option( 'tf_logo' );
        tf_logocolors( $logo );
        wp_redirect( wp_get_referer() );
        exit;
        
    }    

}

add_action('admin_init', 'themeforce_update_logo_colors');


/*
 * tf_logocolors ( above ) is stored within the individual theme (uses theme options) but calls on tf_dynamiccolors ( below )
 */


function tf_dynamiccolors( $colorimage ) {
    
    // Extract Colors
    
    // Defaults
    $delta = 24;
    $reduce_brightness = true;
    $reduce_gradients = true;
    $num_results = 10;

    // Grab Image Colors
    $extractcolors = new GetMostCommonColors();
    $colorsummary = $extractcolors->Get_Color($colorimage, $num_results, $reduce_brightness, $reduce_gradients, $delta);
    
    foreach ($colorsummary as $hex => $count) {
         $colors[] = $hex;
    }
    
    
    /*
    // Echo Colors Extracted
    echo '<h3>Colors Extracted</h3>';
    echo '<div style="outline:1px gray solid;float:left;width:60px;height:60px;font-size:12px;font-family: Lucida Console;background-color:#'.$colors[0].'">'.$colors[0].'</div>';
    echo '<div style="outline:1px gray solid;float:left;width:60px;height:60px;font-size:12px;font-family: Lucida Console;background-color:#'.$colors[1].'">'.$colors[1].'</div><div class="clearfix"></div>';
    echo '<br /><h3>Various Arrays</h3>';
    */
    // Create Awesome Palette
    
        // standard
    
        // echo $colors[0];
        $s1 = tf_colorpalette( $colors[1], 'primary' );
        /* $s2 = tf_colorpalette( $colors[1], 'secondary' );
        $standard = array_merge($s1, $s2); */
        $standard = $s1;
        return $standard;
        
        /*

        
        echo '<br /><h3>TF Color Scheme</h3>';
        foreach ($standard as $color => $key) {
            echo '<div style="outline:1px gray solid;float:left;width:60px;height:60px;font-size:12px;background-color:#'.$key.'">'.$key.'</div>';
        }
	*/
    }

function tf_colorpalette($hex, $type) {

    // Conversion from Hex to RGB to HSL

    $rgb = _color_unpack( $hex, true );
    $hsl = _color_rgb2hsl( $rgb );
    
    // Extract HSL values
    
    $h = $hsl[0];
    $s = $hsl[1];
    $l = $hsl[2];
    
    $colors = array();
    
    // Create Final Products
    /*
    if ( $type == 'primary' ) {
        $primary = array( '0.3', '0.5', '0.7' );
        $saturation = '0.4';
        foreach ($primary as $value) {
            $hsl = array ($h, $saturation, $value);
            $rgb = _color_hsl2rgb( $hsl );
            $color = _color_pack( $rgb, true );
            $colors[] = $color;
            
        }
    }
    */
    if ( $type == 'primary' ) {
        // Dark    
        $hsl = array ($h, 0.3, 0.2);
        $rgb = _color_hsl2rgb( $hsl );
        $color = _color_pack( $rgb, true );
        $colors[] = $color;
        // Light
        $hsl = array ($h, 0.3, 0.6);
        $rgb = _color_hsl2rgb( $hsl );
        $color = _color_pack( $rgb, true );
        $colors[] = $color; 
        // Active
        $hsl = array ($h, 0.6, 0.4);
        $rgb = _color_hsl2rgb( $hsl );
        $color = _color_pack( $rgb, true );
        $colors[] = $color;
        }
    
    if ( $type == 'secondary' ) {
        $secondary = array( '0.3', '0.7' );
        $saturation = '1.0';
        foreach ($secondary as $value) {
            $hsl = array ($h, $saturation, $value);
            $rgb = _color_hsl2rgb( $hsl );
            $color = _color_pack( $rgb, true );
            $colors[] = $color;
        }
    }
    
    return $colors;
}

// TF COLOR MANIPULATION FUNCTIONS

function tf_color_alpha_flip( $hex ) {
    
    // Grab
    $hsl = rgb2hsl( hex2rgb( $hex ) );
    
    // Barriers for Display
    if ( $hsl[2] > 0.9 ) { $hsl[2] = 0.9; }
    if ( $hsl[2] < 0.1 ) { $hsl[2] = 0.1; }
    
    // Generate Alpha
    $alpha = 1 - $hsl[2];
    
    return $alpha;
   
}

function tf_color_change_l( $hex, $change) {
    
    // Grab
    $rgb = hex2rgb( $hex );
    
    //print_r($rgb);
    
    $hsl = rgb2hsl( $rgb );
    
    //print_r($hsl);
    
    $oldl = $hsl[2];
 
    // Change Luminosity
    $hsl[2] = $oldl + $change;

    //print_r($hsl);
    
    // Barriers for Display
    if ( $hsl[2] > 1 ) { $hsl[2] = 0.99; }
    if ( $hsl[2] < 0 ) { $hsl[2] = 0.01; }
    
    
    // Generate RGB Array
    $rgb = hsl2rgb($hsl);
    
    
    //print_r($rgb);
    return $rgb;
    
}

function tf_color_textshadow ( $front, $back, $change) {
    
    // Process
    $rgb = tf_color_change_l( $front, $change);
    $alpha = tf_color_alpha_flip( $back );
    
    // Concatenate
    $rgba = $rgb[0] . ', ' . $rgb[1] . ', '  . $rgb[2] . ', ' . round($alpha,2);
    
    return $rgba;
    
}

function tf_color_rgb ( $color) {
    
    // Process
    $rgb = hex2rgb( $color);
    
    // Concatenate
    $rgba = $rgb[0] . ', ' . $rgb[1] . ', '  . $rgb[2];
    
    return $rgba;
    
}

// RGB TO HEX

function rgb2hex($r, $g, $b, $uppercase=false, $shorten=false)
{
  // The output
  $out = "";
  
  // If shorten should be attempted, determine if it is even possible
  if ($shorten && ($r + $g + $b) % 17 !== 0) $shorten = false;
  
  // Red, green and blue as color
  foreach (array($r, $g, $b) as $c)
  {
    // The HEX equivalent
    $hex = base_convert($c, 10, 16);
    
    // If it should be shortened, and if it is possible, then
    // only grab the first HEX character
    if ($shorten) $out .= $hex[0];
    
    // Otherwise add the full HEX value (if the decimal color
    // is below 16 then we have to prepend a 0 to it)
    else $out .= ($c < 16) ? ("0".$hex) : $hex;
  }
  // Package and away we go!
  return $uppercase ? strtoupper($out) : $out;
}

// HEX TO RGB

function hex2rgb($color)
{
    
    if ($color[0] == '#')
        $color = substr($color, 1);

    if (strlen($color) == 6)
        list($r, $g, $b) = array($color[0].$color[1],
                                 $color[2].$color[3],
                                 $color[4].$color[5]);
    elseif (strlen($color) == 3)
        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
    else
        return false;

    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

    return array($r, $g, $b);
    
}

// RGB TO HSL

function rgb2hsl($rgb){
   
     $clrR = ($rgb[0] / 255);
     $clrG = ($rgb[1] / 255);
     $clrB = ($rgb[2] / 255);
   
     $clrMin = min($clrR, $clrG, $clrB);
     $clrMax = max($clrR, $clrG, $clrB);
     $deltaMax = $clrMax - $clrMin;
   
     $L = ($clrMax + $clrMin) / 2;
   
     if (0 == $deltaMax){
         $H = 0;
         $S = 0;
         }
    else{
         if (0.5 > $L){
             $S = $deltaMax / ($clrMax + $clrMin);
             }
        else{
             $S = $deltaMax / (2 - $clrMax - $clrMin);
             }
         $deltaR = ((($clrMax - $clrR) / 6) + ($deltaMax / 2)) / $deltaMax;
         $deltaG = ((($clrMax - $clrG) / 6) + ($deltaMax / 2)) / $deltaMax;
         $deltaB = ((($clrMax - $clrB) / 6) + ($deltaMax / 2)) / $deltaMax;
         if ($clrR == $clrMax){
             $H = $deltaB - $deltaG;
             }
        else if ($clrG == $clrMax){
             $H = (1 / 3) + $deltaR - $deltaB;
             }
        else if ($clrB == $clrMax){
             $H = (2 / 3) + $deltaG - $deltaR;
             }
         if (0 > $H) $H += 1;
         if (1 < $H) $H -= 1;
         }
     return array($H, $S, $L);
     }
     
// HSL TO RGB

function hsl2rgb($hsl) {
  $h = $hsl[0];
  $s = $hsl[1];
  $l = $hsl[2];
  $m2 = ($l <= 0.5) ? $l * ($s + 1) : $l + $s - $l*$s;
  $m1 = $l * 2 - $m2;
  return array(round(_color_hue2rgb($m1, $m2, $h + 0.33333)*255),
               round(_color_hue2rgb($m1, $m2, $h)*255),
               round(_color_hue2rgb($m1, $m2, $h - 0.33333)*255));
}
    
function _color_hue2rgb($m1, $m2, $h) {
  $h = ($h < 0) ? $h + 1 : (($h > 1) ? $h - 1 : $h);
  if ($h * 6 < 1) return $m1 + ($m2 - $m1) * $h * 6;
  if ($h * 2 < 1) return $m2;
  if ($h * 3 < 2) return $m1 + ($m2 - $m1) * (0.66666 - $h) * 6;
  return $m1;
}
?>