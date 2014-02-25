<?php

/*
 * TF OPTIONS: YELP
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Create Page
// -----------------------------------------
// TODO Add functionality to edit existing slides.

function themeforce_social_overview_page() {
    ?>
    <div class="wrap tf-options-page">
        <div class="tf-text">
        <h3>What is Social Proof, and why you need it?</h3>
        <p>Social proof is a psychological mechanism whereby we look to others to help guide our daily decisions, i.e. music trends, clothes, etc. We've integrated with the following tools (which are all free for you to use by the way) to provide you with a way to come across as more credible to your online visitors.</p>
        <!-- <img src="<?php echo get_bloginfo( 'template_url' ).'/framework/assets/images/sp-example.jpg'; ?>"> -->
        <h3 style="margin-top:40px">About the different Social Proof Mechanisms</h3>
        <!-- YELP -->
        <img src="<?php echo get_bloginfo( 'template_url' ).'/framework/assets/images/social_yelp.jpg'; ?>" />
        <p><a href="http://www.yelp.com" target="_blank">Yelp</a> is a company that operates a social networking, user review, and local search web site. Yelp.com has more than 39 million monthly unique visitors as of late 2010. In May 2011, they recorded the following numbers:</p>
        <ul>
            <li><strong>27% of all Yelp searches</strong> come from the iPhone application.</li>
            <li>Over <strong>half a million calls</strong> were made to local businesses directly from the iPhone App.</li>
            <li>Nearly a <strong>million people generated point-to-point directions</strong> to a local business from their Yelp iPhone App last month.</li>
        </ul>
        <div class="social-box tf-settings-wrap"><span>Use Yelp to <strong>display your Rating</strong> </span><a href="<?php echo get_admin_url() . 'admin.php?page=themeforce_yelp'; ?>"><div class="tf-button tf-inline">Go to your Yelp Settings</div></a></div>
        <div class="clearfix"></div>
        <!-- QYPE -->
        <!--
        <img src="<?php echo get_bloginfo( 'template_url' ).'/framework/assets/images/social_qype.jpg'; ?>" />
        <p><a href="http://www.qype.co.uk" target="_blank">Qype</a>, is a company centered around social networking and local reviews. They currently operate websites in Germany, the United Kingdom, France, Switzerland, Austria, Ireland, Poland, Brazil, Spain and Italy and have approximately 22 million monthly unique European visitors.</p>
        <ul>
            <li>Qype receives <strong>22 million</strong>unique visitors per month across Europe.</li>
            <li>Qype has over <strong>1.9 million trusted reviews</strong></li>
            <li><strong>20% of all new Qype reviews</strong> are written from a mobile phone.</li>
        </ul>
        <div class="social-box tf-settings-wrap"><span>Use Qype to <strong>display your Rating</strong> </span><a href="<?php echo get_admin_url() . 'admin.php?page=themeforce_qype'; ?>"><div class="tf-button">Go to your Qype Settings</div></a></div>
        <div class="clearfix"></div>
        -->
        <!-- FOURSQUARE -->
        <img src="<?php echo get_bloginfo( 'template_url' ).'/framework/assets/images/social_foursquare.jpg'; ?>" />
        <p><a href="http://www.foursquare.com" target="_blank">Foursquare</a> is a location-based social networking website based on hardware for mobile devices. The service is available to users with GPS-enabled mobile devices such as smartphones. Users "check-in" at venues using a mobile website, text messaging or a device-specific application by running the application and selecting from a list of venues that the application locates nearby. Each check-in awards the user points and sometimes "badges".</p>
        <ul>
            <li><strong>2.6 million check-ins per day</strong>.</li>
            <li>59% of users search for a local business at least once a week</li>
            <li>86% of users check-in at least once a day.</li>
        </ul>
        <div class="social-box tf-settings-wrap"><span>Use Foursquare to <strong>display your Guest Photos & Tips</strong> </span><a href="<?php echo get_admin_url() . 'admin.php?page=themeforce_foursquare'; ?>"><div class="tf-button tf-inline">Go to your Foursquare Settings</div></a></div>
        <div class="clearfix"></div>

        </div>
    </div>
    <?php
}	
?>