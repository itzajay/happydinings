**Warning:** At this point & without our full infrastructure, you will be missing certain functions (primarily in the food area). We hope to consolidate these at one poin in the future. For now however, this **repository should be used as a reference** as a opposed to a solution you depend on. We also do not provide downloadable themes.

# Introduction

The **Theme Force Framework** is the most comprehensive solution for **restaurant websites** based on WordPress. It is
structured as a **modular feature-set** highly relevant to industry needs. This read-me only provides usage instructions, please see the developer page below for more information.

## Resources

* **Must-Read** Developer Homepage: http://plate.ly/framework-developers/
* GitHub Homepage: https://github.com/themeforce/framework
* Discussion & News: http://plate.ly/themeforce

## Requirements

In order to make use of our complete feature set, you will not require any other tools (i.e. Options Framework). This framework stands alone.

## Adding to your Theme

The contents of this framework should be pulled into a folder called **framework** within your theme:

	../wp-content/themes/your-theme/framework/

## Activating within your Theme (functions.php)

We understand you may not want to use all the features, so it's only normal that you reduce the number of queries
that your theme executes. Our modular approach means that you can do just that. Just add any (or all) of the functions below to grab what you need (within **functions.php**).

	// Set up theme supports
	
	add_theme_support( 'tf_food_menu' );
	add_theme_support( 'tf_events' );
	
	add_theme_support( 'tf_widget_opening_times' );
	add_theme_support( 'tf_widget_google_maps' );
	add_theme_support( 'tf_widget_payments' );
    add_theme_support( 'tf_widget_twitter' );

	add_theme_support( 'tf_foursquare' );
	add_theme_support( 'tf_yelp' );
	add_theme_support( 'tf_mailchimp' );
	add_theme_support( 'tf_fullbackground' );
	
	add_theme_support( 'tf_settings_api' );
	
The main file that brings everything together within the *"framework/** folder is is:

	framework/themeforce.php
	
## Features

If you'd like to get a feeling for what we do, check out this page:

* Features: http://plate.ly/features/

## Contributing

We'd love to have your input, and if you're interested in contributing code, we'd love that too. Head over to http://www.theme-force.com/framework-developers/ for more information.
	
## Support

We can't actually help you with CSS, XHTML, PHP & JS so there's a certain degree of self-reliance that's required if you'd like to implement. It doesn't mean we won't guide you on the right path, but we'd like to keep the discussions relevant to bugs, enhancements and features.