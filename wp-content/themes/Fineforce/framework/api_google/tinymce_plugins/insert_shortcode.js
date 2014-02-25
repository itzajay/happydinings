(function() {
	// Load plugin specific language pack
	
	var t = this;

	tinymce.create('tinymce.plugins.tf_google_maps_shortcode_plugin', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			
			t = this;

			t.url = url;
			
			t._createButtons();

			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('mceExecTFGoogleMapsInsertShortcode', function() {

				if( typeof( t.activeShortcode ) !== 'undefined' && t.activeShortcode > '' )
					var args = t._parseShortcode( t.activeShortcode );
				else
					var args = {};
				
				t.activeShortcode = '';
				var argUrl = url + '/insert_shortcode_dialog.php?' + jQuery.param( args );
				
				ed.windowManager.open({
					file : argUrl,
					width : 600,
					height : 480,
					inline : 1
				}, {
					plugin_url : url, // Plugin absolute URL
					some_custom_arg : 'custom arg' // Custom argument
				});
			});
			
			ed.onMouseDown.add(function(ed, e) {
			
				if ( e.target.nodeName == 'IMG' && ed.dom.hasClass(e.target, 'TFGoogleMapsShortcode') ) {
					ed.plugins.wordpress._showButtons(e.target, 'tf_google_maps_btns');
					ed.selection.select(e.target);
					
				} else {
					tinymce.DOM.hide('tf_google_maps_btns');
				}
								
								
			});
			
			ed.onBeforeSetContent.add(function(ed, o) {
				o.content = t._do_google_maps_shortcode_image_replace(o.content);
			});
			
			ed.onPostProcess.add(function(ed, o) {
				if (o.get)
					o.content = t._do_google_maps_shortcode_from_content(o.content);
			});
			
			ed.onExecCommand.add(function(ed, cmd, ui, val) {

				if( cmd == "mceInsertContent" ) {
			  	  ed.setContent( ed.getContent() );
				}
			} );
			
			ed.onChange.add(function(ed, l) {
				tinymce.DOM.hide('tf_google_maps_btns');
			} );
			
		},
		
		_do_google_maps_shortcode_from_content : function(co) {
			
			function getAttr(s, n) {
				n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
				return n ? tinymce.DOM.decode(n[1]) : '';
			};
			
			var shortcode = '';
			
			return co.replace(/<img class="TFGoogleMapsShortcode([\s\S]*?)\/>/g, function(a,b){
				var shortcode = getAttr( a, 'data-shortcode' ).replace( /&quot;/g, '"' );

				shortcode = shortcode.replace( '_tf_', 'tf-' );
				return shortcode;
			});
			
		},
		
		_do_google_maps_shortcode_image_replace : function(co) {
		
			return co.replace(/(\[tf-googlemaps([^\]]*)\])/g, function(a,b) {
				
				var args = t._parseShortcode( b );
				var encodedShortode = b.replace( /"|'/g, '&quot;' );
				var address = window.parent.TFAddress;

				var src = 'http://maps.google.com/maps/api/staticmap?center=' + address + '&zoom=' + args.zoom + '&size=' + args.width + 'x' + args.height + '&markers=color:' + args.color + '|' + address + '&sensor=false';

				encodedShortode = encodedShortode.replace( 'tf-', '_tf_' );
				
				return '<img class="TFGoogleMapsShortcode align' + args.align + '" width="' + args.width + '" height="' + args.height + '" data-shortcode="'+encodedShortode+'" src="' + src + '" />';
			});
		
		},
		
		_createButtons : function() {
			var t = this, ed = tinyMCE.activeEditor, DOM = tinymce.DOM, editButton, dellButton;
			

			//DOM.remove('wp_gallerybtns');
			DOM.remove('wp_editbtns');
			DOM.remove('tf_google_maps_btns');
			
			DOM.add(document.body, 'div', {
				id : 'tf_google_maps_btns',
				style : 'display:none;position:absolute;'
			});

			editButton = DOM.add('tf_google_maps_btns', 'img', {
				src : t.url+'/map_20.png',
				id : 'tf_google_maps_btns_edit',
				width : '20',
				height : '20',
				title : "Edit Map",
				style: 'background: #fff; padding: 2px; border-radius:3px; border: 1px solid #999; margin-right: 5px;'
			});

			tinymce.dom.Event.add(editButton, 'mousedown', function(e) {
				var ed = tinyMCE.activeEditor;
				ed.windowManager.bookmark = ed.selection.getBookmark('simple');
				
				t.activeShortcode = tinyMCE.activeEditor.selection.getContent()
								
				ed.execCommand("mceExecTFGoogleMapsInsertShortcode");
			});

			dellButton = DOM.add('tf_google_maps_btns', 'img', {
				src : t.url+'/img/delete.png',
				id : 'tf_google_maps_btn_del',
				width : '20',
				height : '20',
				title : ed.getLang('wordpress.delgallery'),
				style: 'background: #fff; padding: 2px; border-radius:3px; border: 1px solid #999;'

			});

			tinymce.dom.Event.add(dellButton, 'mousedown', function(e) {
				var ed = tinyMCE.activeEditor, el = ed.selection.getNode();

				if ( el.nodeName == 'IMG' && ed.dom.hasClass(el, 'TFGoogleMapsShortcode') ) {
					ed.dom.remove(el);
					tinymce.DOM.hide('tf_google_maps_btns');
					ed.execCommand('mceRepaint');
					return false;
				}
			});
		},
		
		_parseShortcode : function( shortcode ) {
		
			var args = {};
			
			function getAttr(s, n) {
				result = new RegExp(n + '=\"([^"]+)\"', 'g').exec(s);

				if( result )
					return tinymce.DOM.decode(result[1]);
				
				result = new RegExp(n + "=\'([^']+)\'", 'g').exec(s);
				
				if( result )
				  return tinymce.DOM.decode(result[1]);
				
				return '';
			};
			
			args.width = getAttr( shortcode, 'width' ) ? getAttr( shortcode, 'width' ) : 527;
			args.height = getAttr( shortcode, 'height' ) ? getAttr( shortcode, 'height' ) : 527;
			args.align = getAttr( shortcode, 'align' ) ? getAttr( shortcode, 'align' ) : 'none';
			args.color = getAttr( shortcode, 'color' ) ? getAttr( shortcode, 'color' ) : 'green';
			args.zoom = getAttr( shortcode, 'zoom' ) ? getAttr( shortcode, 'zoom' ) : 13;
				
			return args;
		},
		
		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'ThemeForce Google Maps Shortcode',
				author : 'ThemeForce',
				authorurl : 'http://theme-force.com',
				infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
				version : "1.0"
			};
		}
	});
	
	// Register plugin
	tinymce.PluginManager.add('tf_google_maps_shortcode_plugin', tinymce.plugins.tf_google_maps_shortcode_plugin);

})();