<?php

/*
 * TF OPTIONS: SOCIAL MEDIA - OVERVIEW
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Create Page
// -----------------------------------------

function themeforce_social_media_overview_page() {
    ?>
    <div class="wrap tf-options-page">
        <div class="tf-text">
        <h3>What is Social Media, and why you need it?</h3>
        <p>Social media is a great way for you to stay in touch with your existing customer base, as well as being able to attract others within those private networks. <strong>Social Proof</strong> on the other hand is where your customers will create most of your content (rating, reviews, photos, etc.) and is equally important, so check that out as well!</p>
        <!-- <img src="<?php echo get_bloginfo( 'template_url' ).'/framework/assets/images/sp-example.jpg'; ?>"> -->
        <h3 style="margin-top:40px">About the different Social Media Mechanisms</h3>
        <!-- YELP -->
        <img src="<?php echo get_bloginfo( 'template_url' ).'/framework/assets/images/social_facebook.jpg'; ?>" />
        <p><a href="http://www.facebook.com" target="_blank">Facebook</a> is a social networking service and website launched in February 2004. Users may create a personal profile, add other users as friends, and exchange messages, including automatic notifications when they update their profile. Here are some interesting numbers:</p>
        <ul>
            <li>More than <strong>750 million</strong> active users.</li>
            <li>50% of active users log on to Facebook <strong>everyday</strong>.</li>
            <li>Average user has <strong>130 friends</strong>.</li>
        </ul>
        <div class="social-box tf-settings-wrap"><span><strong>Link</strong> to your Facebook Fan Page </span><a href="<?php echo get_admin_url() . 'admin.php?page=themeforce_facebook'; ?>"><div class="tf-button tf-inline">Go to your Facebook Settings</div></a></div>
        <div class="clearfix"></div>
        <!-- QYPE -->
        <img src="<?php echo get_bloginfo( 'template_url' ).'/framework/assets/images/social_twitter.jpg'; ?>" />
        <p><a href="http://www.twitter.com" target="_blank">Twitter</a> is an online social networking and microblogging service that enables its users to send and read text-based posts of up to 140 characters, informally known as "tweets.".</p>
        <ul>
            <li><strong>140 million</strong>. The average number of Tweets people sent per day.</li>
            <li><strong>460, 000. </strong>Average number of new accounts per day (February 2011).</li>
            <li><strong>182%</strong>. Increase in number of mobile users over the past year.</li>
        </ul>
        <div class="social-box tf-settings-wrap"><span><strong>Link</strong> to your Twitter Profile </span><a href="<?php echo get_admin_url() . 'admin.php?page=themeforce_twitter'; ?>"><div class="tf-button tf-inline">Go to your Twitter Settings</div></a></div>
        <div class="clearfix"></div>
        </div>
    </div>
    <?php
}	
?>