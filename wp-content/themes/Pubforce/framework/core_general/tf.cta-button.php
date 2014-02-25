<?php

/**
 * Create CTA Button
 *
 * This will be quite an important revenue-component going forward and as such needs
 * to be flexible with regards to different partners, styles and possibly layout.
 *
 * @return mixed|Call to Action
 */
function tf_cta_mixpanel($args) {

    // Get Options

        /*
        Each partner needs the following data:
            - partner slug*
            - partner type*
            - partner desktop URL structure*
            - partner mobile URL structure
            - partner headline*
            - partner subtitle
            - partner credit (i.e. powered by, etc. / display requirements)
        */


    // A/B Test (not active at the moment, just ideas)



    // DOM Output

    if ( $args['tracklinks'] == true ) {

    ?>

    <script>

        mixpanel.track_links("<?php echo $args['mp_target'];?>", "<?php echo $args['mp_name'];?>", {
            'revenue_type' : '<?php echo $args['revenue_type'];?>', // 'reservation' or 'onlineordering'
            'partner' : '<?php echo $args['partner'];?>', // name of partner
            'device' : '<?php echo $args['device'];?>', // 'default' or others
            'placement' : '<?php echo $args['placement'];?>', // 'default' or others
            'headline' : '<?php echo $args['headline'];?>', // 'default' or others
            'color' : '<?php echo $args['color'];?>' // true or false, does partner branding help?
        });

        <?php if ( $args['eval'] ) { ?>

        jQuery("<?php echo $args['mp_target'];?>").click(function() {
            <?php echo $args['eval']; ?>
        }

        <?php ; } ?>

    </script>

    <?php

    } else {

    ?>

    <script>

    jQuery("<?php echo $args['mp_target'];?>").click(function() {

        mixpanel.track("<?php echo $args['mp_name'];?>", {
            'revenue_type' : '<?php echo $args['revenue_type'];?>', // 'reservation' or 'onlineordering'
            'partner' : '<?php echo $args['partner'];?>', // name of partner
            'device' : '<?php echo $args['device'];?>', // 'default' or others
            'placement' : '<?php echo $args['placement'];?>', // 'default' or others
            'headline' : '<?php echo $args['headline'];?>', // 'default' or others
            'color' : '<?php echo $args['color'];?>' // true or false, does partner branding help?
        });

        <?php if ( $args['eval'] ) { ?>
            <?php echo $args['eval']; ?>
        <?php ; } ?>

    });

    </script>

    <?php

    }

}

?>