<?php

/*
 * TF OPTIONS: 3RD PARTY - OVERVIEW
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */


function themeforce_3rdparty_overview_page() {
    ?>
    <div class="wrap" id="tf-options-page">
        <div class="tf-text">
        <h3>3rd Party Integrations</h3>
        <p>By using happy dinings, we help you <strong>eliminate input duplication</strong> as well as provide integrations to <strong>strong solutions</strong> in other areas of managing a restaurant, i.e. reservations, taking orders, etc.</p>
        <!-- <img src="<?php echo get_bloginfo( 'template_url' ).'/framework/assets/images/sp-example.jpg'; ?>"> -->
        <h3 style="margin-top:40px">About the different Integrations</h3>
        <!-- YELP -->
        <img src="<?php echo get_bloginfo( 'template_url' ).'/framework/assets/images/3rd_opendining.jpg'; ?>" />
            <p><a href="https://www.opendining.net/link/b1793c2f1bba061d188a11fff40aa30406455fae">Open Dining</a> gets your restaurant more orders, larger tickets, and more loyal customers with web, mobile, and Facebook ordering.</p>
            <ul>
                <li>Receive orders in whichever way is most convenient: E-mail, Fax, directly to your PoS and more.</li>
                <li>The service is available globally.</li>
            </ul>
        <div class="social-box tf-settings-wrap"><span><strong>Link</strong> to your Open Dining Menu & Account </span><a href="<?php echo get_admin_url() . 'admin.php?page=themeforce_dining'; ?>"><div class="tf-button tf-inline">Go to your Open Dining Settings</div></a></div>
        <div class="clearfix"></div>

        <img src="<?php echo get_bloginfo( 'template_url' ).'/framework/assets/images/3rd_opentable.jpg'; ?>" />
        <p><a href="http://www.opentable.com/">OpenTable</a> is a leading provider of free, real-time online restaurant reservations for diners and reservation and guest management solutions for restaurants.</p>
        <ul>
            <li>OpenTable has more than 20,000 restaurant customers, and, since its inception in 1998, has seated more than 200 million diners around the world.</li>
            <li>The OpenTable service is available throughout the United States, as well as in Canada, Germany, Japan, Mexico, and the United Kingdom.</li>
        </ul>
        <div class="social-box tf-settings-wrap"><span><strong>Link</strong> to your Opentable reservations </span><a href="<?php echo get_admin_url() . 'admin.php?page=themeforce_opentable'; ?>"><div class="tf-button tf-inline">Go to your Opentable Settings</div></a></div>
        <div class="clearfix"></div>

        <img src="<?php echo get_bloginfo( 'template_url' ).'/framework/assets/images/3rd_mailchimp.jpg'; ?>" />
        <p><a href="http://www.mailchimp.com">MailChimp</a> allows you to <strong>automatically</strong> keep in touch with your customer base, updating them on the latest news & events. You can set your newsletter to automatically send off your events on a weekly or monthly basis.</p>

        <div class="social-box tf-settings-wrap"><span><strong>Link</strong> to your MailChimp List </span><a href="<?php echo get_admin_url() . 'admin.php?page=themeforce_mailchimp'; ?>"><div class="tf-button tf-inline">Go to your MailChimp Settings</div></a></div>
        <div class="clearfix"></div>

        </div>
    </div>
    <?php
}	
?>