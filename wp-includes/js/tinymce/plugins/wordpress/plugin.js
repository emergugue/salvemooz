<<<<<<< HEAD
/* global getUserSetting, setUserSetting */
( function( tinymce ) {
=======
/* global tinymce, getUserSetting, setUserSetting */

>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
// Set the minimum value for the modals z-index higher than #wpadminbar (100000)
tinymce.ui.FloatPanel.zIndex = 100100;

tinymce.PluginManager.add( 'wordpress', function( editor ) {
<<<<<<< HEAD
	var wpAdvButton, style,
		DOM = tinymce.DOM,
		each = tinymce.each,
		__ = editor.editorManager.i18n.translate,
		$ = window.jQuery,
		wp = window.wp,
		hasWpautop = ( wp && wp.editor && wp.editor.autop && editor.getParam( 'wpautop', true ) );

	if ( $ ) {
		$( document ).triggerHandler( 'tinymce-editor-setup', [ editor ] );
=======
	var DOM = tinymce.DOM,
		each = tinymce.each,
		__ = editor.editorManager.i18n.translate,
		wpAdvButton, style,
		last = 0;

	if ( typeof window.jQuery !== 'undefined' ) {
		window.jQuery( document ).triggerHandler( 'tinymce-editor-setup', [ editor ] );
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
	}

	function toggleToolbars( state ) {
		var iframe, initial, toolbars,
			pixels = 0;

		initial = ( state === 'hide' );

		if ( editor.theme.panel ) {
			toolbars = editor.theme.panel.find('.toolbar:not(.menubar)');
		}

		if ( ! toolbars || toolbars.length < 2 || ( state === 'hide' && ! toolbars[1].visible() ) ) {
			return;
		}

		if ( ! state && toolbars[1].visible() ) {
			state = 'hide';
		}

		each( toolbars, function( toolbar, i ) {
			if ( i > 0 ) {
				if ( state === 'hide' ) {
					toolbar.hide();
					pixels += 30;
				} else {
					toolbar.show();
					pixels -= 30;
				}
			}
		});

		if ( pixels && ! initial ) {
			// Resize iframe, not needed in iOS
			if ( ! tinymce.Env.iOS ) {
				iframe = editor.getContentAreaContainer().firstChild;
				DOM.setStyle( iframe, 'height', iframe.clientHeight + pixels );
			}

			if ( state === 'hide' ) {
				setUserSetting('hidetb', '0');
				wpAdvButton && wpAdvButton.active( false );
			} else {
				setUserSetting('hidetb', '1');
				wpAdvButton && wpAdvButton.active( true );
			}
		}

		editor.fire( 'wp-toolbar-toggle' );
	}

	// Add the kitchen sink button :)
	editor.addButton( 'wp_adv', {
		tooltip: 'Toolbar Toggle',
		cmd: 'WP_Adv',
		onPostRender: function() {
			wpAdvButton = this;
			wpAdvButton.active( getUserSetting( 'hidetb' ) === '1' ? true : false );
		}
	});

	// Hide the toolbars after loading
	editor.on( 'PostRender', function() {
		if ( editor.getParam( 'wordpress_adv_hidden', true ) && getUserSetting( 'hidetb', '0' ) === '0' ) {
			toggleToolbars( 'hide' );
		}
	});

	editor.addCommand( 'WP_Adv', function() {
		toggleToolbars();
	});

	editor.on( 'focus', function() {
        window.wpActiveEditor = editor.id;
    });

	// Replace Read More/Next Page tags with images
<<<<<<< HEAD
	editor.on( 'BeforeSetContent', function( event ) {
		var title;

		if ( event.content ) {
			if ( event.content.indexOf( '<!--more' ) !== -1 ) {
				title = __( 'Read more...' );

				event.content = event.content.replace( /<!--more(.*?)-->/g, function( match, moretext ) {
=======
	editor.on( 'BeforeSetContent', function( e ) {
		var title;

		if ( e.content ) {
			if ( e.content.indexOf( '<!--more' ) !== -1 ) {
				title = __( 'Read more...' );

				e.content = e.content.replace( /<!--more(.*?)-->/g, function( match, moretext ) {
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
					return '<img src="' + tinymce.Env.transparentSrc + '" data-wp-more="more" data-wp-more-text="' + moretext + '" ' +
						'class="wp-more-tag mce-wp-more" title="' + title + '" data-mce-resize="false" data-mce-placeholder="1" />';
				});
			}

<<<<<<< HEAD
			if ( event.content.indexOf( '<!--nextpage-->' ) !== -1 ) {
				title = __( 'Page break' );

				event.content = event.content.replace( /<!--nextpage-->/g,
					'<img src="' + tinymce.Env.transparentSrc + '" data-wp-more="nextpage" class="wp-more-tag mce-wp-nextpage" ' +
						'title="' + title + '" data-mce-resize="false" data-mce-placeholder="1" />' );
			}

			if ( event.load && event.format !== 'raw' && hasWpautop ) {
				event.content = wp.editor.autop( event.content );
			}

			// Remove spaces from empty paragraphs.
			event.content = event.content.replace( /<p>(?:&nbsp;|\u00a0|\uFEFF|\s)+<\/p>/gi, '<p><br /></p>' );
=======
			if ( e.content.indexOf( '<!--nextpage-->' ) !== -1 ) {
				title = __( 'Page break' );

				e.content = e.content.replace( /<!--nextpage-->/g,
					'<img src="' + tinymce.Env.transparentSrc + '" data-wp-more="nextpage" class="wp-more-tag mce-wp-nextpage" ' +
						'title="' + title + '" data-mce-resize="false" data-mce-placeholder="1" />' );
			}
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
		}
	});

	// Replace images with tags
	editor.on( 'PostProcess', function( e ) {
		if ( e.get ) {
			e.content = e.content.replace(/<img[^>]+>/g, function( image ) {
				var match, moretext = '';

				if ( image.indexOf( 'data-wp-more="more"' ) !== -1 ) {
					if ( match = image.match( /data-wp-more-text="([^"]+)"/ ) ) {
						moretext = match[1];
					}

					image = '<!--more' + moretext + '-->';
				} else if ( image.indexOf( 'data-wp-more="nextpage"' ) !== -1 ) {
					image = '<!--nextpage-->';
				}

				return image;
			});
		}
	});

	// Display the tag name instead of img in element path
	editor.on( 'ResolveName', function( event ) {
		var attr;

		if ( event.target.nodeName === 'IMG' && ( attr = editor.dom.getAttrib( event.target, 'data-wp-more' ) ) ) {
			event.name = attr;
		}
	});

	// Register commands
	editor.addCommand( 'WP_More', function( tag ) {
		var parent, html, title,
			classname = 'wp-more-tag',
			dom = editor.dom,
			node = editor.selection.getNode();

		tag = tag || 'more';
		classname += ' mce-wp-' + tag;
		title = tag === 'more' ? 'Read more...' : 'Next page';
		title = __( title );
		html = '<img src="' + tinymce.Env.transparentSrc + '" title="' + title + '" class="' + classname + '" ' +
			'data-wp-more="' + tag + '" data-mce-resize="false" data-mce-placeholder="1" />';

		// Most common case
		if ( node.nodeName === 'BODY' || ( node.nodeName === 'P' && node.parentNode.nodeName === 'BODY' ) ) {
			editor.insertContent( html );
			return;
		}

		// Get the top level parent node
		parent = dom.getParent( node, function( found ) {
			if ( found.parentNode && found.parentNode.nodeName === 'BODY' ) {
				return true;
			}

			return false;
		}, editor.getBody() );

		if ( parent ) {
			if ( parent.nodeName === 'P' ) {
				parent.appendChild( dom.create( 'p', null, html ).firstChild );
			} else {
				dom.insertAfter( dom.create( 'p', null, html ), parent );
			}

			editor.nodeChanged();
		}
	});

	editor.addCommand( 'WP_Code', function() {
		editor.formatter.toggle('code');
	});

	editor.addCommand( 'WP_Page', function() {
		editor.execCommand( 'WP_More', 'nextpage' );
	});

	editor.addCommand( 'WP_Help', function() {
<<<<<<< HEAD
		var access = tinymce.Env.mac ? __( 'Ctrl + Alt + letter:' ) : __( 'Shift + Alt + letter:' ),
			meta = tinymce.Env.mac ? __( 'Cmd + letter:' ) : __( 'Ctrl + letter:' ),
			table1 = [],
			table2 = [],
			header, html, dialog, $wrap;

		each( [
			{ c: 'Copy',      x: 'Cut'              },
			{ v: 'Paste',     a: 'Select all'       },
			{ z: 'Undo',      y: 'Redo'             },
			{ b: 'Bold',      i: 'Italic'           },
			{ u: 'Underline', k: 'Insert/edit link' }
		], function( row ) {
			table1.push( tr( row ) );
		} );

		each( [
			{ 1: 'Heading 1',             2: 'Heading 2'                     },
			{ 3: 'Heading 3',             4: 'Heading 4'                     },
			{ 5: 'Heading 5',             6: 'Heading 6'                     },
			{ l: 'Align left',            c: 'Align center'                  },
			{ r: 'Align right',           j: 'Justify'                       },
			{ d: 'Strikethrough',         q: 'Blockquote'                    },
			{ u: 'Bullet list',           o: 'Numbered list'                 },
			{ a: 'Insert/edit link',      s: 'Remove link'                   },
			{ m: 'Insert/edit image',     t: 'Insert Read More tag'          },
			{ h: 'Keyboard Shortcuts',    x: 'Code'                          },
			{ p: 'Insert Page Break tag', w: 'Distraction-free writing mode' }
		], function( row ) {
			table2.push( tr( row ) );
		} );

		function tr( row ) {
			var out = '<tr>';

			each( row, function( text, key ) {
				if ( ! text ) {
					out += '<td></td><td></td>';
				} else {
					out += '<td><kbd>' + key + '</kbd></td><td>' + __( text ) + '</td>';
				}
			});

			return out + '</tr>';
		}

		header = [ __( 'Letter' ), __( 'Action' ), __( 'Letter' ), __( 'Action' ) ];
		header = '<tr><th>' + header.join( '</th><th>' ) + '</th></tr>';

		html = '<div class="wp-editor-help">';

		// Main section, default and additional shortcuts
		html = html +
			'<h2>' + __( 'Default shortcuts,' ) + ' ' + meta + '</h2>' +
			'<table class="wp-help-th-center">' +
				header +
				table1.join('') +
			'</table>' +
			'<h2>' + __( 'Additional shortcuts,' ) + ' ' + access + '</h2>' +
			'<table class="wp-help-th-center">' +
				header +
				table2.join('') +
			'</table>';

		if ( editor.plugins.wptextpattern ) {
			// Text pattern section
			html = html +
				'<h2>' + __( 'When starting a new paragraph with one of these formatting shortcuts followed by a space, the formatting will be applied automatically. Press Backspace or Escape to undo.' ) + '</h2>' +
				'<table>' +
					tr({ '*':  'Bullet list' }) +
					tr({ '-':  'Bullet list' }) +
					tr({ '1.':  'Numbered list' }) +
					tr({ '1)':  'Numbered list' }) +
				'</table>';

			html = html +
				'<h2>' + __( 'The following formatting shortcuts are replaced when pressing Enter. Press Escape or the Undo button to undo.' ) + '</h2>' +
				'<table>' +
					tr({ '>': 'Blockquote' }) +
					tr({ '##': 'Heading 2' }) +
					tr({ '###': 'Heading 3' }) +
					tr({ '####': 'Heading 4' }) +
					tr({ '#####': 'Heading 5' }) +
					tr({ '######': 'Heading 6' }) +
				'</table>';
		}

		// Focus management section
		html = html +
			'<h2>' + __( 'Focus shortcuts:' ) + '</h2>' +
			'<table>' +
				tr({ 'Alt + F8':  'Inline toolbar (when an image, link or preview is selected)' }) +
				tr({ 'Alt + F9':  'Editor menu (when enabled)' }) +
				tr({ 'Alt + F10': 'Editor toolbar' }) +
				tr({ 'Alt + F11': 'Elements path' }) +
			'</table>' +
			'<p>' + __( 'To move focus to other buttons use Tab or the arrow keys. To return focus to the editor press Escape or use one of the buttons.' ) + '</p>';

		html += '</div>';

		dialog = editor.windowManager.open( {
			title: 'Keyboard Shortcuts',
			items: {
				type: 'container',
				classes: 'wp-help',
				html: html
			},
			buttons: {
				text: 'Close',
				onclick: 'close'
			}
		} );

		if ( dialog.$el ) {
			dialog.$el.find( 'div[role="application"]' ).attr( 'role', 'document' );
			$wrap = dialog.$el.find( '.mce-wp-help' );

			if ( $wrap[0] ) {
				$wrap.attr( 'tabindex', '0' );
				$wrap[0].focus();
				$wrap.on( 'keydown', function( event ) {
					// Prevent use of: page up, page down, end, home, left arrow, up arrow, right arrow, down arrow
					// in the dialog keydown handler.
					if ( event.keyCode >= 33 && event.keyCode <= 40 ) {
						event.stopPropagation();
					}
				});
			}
		}
	} );

	editor.addCommand( 'WP_Medialib', function() {
		if ( wp && wp.media && wp.media.editor ) {
=======
		editor.windowManager.open({
			url: tinymce.baseURL + '/wp-mce-help.php',
			title: 'Keyboard Shortcuts',
			width: 450,
			height: 420,
			classes: 'wp-help',
			buttons: { text: 'Close', onclick: 'close' }
		});
	});

	editor.addCommand( 'WP_Medialib', function() {
		if ( typeof wp !== 'undefined' && wp.media && wp.media.editor ) {
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
			wp.media.editor.open( editor.id );
		}
	});

	// Register buttons
	editor.addButton( 'wp_more', {
		tooltip: 'Insert Read More tag',
		onclick: function() {
			editor.execCommand( 'WP_More', 'more' );
		}
	});

	editor.addButton( 'wp_page', {
		tooltip: 'Page break',
		onclick: function() {
			editor.execCommand( 'WP_More', 'nextpage' );
		}
	});

	editor.addButton( 'wp_help', {
		tooltip: 'Keyboard Shortcuts',
		cmd: 'WP_Help'
	});

	editor.addButton( 'wp_code', {
		tooltip: 'Code',
		cmd: 'WP_Code',
		stateSelector: 'code'
	});

	// Menubar
	// Insert->Add Media
<<<<<<< HEAD
	if ( wp && wp.media && wp.media.editor ) {
=======
	if ( typeof wp !== 'undefined' && wp.media && wp.media.editor ) {
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
		editor.addMenuItem( 'add_media', {
			text: 'Add Media',
			icon: 'wp-media-library',
			context: 'insert',
			cmd: 'WP_Medialib'
		});
	}

	// Insert "Read More..."
	editor.addMenuItem( 'wp_more', {
		text: 'Insert Read More tag',
		icon: 'wp_more',
		context: 'insert',
		onclick: function() {
			editor.execCommand( 'WP_More', 'more' );
		}
	});

	// Insert "Next Page"
	editor.addMenuItem( 'wp_page', {
		text: 'Page break',
		icon: 'wp_page',
		context: 'insert',
		onclick: function() {
			editor.execCommand( 'WP_More', 'nextpage' );
		}
	});

	editor.on( 'BeforeExecCommand', function(e) {
		if ( tinymce.Env.webkit && ( e.command === 'InsertUnorderedList' || e.command === 'InsertOrderedList' ) ) {
			if ( ! style ) {
				style = editor.dom.create( 'style', {'type': 'text/css'},
					'#tinymce,#tinymce span,#tinymce li,#tinymce li>span,#tinymce p,#tinymce p>span{font:medium sans-serif;color:#000;line-height:normal;}');
			}

			editor.getDoc().head.appendChild( style );
		}
	});

	editor.on( 'ExecCommand', function( e ) {
		if ( tinymce.Env.webkit && style &&
			( 'InsertUnorderedList' === e.command || 'InsertOrderedList' === e.command ) ) {

			editor.dom.remove( style );
		}
	});

	editor.on( 'init', function() {
		var env = tinymce.Env,
			bodyClass = ['mceContentBody'], // back-compat for themes that use this in editor-style.css...
			doc = editor.getDoc(),
			dom = editor.dom;

<<<<<<< HEAD
		if ( env.iOS ) {
=======
		if ( tinymce.Env.iOS ) {
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
			dom.addClass( doc.documentElement, 'ios' );
		}

		if ( editor.getParam( 'directionality' ) === 'rtl' ) {
			bodyClass.push('rtl');
			dom.setAttrib( doc.documentElement, 'dir', 'rtl' );
		}

		if ( env.ie ) {
			if ( parseInt( env.ie, 10 ) === 9 ) {
				bodyClass.push('ie9');
			} else if ( parseInt( env.ie, 10 ) === 8 ) {
				bodyClass.push('ie8');
			} else if ( env.ie < 8 ) {
				bodyClass.push('ie7');
			}
		} else if ( env.webkit ) {
			bodyClass.push('webkit');
		}

		bodyClass.push('wp-editor');

		each( bodyClass, function( cls ) {
			if ( cls ) {
				dom.addClass( doc.body, cls );
			}
		});

		// Remove invalid parent paragraphs when inserting HTML
<<<<<<< HEAD
		editor.on( 'BeforeSetContent', function( event ) {
			if ( event.content ) {
				event.content = event.content.replace( /<p>\s*<(p|div|ul|ol|dl|table|blockquote|h[1-6]|fieldset|pre)( [^>]*)?>/gi, '<$1$2>' )
					.replace( /<\/(p|div|ul|ol|dl|table|blockquote|h[1-6]|fieldset|pre)>\s*<\/p>/gi, '</$1>' );
			}
		});

		if ( $ ) {
			$( document ).triggerHandler( 'tinymce-editor-init', [editor] );
=======
		// TODO: still needed?
		editor.on( 'BeforeSetContent', function( e ) {
			if ( e.content ) {
				e.content = e.content.replace(/<p>\s*<(p|div|ul|ol|dl|table|blockquote|h[1-6]|fieldset|pre|address)( [^>]*)?>/gi, '<$1$2>');
				e.content = e.content.replace(/<\/(p|div|ul|ol|dl|table|blockquote|h[1-6]|fieldset|pre|address)>\s*<\/p>/gi, '</$1>');
			}
		});

		if ( typeof window.jQuery !== 'undefined' ) {
			window.jQuery( document ).triggerHandler( 'tinymce-editor-init', [editor] );
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
		}

		if ( window.tinyMCEPreInit && window.tinyMCEPreInit.dragDropUpload ) {
			dom.bind( doc, 'dragstart dragend dragover drop', function( event ) {
<<<<<<< HEAD
				if ( $ ) {
					// Trigger the jQuery handlers.
					$( document ).trigger( new $.Event( event ) );
=======
				if ( typeof window.jQuery !== 'undefined' ) {
					// Trigger the jQuery handlers.
					window.jQuery( document ).trigger( new window.jQuery.Event( event ) );
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
				}
			});
		}

		if ( editor.getParam( 'wp_paste_filters', true ) ) {
			if ( ! tinymce.Env.webkit ) {
				// In WebKit handled by removeWebKitStyles()
				editor.on( 'PastePreProcess', function( event ) {
					// Remove all inline styles
					event.content = event.content.replace( /(<[^>]+) style="[^"]*"([^>]*>)/gi, '$1$2' );

					// Put back the internal styles
					event.content = event.content.replace(/(<[^>]+) data-mce-style=([^>]+>)/gi, '$1 style=$2' );
				});
			}

			editor.on( 'PastePostProcess', function( event ) {
				// Remove empty paragraphs
				each( dom.select( 'p', event.node ), function( node ) {
					if ( dom.isEmpty( node ) ) {
						dom.remove( node );
					}
				});
			});
		}
	});

<<<<<<< HEAD
	editor.on( 'SaveContent', function( event ) {
		// If editor is hidden, we just want the textarea's value to be saved
		if ( ! editor.inline && editor.isHidden() ) {
			event.content = event.element.value;
=======
	// Word count
	if ( typeof window.jQuery !== 'undefined' ) {
		editor.on( 'keyup', function( e ) {
			var key = e.keyCode || e.charCode;

			if ( key === last ) {
				return;
			}

			if ( 13 === key || 8 === last || 46 === last ) {
				window.jQuery( document ).triggerHandler( 'wpcountwords', [ editor.getContent({ format : 'raw' }) ] );
			}

			last = key;
		});
	}

	editor.on( 'SaveContent', function( e ) {
		// If editor is hidden, we just want the textarea's value to be saved
		if ( ! editor.inline && editor.isHidden() ) {
			e.content = e.element.value;
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
			return;
		}

		// Keep empty paragraphs :(
<<<<<<< HEAD
		event.content = event.content.replace( /<p>(?:<br ?\/?>|\u00a0|\uFEFF| )*<\/p>/g, '<p>&nbsp;</p>' );

		if ( hasWpautop ) {
			event.content = wp.editor.removep( event.content );
		}
	});

	editor.on( 'preInit', function() {
		var validElementsSetting = '@[id|accesskey|class|dir|lang|style|tabindex|' +
			'title|contenteditable|draggable|dropzone|hidden|spellcheck|translate],' + // Global attributes.
			'i,' + // Don't replace <i> with <em> and <b> with <strong> and don't remove them when empty.
			'b,' +
			'script[src|async|defer|type|charset|crossorigin|integrity]'; // Add support for <script>.

		editor.schema.addValidElements( validElementsSetting );
=======
		e.content = e.content.replace( /<p>(?:<br ?\/?>|\u00a0|\uFEFF| )*<\/p>/g, '<p>&nbsp;</p>' );

		if ( editor.getParam( 'wpautop', true ) && typeof window.switchEditors !== 'undefined' ) {
			e.content = window.switchEditors.pre_wpautop( e.content );
		}
	});

	// Remove spaces from empty paragraphs.
	editor.on( 'BeforeSetContent', function( event ) {
		var paragraph = tinymce.Env.webkit ? '<p><br /></p>' : '<p></p>';

		if ( event.content ) {
			event.content = event.content.replace( /<p>(?:&nbsp;|\u00a0|\uFEFF|\s)+<\/p>/gi, paragraph );
		}
	});

	editor.on( 'preInit', function() {
		// Don't replace <i> with <em> and <b> with <strong> and don't remove them when empty
		editor.schema.addValidElements( '@[id|accesskey|class|dir|lang|style|tabindex|title|contenteditable|draggable|dropzone|hidden|spellcheck|translate],i,b' );
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28

		if ( tinymce.Env.iOS ) {
			editor.settings.height = 300;
		}

		each( {
			c: 'JustifyCenter',
			r: 'JustifyRight',
			l: 'JustifyLeft',
			j: 'JustifyFull',
			q: 'mceBlockQuote',
			u: 'InsertUnorderedList',
			o: 'InsertOrderedList',
			s: 'unlink',
			m: 'WP_Medialib',
			z: 'WP_Adv',
			t: 'WP_More',
			d: 'Strikethrough',
			h: 'WP_Help',
			p: 'WP_Page',
			x: 'WP_Code'
		}, function( command, key ) {
			editor.shortcuts.add( 'access+' + key, '', command );
		} );

		editor.addShortcut( 'meta+s', '', function() {
<<<<<<< HEAD
			if ( wp && wp.autosave ) {
=======
			if ( typeof wp !== 'undefined' && wp.autosave ) {
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
				wp.autosave.server.triggerSave();
			}
		} );
	} );

	/**
	 * Experimental: create a floating toolbar.
	 * This functionality will change in the next releases. Not recommended for use by plugins.
	 */
<<<<<<< HEAD
	editor.on( 'preinit', function() {
		var Factory = tinymce.ui.Factory,
			settings = editor.settings,
			activeToolbar,
			currentSelection,
			timeout,
			container = editor.getContainer(),
			wpAdminbar = document.getElementById( 'wpadminbar' ),
			mceIframe = document.getElementById( editor.id + '_ifr' ),
			mceToolbar,
			mceStatusbar,
			wpStatusbar;

			if ( container ) {
				mceToolbar = tinymce.$( '.mce-toolbar-grp', container )[0];
				mceStatusbar = tinymce.$( '.mce-statusbar', container )[0];
			}

			if ( editor.id === 'content' ) {
				wpStatusbar = document.getElementById( 'post-status-info' );
			}

		function create( buttons, bottom ) {
=======
	( function() {
		var Factory = tinymce.ui.Factory,
			settings = editor.settings,
			currentToolbar,
			currentSelection;

		function create( buttons ) {
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
			var toolbar,
				toolbarItems = [],
				buttonGroup;

			each( buttons, function( item ) {
				var itemName;

				function bindSelectorChanged() {
					var selection = editor.selection;

					if ( itemName === 'bullist' ) {
						selection.selectorChanged( 'ul > li', function( state, args ) {
							var i = args.parents.length,
								nodeName;

							while ( i-- ) {
								nodeName = args.parents[ i ].nodeName;

								if ( nodeName === 'OL' || nodeName == 'UL' ) {
									break;
								}
							}

							item.active( state && nodeName === 'UL' );
						} );
					}

					if ( itemName === 'numlist' ) {
						selection.selectorChanged( 'ol > li', function( state, args ) {
							var i = args.parents.length,
								nodeName;

							while ( i-- ) {
								nodeName = args.parents[ i ].nodeName;

								if ( nodeName === 'OL' || nodeName === 'UL' ) {
									break;
								}
							}

							item.active( state && nodeName === 'OL' );
						} );
					}

					if ( item.settings.stateSelector ) {
						selection.selectorChanged( item.settings.stateSelector, function( state ) {
							item.active( state );
						}, true );
					}

					if ( item.settings.disabledStateSelector ) {
						selection.selectorChanged( item.settings.disabledStateSelector, function( state ) {
							item.disabled( state );
						} );
					}
				}

				if ( item === '|' ) {
					buttonGroup = null;
				} else {
					if ( Factory.has( item ) ) {
						item = {
							type: item
						};

						if ( settings.toolbar_items_size ) {
							item.size = settings.toolbar_items_size;
						}

						toolbarItems.push( item );

						buttonGroup = null;
					} else {
						if ( ! buttonGroup ) {
							buttonGroup = {
								type: 'buttongroup',
								items: []
							};

							toolbarItems.push( buttonGroup );
						}

						if ( editor.buttons[ item ] ) {
							itemName = item;
							item = editor.buttons[ itemName ];

							if ( typeof item === 'function' ) {
								item = item();
							}

							item.type = item.type || 'button';

							if ( settings.toolbar_items_size ) {
								item.size = settings.toolbar_items_size;
							}

							item = Factory.create( item );

							buttonGroup.items.push( item );

							if ( editor.initialized ) {
								bindSelectorChanged();
							} else {
								editor.on( 'init', bindSelectorChanged );
							}
						}
					}
				}
			} );

			toolbar = Factory.create( {
				type: 'panel',
				layout: 'stack',
				classes: 'toolbar-grp inline-toolbar-grp',
				ariaRoot: true,
				ariaRemember: true,
				items: [ {
					type: 'toolbar',
					layout: 'flow',
					items: toolbarItems
				} ]
			} );

<<<<<<< HEAD
			toolbar.bottom = bottom;

			function reposition() {
				if ( ! currentSelection ) {
					return this;
				}

				var scrollX = window.pageXOffset || document.documentElement.scrollLeft,
					scrollY = window.pageYOffset || document.documentElement.scrollTop,
					windowWidth = window.innerWidth,
					windowHeight = window.innerHeight,
					iframeRect = mceIframe ? mceIframe.getBoundingClientRect() : {
						top: 0,
						right: windowWidth,
						bottom: windowHeight,
						left: 0,
						width: windowWidth,
						height: windowHeight
					},
					toolbar = this.getEl(),
					toolbarWidth = toolbar.offsetWidth,
					toolbarHeight = toolbar.offsetHeight,
					selection = currentSelection.getBoundingClientRect(),
					selectionMiddle = ( selection.left + selection.right ) / 2,
					buffer = 5,
					margin = 8,
					spaceNeeded = toolbarHeight + margin + buffer,
					wpAdminbarBottom = wpAdminbar ? wpAdminbar.getBoundingClientRect().bottom : 0,
					mceToolbarBottom = mceToolbar ? mceToolbar.getBoundingClientRect().bottom : 0,
					mceStatusbarTop = mceStatusbar ? windowHeight - mceStatusbar.getBoundingClientRect().top : 0,
					wpStatusbarTop = wpStatusbar ? windowHeight - wpStatusbar.getBoundingClientRect().top : 0,
					blockedTop = Math.max( 0, wpAdminbarBottom, mceToolbarBottom, iframeRect.top ),
					blockedBottom = Math.max( 0, mceStatusbarTop, wpStatusbarTop, windowHeight - iframeRect.bottom ),
					spaceTop = selection.top + iframeRect.top - blockedTop,
					spaceBottom = windowHeight - iframeRect.top - selection.bottom - blockedBottom,
					editorHeight = windowHeight - blockedTop - blockedBottom,
					className = '',
					top, left;

				if ( spaceTop >= editorHeight || spaceBottom >= editorHeight ) {
					return this.hide();
				}

				if ( this.bottom ) {
					if ( spaceBottom >= spaceNeeded ) {
						className = ' mce-arrow-up';
						top = selection.bottom + iframeRect.top + scrollY;
					} else if ( spaceTop >= spaceNeeded ) {
						className = ' mce-arrow-down';
						top = selection.top + iframeRect.top + scrollY - toolbarHeight - margin;
					}
				} else {
					if ( spaceTop >= spaceNeeded ) {
						className = ' mce-arrow-down';
						top = selection.top + iframeRect.top + scrollY - toolbarHeight - margin;
					} else if ( spaceBottom >= spaceNeeded && editorHeight / 2 > selection.bottom + iframeRect.top - blockedTop ) {
						className = ' mce-arrow-up';
						top = selection.bottom + iframeRect.top + scrollY;
					}
				}

				if ( typeof top === 'undefined' ) {
					top = scrollY + blockedTop + buffer;
				}

				left = selectionMiddle - toolbarWidth / 2 + iframeRect.left + scrollX;

				if ( selection.left < 0 || selection.right > iframeRect.width ) {
					left = iframeRect.left + scrollX + ( iframeRect.width - toolbarWidth ) / 2;
				} else if ( toolbarWidth >= windowWidth ) {
					className += ' mce-arrow-full';
					left = 0;
				} else if ( ( left < 0 && selection.left + toolbarWidth > windowWidth ) || ( left + toolbarWidth > windowWidth && selection.right - toolbarWidth < 0 ) ) {
					left = ( windowWidth - toolbarWidth ) / 2;
				} else if ( left < iframeRect.left + scrollX ) {
					className += ' mce-arrow-left';
					left = selection.left + iframeRect.left + scrollX;
				} else if ( left + toolbarWidth > iframeRect.width + iframeRect.left + scrollX ) {
					className += ' mce-arrow-right';
					left = selection.right - toolbarWidth + iframeRect.left + scrollX;
				}

				toolbar.className = toolbar.className.replace( / ?mce-arrow-[\w]+/g, '' ) + className;

				DOM.setStyles( toolbar, {
					'left': left,
					'top': top
				} );
=======
			function hide() {
				toolbar.hide();
			}

			function reposition() {
				var top, left, minTop, className,
					windowPos, adminbar, mceToolbar, boundary,
					boundaryMiddle, boundaryVerticalMiddle, spaceTop,
					spaceBottom, windowWidth, toolbarWidth, toolbarHalf,
					iframe, iframePos, iframeWidth, iframeHeigth,
					toolbarNodeHeight, verticalSpaceNeeded,
					toolbarNode = this.getEl(),
					buffer = 5,
					margin = 8,
					adminbarHeight = 0;

				if ( ! currentSelection ) {
					return;
				}

				windowPos = window.pageYOffset || document.documentElement.scrollTop;
				adminbar = tinymce.$( '#wpadminbar' )[0];
				mceToolbar = tinymce.$( '.mce-toolbar-grp', editor.getContainer() )[0];
				boundary = currentSelection.getBoundingClientRect();
				boundaryMiddle = ( boundary.left + boundary.right ) / 2;
				boundaryVerticalMiddle = ( boundary.top + boundary.bottom ) / 2;
				spaceTop = boundary.top;
				spaceBottom = iframeHeigth - boundary.bottom;
				windowWidth = window.innerWidth;
				toolbarWidth = toolbarNode.offsetWidth;
				toolbarHalf = toolbarWidth / 2;
				iframe = document.getElementById( editor.id + '_ifr' );
				iframePos = DOM.getPos( iframe );
				iframeWidth = iframe.offsetWidth;
				iframeHeigth = iframe.offsetHeight;
				toolbarNodeHeight = toolbarNode.offsetHeight;
				verticalSpaceNeeded = toolbarNodeHeight + margin + buffer;

				if ( spaceTop >= verticalSpaceNeeded ) {
					className = ' mce-arrow-down';
					top = boundary.top + iframePos.y - toolbarNodeHeight - margin;
				} else if ( spaceBottom >= verticalSpaceNeeded ) {
					className = ' mce-arrow-up';
					top = boundary.bottom + iframePos.y;
				} else {
					top = buffer;

					if ( boundaryVerticalMiddle >= verticalSpaceNeeded ) {
						className = ' mce-arrow-down';
					} else {
						className = ' mce-arrow-up';
					}
				}

				// Make sure the image toolbar is below the main toolbar.
				if ( mceToolbar ) {
					minTop = DOM.getPos( mceToolbar ).y + mceToolbar.clientHeight;
				} else {
					minTop = iframePos.y;
				}

				// Make sure the image toolbar is below the adminbar (if visible) or below the top of the window.
				if ( windowPos ) {
					if ( adminbar && adminbar.getBoundingClientRect().top === 0 ) {
						adminbarHeight = adminbar.clientHeight;
					}

					if ( windowPos + adminbarHeight > minTop ) {
						minTop = windowPos + adminbarHeight;
					}
				}

				if ( top && minTop && ( minTop + buffer > top ) ) {
					top = minTop + buffer;
					className = '';
				}

				left = boundaryMiddle - toolbarHalf;
				left += iframePos.x;

				if ( boundary.left < 0 || boundary.right > iframeWidth ) {
					left = iframePos.x + ( iframeWidth - toolbarWidth ) / 2;
				} else if ( toolbarWidth >= windowWidth ) {
					className += ' mce-arrow-full';
					left = 0;
				} else if ( ( left < 0 && boundary.left + toolbarWidth > windowWidth ) ||
					( left + toolbarWidth > windowWidth && boundary.right - toolbarWidth < 0 ) ) {

					left = ( windowWidth - toolbarWidth ) / 2;
				} else if ( left < iframePos.x ) {
					className += ' mce-arrow-left';
					left = boundary.left + iframePos.x;
				} else if ( left + toolbarWidth > iframeWidth + iframePos.x ) {
					className += ' mce-arrow-right';
					left = boundary.right - toolbarWidth + iframePos.x;
				}

				toolbarNode.className = toolbarNode.className.replace( / ?mce-arrow-[\w]+/g, '' );
				toolbarNode.className += className;

				DOM.setStyles( toolbarNode, { 'left': left, 'top': top } );
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28

				return this;
			}

			toolbar.on( 'show', function() {
<<<<<<< HEAD
				this.reposition();
			} );

=======
				currentToolbar = this;
				this.reposition();
			} );

			toolbar.on( 'hide', function() {
				currentToolbar = false;
			} );

>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
			toolbar.on( 'keydown', function( event ) {
				if ( event.keyCode === 27 ) {
					this.hide();
					editor.focus();
				}
			} );

<<<<<<< HEAD
			editor.on( 'remove', function() {
				toolbar.remove();
=======
			toolbar.on( 'remove', function() {
				DOM.unbind( window, 'resize scroll', hide );
				editor.dom.unbind( editor.getWin(), 'resize scroll', hide );
				editor.off( 'blur hide', hide );
			} );

			editor.once( 'init', function() {
				DOM.bind( window, 'resize scroll', hide );
				editor.dom.bind( editor.getWin(), 'resize scroll', hide );
				editor.on( 'blur hide', hide );
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
			} );

			toolbar.reposition = reposition;
			toolbar.hide().renderTo( document.body );

			return toolbar;
		}

		editor.shortcuts.add( 'alt+119', '', function() {
			var node;

<<<<<<< HEAD
			if ( activeToolbar ) {
				node = activeToolbar.find( 'toolbar' )[0];
=======
			if ( currentToolbar ) {
				node = currentToolbar.find( 'toolbar' )[0];
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
				node && node.focus( true );
			}
		} );

		editor.on( 'nodechange', function( event ) {
			var collapsed = editor.selection.isCollapsed();

			var args = {
				element: event.element,
				parents: event.parents,
				collapsed: collapsed
			};

			editor.fire( 'wptoolbar', args );

			currentSelection = args.selection || args.element;

<<<<<<< HEAD
			if ( activeToolbar ) {
				activeToolbar.hide();
			}

			if ( args.toolbar ) {
				activeToolbar = args.toolbar;
				activeToolbar.show();
			} else {
				activeToolbar = false;
			}
		} );

		editor.on( 'focus', function() {
			if ( activeToolbar ) {
				activeToolbar.show();
			}
		} );

		function hide( event ) {
			if ( activeToolbar ) {
				activeToolbar.hide();

				if ( event.type === 'hide' ) {
					activeToolbar = false;
				} else if ( event.type === 'resize' || event.type === 'scroll' ) {
					clearTimeout( timeout );

					timeout = setTimeout( function() {
						if ( activeToolbar && typeof activeToolbar.show === 'function' ) {
							activeToolbar.show();
						}
					}, 250 );
				}
			}
		}

		DOM.bind( window, 'resize scroll', hide );
		editor.dom.bind( editor.getWin(), 'resize scroll', hide );

		editor.on( 'remove', function() {
			DOM.unbind( window, 'resize scroll', hide );
			editor.dom.unbind( editor.getWin(), 'resize scroll', hide );
		} );

		editor.on( 'blur hide', hide );

		editor.wp = editor.wp || {};
		editor.wp._createToolbar = create;
	}, true );
=======
			currentToolbar && currentToolbar.hide();
			args.toolbar && args.toolbar.show();
		} );

		editor.wp = editor.wp || {};
		editor.wp._createToolbar = create;
	}());
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28

	function noop() {}

	// Expose some functions (back-compat)
	return {
		_showButtons: noop,
		_hideButtons: noop,
		_setEmbed: noop,
		_getEmbed: noop
	};
});
<<<<<<< HEAD

}( window.tinymce ));
=======
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
