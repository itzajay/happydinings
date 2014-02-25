/* New functions here, some parts could be done better, but the first 2 lines are important in how we can target specific areas */

jQuery(document).ready(function($) {

    var width = jQuery(window).width();
    var height = jQuery(window).height();
    var heightThemes = jQuery('#tf-presets').height() + 20;

    // Decide to show Panel or not

    if ( width > 960 ) {

        $('body').wrapInner('<div id="tf-content-wrap" />');
        $('#tf-panel-wrap').insertBefore('#tf-content-wrap');
        $('#tf-panel-accordion').accordion({autoHeight:false});

        $('.font').click(function(){

            $('.font').css('opacity','0.2');
            $(this).css('opacity','0.9');

        });

    } else {

        $('#tf-designpanel-toggle').hide();

    }

    // Collapse Themes if height is too small

    if ( heightThemes + 180 > height ) {

        $('#tf-presets a.preset').addClass('small-preset');

    }


});

var TFConfigurableThemeColors = new function() {

	var self = this;
	self.colors = [];
	
	self.getColorByName = function( name ) {
		
		var c = null;
		
		jQuery.each( self.colors, function( key, color ) {

			if ( color.color.name == name )
				c = color;
			
		} )
		
		return c;
	
	}

}

var TFConfigurableThemeFonts = new function() {

    var self = this;
    self.fonts = [];

    self.getFontSectionById = function( id ) {

        var c = null;

        jQuery.each( self.fonts, function( key, fontSection ) {

            if ( fontSection.id == id )
                c = fontSection;

        } )

        return c;

    }

}

var TFConfigurableBackground = null;

jQuery(document).ready(function() {

    DesignPanelMarginOffset = jQuery.parseJSON( DesignPanelMarginOffset );

    // Setup the colors etc
    jQuery.each( colors, function( key, color ) {


    	var configurableThemeColor = new TFConfigurableThemeColor( key, color );

    	TFConfigurableThemeColors.colors.push( configurableThemeColor );

    	configurableThemeColor.colorPicker = jQuery( "#colorSelector" + key );

    	jQuery( "#colorSelector" + key ).ColorPicker({
    	    color: color.value,
    	    onShow: function( colorpicker ) {
    	    	 jQuery(colorpicker).fadeIn( 500 );
    	    },
    	    onHide: function (colpkr) {
    	    	jQuery(colpkr).fadeOut(500);
    	    },
    	    onChange: function (hsb, hex, rgb) {

    	    	jQuery( "#colorSelector" + key + " div").css("backgroundColor", "#" + hex);

    	    	configurableThemeColor.setColor( '#' + hex )
    		}
    	});
    });

    fonts = jQuery.parseJSON( fonts );

    //Set up the fonts
    jQuery.each( fonts, function( key, fontOptions ) {

        var configurableThemeFont = new TFConfigurableThemeFont( fontOptions.id, fontOptions );

        TFConfigurableThemeFonts.fonts.push( configurableThemeFont );

    } );

    // Toggle

    // TODO: Ideally this part should be on by default (so that people play with it on first sign-up) and then have a cookie store the toggle on/off bit?

    var width = jQuery(window).width();

    if ( width > 960 ) {

    jQuery( '#tf-panel-wrap').on( 'click', '#tf-designpanel-toggle', function() {

        //if the panel is open
        if ( jQuery( this ).hasClass( 'toggle-on' ) ) {

            jQuery('#tf-panel-wrap').stop().animate({left:"-=320"},500, function() {

                jQuery( '#wrap').css( 'margin-left', parseInt( jQuery('#wrap').css( 'margin-left').replace( 'px', '' ) ) - DesignPanelMarginOffset );
            });

            jQuery(this).addClass('toggle-off');
            jQuery(this).removeClass('toggle-on');

           // TFThemeConfigurationUpdater.updateDataForKey( 'hide_editor', 'hide_it', true );

        } else { //if its closed

            jQuery('#tf-panel-wrap').stop().animate({left:"+=320"},500 );

            jQuery( '#wrap').css( 'margin-left', parseInt( jQuery('#wrap').css( 'margin-left').replace( 'px', '' ) ) + DesignPanelMarginOffset );

            jQuery(this).addClass('toggle-on');
            jQuery(this).removeClass('toggle-off');

           // TFThemeConfigurationUpdater.updateDataForKey( 'hide_editor', 'hide_it', false );
        }

    } );

    if ( jQuery( '#tf-designpanel-toggle').hasClass( 'toggle-on' ) ) {

        jQuery( '#tf-designpanel-toggle').removeClass('toggle-on');
        jQuery( '#tf-designpanel-toggle').click();
    }

    jQuery(window).resize( function() {

        if ( typeof( resizeTimer ) != 'undefined' )
            clearTimeout( resizeTimer );

        resizeTimer = setTimeout( function() {

            if (  jQuery(window).width() > 960 ) {

                jQuery( '#wrap').css( 'margin-left', 'auto');

                if ( jQuery( '#tf-designpanel-toggle' ).hasClass( 'toggle-on' ) ) {
                    jQuery( '#wrap').css( 'margin-left', 'auto').css( 'margin-left', ( parseInt( jQuery('#wrap').css( 'margin-left' ).replace( 'px', '' ) ) + DesignPanelMarginOffset ) );
                } else {
                    jQuery( '#wrap').css( 'margin-left', 'auto');
                }
            }

        }, 50);

    } );

    }

    TFConfigurableBackground = new function() {

        var self = this;

        self.backgroundImage = '';
        self.backgroundImageOptions = backgroundImageOptions;

        self.setupBackgroundImageOptionsSelector = function() {

            var container = jQuery( '#configurable-background' );

            jQuery.each( self.backgroundImageOptions, function( key, backgroundImage ) {

                var thumb = jQuery( '<div class="texture-thumb"><img src="'+backgroundImage.thumbnail+'" /></div>' );

                thumb.find( 'img' ).click( function() {

                    self.setBackgroundImage( backgroundImage );

                } );

                container.append( thumb );

            } );

        }
        self.setupBackgroundImageOptionsSelector();

        self.setBackgroundImage = function( backgroundImage ) {

            jQuery( 'body' ).css( 'background-image', 'url('+backgroundImage.image+')' );

            TFThemeConfigurationUpdater.updateData( 'background-image', backgroundImage.image );

        }

    }

} );


