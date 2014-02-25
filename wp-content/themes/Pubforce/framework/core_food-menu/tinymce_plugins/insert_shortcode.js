(function() {
	// Load plugin specific language pack
	
	var t = this;
	
	tinymce.create('tinymce.plugins.tf_food_menu_shortcode_plugin', {
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
			ed.addCommand('mceExecTFFoodMenuInsertShortcode', function() {
				
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
			
			// Register example button
			ed.addButton('tf_food_menu_shortcode_plugin', {
				title : 'Insert Food Menu',
				cmd : 'mceExecTFFoodMenuInsertShortcode',
				image : url + '/food_20.png'
			});

			
			ed.onMouseDown.add(function(ed, e) {
			
				if ( e.target.nodeName == 'INPUT' && ed.dom.hasClass(e.target, 'tfFoodMenuShortcode') ) {
					
					if ( ed.dom.hasClass(e.target, 'legacy' ) )
						ed.plugins.wordpress._showButtons(e.target, 'tf_foodmenu_btns_legacy');
					
					else
						ed.plugins.wordpress._showButtons(e.target, 'tf_foodmenu_btns');
					
					ed.selection.select(e.target);
					
				} else {
					tinymce.DOM.hide('tf_foodmenu_btns_legacy');
					tinymce.DOM.hide('tf_foodmenu_btns');
				}
								
								
			});
			
			ed.onBeforeSetContent.add(function(ed, o) {
				o.content = t._do_foodmenu_legacy_shortcode_image_replace( o.content );
				o.content = t._do_foodmenu_shortcode_image_replace(o.content);
			});
			
			ed.onPostProcess.add(function(ed, o) {
				if (o.get)
					o.content = t._do_foodmenu_shortcode_from_content(o.content);
			});
			
			ed.onExecCommand.add(function(ed, cmd, ui, val) {

				if( cmd == "mceInsertContent" ) {
			  	  ed.setContent( ed.getContent() );
				}
			} );
			
			ed.onChange.add(function(ed, l) {
				tinymce.DOM.hide('tf_foodmenu_btns');
				tinymce.DOM.hide('tf_foodmenu_btns_legacy');
			} );
			
		},
		
		_do_foodmenu_shortcode_from_content : function(co) {
			
			function getAttr(s, n) {
				n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
				return n ? tinymce.DOM.decode(n[1]) : '';
			};
			
			return co.replace(/<input class="tfFoodMenuShortcode([^\/]*?)\/>/g, function(a,b){
				var shortcode = getAttr( a, 'data-shortcode' ).replace( /&quot;/g, '"' );
				shortcode = shortcode.replace( '_tf_', 'tf-' );
				return shortcode;
			});
			
		},
		
		_do_foodmenu_legacy_shortcode_image_replace : function(co) {
		
			return co.replace(/(\[tf-menu-([^\]]*)\])/g, function(a,b) {
				
				var args = t._parseShortcode( b );
				var style = '';
				var encodedShortode = b.replace( /"|'/g, '&quot;' );
				
				encodedShortode = encodedShortode.replace( 'tf-', '_tf_' );
				
				if( args.align == 'left' )
					style = 'width: 49%;';
				else if( args.align == 'right' )
					style = 'width: 49%;';
				else
					style = 'clear:both; width:100%;'
				
					var after = '&nbsp;';

				var note = '';
				
				// Not full width
				if( jQuery( '#page_template' ).val() != 'page-full.php' && jQuery( '#page_template' ).val() != 'onecolumn-page.php' ) {
					if( args.align == 'left' || args.align == 'right' )
						note = 'Align is only supported on Full Width template.';
					
				} else {
					
					if( args.type == 'short' )
						note = 'Short is not supported on Full Width template.';
				}
				
				return '<input type="button" class="tfFoodMenuShortcode legacy ' + args.align + '" data-shortcode="'+encodedShortode+'" style="' + style + '" value="FOOD MENU  -  Category: '+ args.id + '  -  Style: ' + args.type + (note?"\n"+'[Note: '+note+']':'') + '" />' + after;
			});
		
		},
		
		_do_foodmenu_shortcode_image_replace : function(co) {
		
			return co.replace(/(\[foodmenu ([^\]]*)\])/g, function(a,b) {
				
				var args = t._parseShortcode( b );
				var style = '';
				var encodedShortode = b.replace( /"|'/g, '&quot;' );
				
				style = 'clear:both; width:100%;'

				var after = '&nbsp;';
				
				if ( typeof ( window.TFFoodMenus[Number(args.id)] ) == 'undefined' )
					after += '[WARNING: Menu does not exist]';
					
				else
					after += window.TFFoodMenus[Number(args.id)]["menu-name"];

				var note = '';
								
				return '<input type="button" class="tfFoodMenuShortcode" data-shortcode="'+encodedShortode+'" style="' + style + '" value="FOOD MENU ' + after + '" />';
			});
		
		},
		
		_createButtons : function() {
			var t = this, ed = tinyMCE.activeEditor, DOM = tinymce.DOM, editButton, dellButton;
			

			//DOM.remove('wp_gallerybtns');
			DOM.remove('wp_editbtns');
			DOM.remove('tf_foodmenu_btns');
			DOM.remove('tf_foodmenu_btns_legacy');
						
			DOM.add(document.body, 'div', {
				id : 'tf_foodmenu_btns',
				style : 'display:none;position:absolute;'
			});
			
			DOM.add(document.body, 'div', {
				id : 'tf_foodmenu_btns_legacy',
				style : 'display:none;position:absolute;'
			});

			editButton = DOM.add('tf_foodmenu_btns_legacy', 'img', {
				src : t.url+'/food_20.png',
				id : 'tf_foodmenu_btn_edit',
				width : '20',
				height : '20',
				title : "Edit Food Menu",
				style: 'background: #fff; padding: 2px; border-radius:3px; border: 1px solid #999; margin-right: 5px;'
			});

			tinymce.dom.Event.add(editButton, 'mousedown', function(e) {
				var ed = tinyMCE.activeEditor;
				ed.windowManager.bookmark = ed.selection.getBookmark('simple');
				
				t.activeShortcode = tinyMCE.activeEditor.selection.getContent()
								
				ed.execCommand("mceExecTFFoodMenuInsertShortcode");
			});

			dellButton = DOM.add('tf_foodmenu_btns_legacy', 'img', {
				src : t.url+'/img/delete.png',
				id : 'tf_foodmenu_legacy_btn_del',
				width : '20',
				height : '20',
				title : ed.getLang('wordpress.delgallery'),
				style: 'background: #fff; padding: 2px; border-radius:3px; border: 1px solid #999;'

			});

			tinymce.dom.Event.add(dellButton, 'mousedown', function(e) {
				var ed = tinyMCE.activeEditor, el = ed.selection.getNode();

				if ( el.nodeName == 'INPUT' && ed.dom.hasClass(el, 'tfFoodMenuShortcode') ) {
					ed.dom.remove(el);
					tinymce.DOM.hide('tf_foodmenu_btns_legacy');
					ed.execCommand('mceRepaint');
					return false;
				}
			});
			
			dellButton = DOM.add('tf_foodmenu_btns', 'img', {
				src : t.url+'/img/delete.png',
				id : 'tf_foodmenu_btn_del',
				width : '20',
				height : '20',
				title : ed.getLang('wordpress.delgallery'),
				style: 'background: #fff; padding: 2px; border-radius:3px; border: 1px solid #999;'

			});

			tinymce.dom.Event.add(dellButton, 'mousedown', function(e) {
				var ed = tinyMCE.activeEditor, el = ed.selection.getNode();

				if ( el.nodeName == 'INPUT' && ed.dom.hasClass(el, 'tfFoodMenuShortcode') ) {
					ed.dom.remove(el);
					tinymce.DOM.hide('tf_foodmenu_btns');
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
			
			if ( shortcode.indexOf( 'tf-menu-' ) != -1 ) {
				
				//legacy
				
				args.id = getAttr( shortcode, 'id' ) ? getAttr( shortcode, 'id' ) : 'All';
				args.align = getAttr( shortcode, 'align' ) ? getAttr( shortcode, 'align' ) : 'none';
				args.type = new RegExp('\\[tf-menu-([^ ]+)', 'g').exec(shortcode);
				args.showHeader = getAttr( shortcode, 'header' ) ? getAttr( shortcode, 'header' ) : 'no';
				
			} else if ( shortcode.indexOf( 'foodmenu' ) != -1 ) {
			
				args.type = 'menu';
				args.id = getAttr( shortcode, 'id' );
			}

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
			        longname : 'ThemeForce Food Menu Shortcode',
			        author : 'ThemeForce',
			        authorurl : 'http://theme-force.com',
			        infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
			        version : "1.0"
			};
		}
	});
	
	// Register plugin
	tinymce.PluginManager.add('tf_food_menu_shortcode_plugin', tinymce.plugins.tf_food_menu_shortcode_plugin);

})();