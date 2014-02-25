(function() {
	// Load plugin specific language pack
	
	var t = this;
	
	tinymce.create('tinymce.plugins.tf_events_shortcode_plugin', {
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
			ed.addCommand('mceExecTFEventsInsertShortcode', function() {
				
				if( typeof( t.activeShortcode ) !== 'undefined' && t.activeShortcode > '' )
					var args = t._parseShortcode( t.activeShortcode );
				else
					var args = {};
				
				t.activeShortcode = '';
				var argUrl = url + '/insert_shortcode_dialog.php?' + jQuery.param( args );
				
				ed.windowManager.open({
					file : argUrl,
					width : 400,
					height : 280,
					inline : 1
				}, {
					plugin_url : url, // Plugin absolute URL
					some_custom_arg : 'custom arg' // Custom argument
				});
			});
			
			ed.onMouseDown.add(function(ed, e) {
			
				if ( e.target.nodeName == 'INPUT' && ed.dom.hasClass(e.target, 'tfEventsShortcode') ) {
					ed.plugins.wordpress._showButtons(e.target, 'tf_events_btns');
					
					ed.selection.select(e.target);
					
				} else {
					tinymce.DOM.hide('tf_events_btns');
				}
								
								
			});
			
			ed.onBeforeSetContent.add(function(ed, o) {
				o.content = t._do_events_shortcode_image_replace(o.content);
			});
			
			ed.onPostProcess.add(function(ed, o) {
				if (o.get)
					o.content = t._do_events_shortcode_from_content(o.content);
			});
			
			ed.onExecCommand.add(function(ed, cmd, ui, val) {

				if( cmd == "mceInsertContent" ) {
			  	  ed.setContent( ed.getContent() );
				}
			} );
			
			ed.onChange.add(function(ed, l) {
				tinymce.DOM.hide('tf_events_btns');
			} );
			
		},
		
		_do_events_shortcode_from_content : function(co) {
			
			function getAttr(s, n) {
				n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
				return n ? tinymce.DOM.decode(n[1]) : '';
			};
			
			return co.replace(/<input class="tfEventsShortcode([^\/]*?)\/>/g, function(a,b){
				var shortcode = getAttr( a, 'data-shortcode' ).replace( /&quot;/g, '"' );
				shortcode = shortcode.replace( '_tf_', 'tf-' );
				return shortcode;
			});
			
		},
		
		_do_events_shortcode_image_replace : function(co) {
		
			return co.replace(/(\[tf-events-(feat|full)([^\]]*)\])/g, function(a,b) {
				
				var args = t._parseShortcode( b );
				var style = '';
				var encodedShortode = b.replace( /"|'/g, '&quot;' );
				
				encodedShortode = encodedShortode.replace( 'tf-', '_tf_' );
				
				if( args.align == 'left' )
					style = 'float:left; width: 49%;';
				else if( args.align == 'right' )
					style = 'float:right; width: 49%;';
				else
					style = 'clear:both; width: 100%;';

				return '<input type="button" class="tfEventsShortcode" data-shortcode="'+encodedShortode+'" style="' + style + '" value="EVENTS  -  Category: '+ args.group + '  -  Style: ' + args.type + '" />';
				
				$('.tfEventsShortcode').replaceWith('<h2>New heading</h2>');
				
			});
		
		},
		
		_createButtons : function() {
			var t = this, ed = tinyMCE.activeEditor, DOM = tinymce.DOM, editButton, dellButton;
			

			//DOM.remove('wp_gallerybtns');
			DOM.remove('wp_editbtns');
			DOM.remove('tf_events_btns');
			
			DOM.add(document.body, 'div', {
				id : 'tf_events_btns',
				style : 'display:none;position:absolute;'
			});

			editButton = DOM.add('tf_events_btns', 'img', {
				src : t.url+'/event_16.png',
				id : 'tf_events_btn_edit',
				width : '20',
				height : '20',
				title : "Edit Events",
				style: 'background: #fff; padding: 2px; border-radius:3px; border: 1px solid #999; margin-right: 5px;'
			});

			tinymce.dom.Event.add(editButton, 'mousedown', function(e) {
				var ed = tinyMCE.activeEditor;
				ed.windowManager.bookmark = ed.selection.getBookmark('simple');
				
				t.activeShortcode = tinyMCE.activeEditor.selection.getContent()
								
				ed.execCommand("mceExecTFEventsInsertShortcode");
			});

			dellButton = DOM.add('tf_events_btns', 'img', {
				src : t.url+'/img/delete.png',
				id : 'tf_events_btn_del',
				width : '20',
				height : '20',
				title : 'Delete Event Shortcode',
				style: 'background: #fff; padding: 2px; border-radius:3px; border: 1px solid #999;'

			});

			tinymce.dom.Event.add(dellButton, 'mousedown', function(e) {
				var ed = tinyMCE.activeEditor, el = ed.selection.getNode();

				if ( el.nodeName == 'INPUT' && ed.dom.hasClass(el, 'tfEventsShortcode') ) {
					ed.dom.remove(el);
					tinymce.DOM.hide('tf_events_btns');
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
			
			args.group = getAttr( shortcode, 'group' ) ? getAttr( shortcode, 'group' ) : 'All';
			args.limit = getAttr( shortcode, 'limit' ) ? getAttr( shortcode, 'limit' ) : 'No Limit';
			args.type = new RegExp('\\[tf-events-([^ ]+)', 'g').exec(shortcode);
			args.showHeader = getAttr( shortcode, 'header' ) ? getAttr( shortcode, 'header' ) : 'no';
			
			if( !args.type )
				args.type = 'full';
			else
				args.type = args.type[1].charAt(0).toUpperCase() + args.type[1].slice(1);
				
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
			        longname : 'ThemeForce Events Shortcode',
			        author : 'ThemeForce',
			        authorurl : 'http://theme-force.com',
			        infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
			        version : "1.0"
			};
		}
	});
	
	// Register plugin
	tinymce.PluginManager.add('tf_events_shortcode_plugin', tinymce.plugins.tf_events_shortcode_plugin);

})();