// Configurable theme color object
var TFConfigurableThemeColor = function( id, colorObject ) {

    var self = this;

    self.id 		= String( id );
    self.color 		= colorObject;
    self.colorPicker= null;

    TFThemeConfigurationUpdater.setDataForKey( 'colors', self.id, self.color.value );

    self.setColor = function( color ) {

        jQuery.each( self.color.css, function( property, selector ) {

            jQuery( selector ).css( property, color );

        } );

        var data = {};
        data[id] = color;

        TFThemeConfigurationUpdater.updateDataForKey( 'colors', self.id, color );
    }

}

var TFConfigurableThemeLogo = new function() {

	var self = this;
	self.image_id = 0;

	jQuery( document ).ready( function () {

        if ( typeof ImageWellController === 'undefined' )
            return;

        ImageWellController.addFileUploadCallbackForImageWell( 'tf_logo_id', function() {
				
			var image_id = jQuery( 'input[name="tf_logo_id"]' ).val();
			TFThemeConfigurationUpdater.updateData( 'logo_id', image_id );

		} );
	} );

}

// Configurable theme font object
var TFConfigurableThemeFont = function( id, fontObject ) {

    var self = this;

    self.id 		= String( id );
    self.font 		= fontObject;

    jQuery( '#font-' + id ).on( 'click', 'img', function() {

        self.setFont( jQuery( this ).attr( 'data-font-name' ) );
    } );

    self.setFont = function( font ) {

        jQuery.each( self.font.font_options, function( key , value ) {

            if ( key != font )
                jQuery( '#wrap' ).removeClass( value.class_name );

            else
                jQuery( '#wrap' ).addClass( value.class_name );
        } );

        TFThemeConfigurationUpdater.updateDataForKey( 'fonts', self.id, font );
    }

}

var TFConfigurableThemePresets = new function() {

	var self = this;
	
	jQuery( document ).ready( function() {
		self.presets = themePresets;
		
		jQuery( '#tf-presets a' ).on( 'click', function(e) {
			
			e.preventDefault();

			self.setPreset( jQuery( this ).attr('data-preset') );
		} );
	} );

	self.setPreset = function( preset ) {
		
		var preset = self.presets[preset];

		jQuery.each( preset.colors, function( key, color ) {
			
			var configurableColor = TFConfigurableThemeColors.getColorByName( key );
			
			configurableColor.setColor( color );
			configurableColor.colorPicker.find('div').css("backgroundColor", color);
			configurableColor.colorPicker.ColorPickerSetColor( color );
		} );
		
		TFConfigurableBackground.setBackgroundImage( { image: preset.background } );

        if ( typeof ( preset.fonts ) != 'undefined ') {

            jQuery.each( preset.fonts, function( key, value ) {
                TFConfigurableThemeFonts.getFontSectionById( key ).setFont( value );
            } );
        }
	}

}

var TFThemeConfigurationUpdater = new function() {

	var self = this;
	self.data = {};
	self._timer = null;
	self.request = null;
	
	self.save = function() {
		
		if ( self.request != null )
			self.request.abort()
			
		self.data['action'] = 'tf_save_theme_configuration';
		
		self.request = jQuery.post( TFThemeConfigurationUpdateURL, self.data, function( url ) {
		
			jQuery( '#themecolors-css' ).attr( 'href', url );
		
		} );
	}
	
	self.setData = function( key, value, append ) {

		self.data[key] = value;
	}
	
	self.setDataForKey = function( option, key, value ) {
		
		self.data[option] = self.data[option] || {};
		
		self.data[option][key] = value;
	
	}

	self.updateData = function( key, value, append ) {
	
		self.setData( key, value, append );
		self.queueSave();
	}
	
	self.updateDataForKey = function( key, value, append ) {
	
		self.setDataForKey( key, value, append );
		self.queueSave();
	}
	
	self.queueSave = function() {
		
		if ( self._timer != null )
			clearTimeout( self._timer );
		
		self._timer = setTimeout( self.save, 500 );
	
	}

}