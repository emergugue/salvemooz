<<<<<<< HEAD
( function() {
	function WordCounter( settings ) {
		var key,
			shortcodes;

		if ( settings ) {
			for ( key in settings ) {
				if ( settings.hasOwnProperty( key ) ) {
					this.settings[ key ] = settings[ key ];
				}
			}
		}

		shortcodes = this.settings.l10n.shortcodes;

		if ( shortcodes && shortcodes.length ) {
			this.settings.shortcodesRegExp = new RegExp( '\\[\\/?(?:' + shortcodes.join( '|' ) + ')[^\\]]*?\\]', 'g' );
		}
	}

	WordCounter.prototype.settings = {
		HTMLRegExp: /<\/?[a-z][^>]*?>/gi,
		HTMLcommentRegExp: /<!--[\s\S]*?-->/g,
		spaceRegExp: /&nbsp;|&#160;/gi,
		HTMLEntityRegExp: /&\S+?;/g,
		connectorRegExp: /--|\u2014/g,
		removeRegExp: new RegExp( [
			'[',
				// Basic Latin (extract)
				'\u0021-\u0040\u005B-\u0060\u007B-\u007E',
				// Latin-1 Supplement (extract)
				'\u0080-\u00BF\u00D7\u00F7',
				// General Punctuation
				// Superscripts and Subscripts
				// Currency Symbols
				// Combining Diacritical Marks for Symbols
				// Letterlike Symbols
				// Number Forms
				// Arrows
				// Mathematical Operators
				// Miscellaneous Technical
				// Control Pictures
				// Optical Character Recognition
				// Enclosed Alphanumerics
				// Box Drawing
				// Block Elements
				// Geometric Shapes
				// Miscellaneous Symbols
				// Dingbats
				// Miscellaneous Mathematical Symbols-A
				// Supplemental Arrows-A
				// Braille Patterns
				// Supplemental Arrows-B
				// Miscellaneous Mathematical Symbols-B
				// Supplemental Mathematical Operators
				// Miscellaneous Symbols and Arrows
				'\u2000-\u2BFF',
				// Supplemental Punctuation
				'\u2E00-\u2E7F',
			']'
		].join( '' ), 'g' ),
		astralRegExp: /[\uD800-\uDBFF][\uDC00-\uDFFF]/g,
		wordsRegExp: /\S\s+/g,
		characters_excluding_spacesRegExp: /\S/g,
		characters_including_spacesRegExp: /[^\f\n\r\t\v\u00AD\u2028\u2029]/g,
		l10n: window.wordCountL10n || {}
	};

	WordCounter.prototype.count = function( text, type ) {
		var count = 0;

		type = type || this.settings.l10n.type;

		if ( type !== 'characters_excluding_spaces' && type !== 'characters_including_spaces' ) {
			type = 'words';
		}

		if ( text ) {
			text = text + '\n';

			text = text.replace( this.settings.HTMLRegExp, '\n' );
			text = text.replace( this.settings.HTMLcommentRegExp, '' );

			if ( this.settings.shortcodesRegExp ) {
				text = text.replace( this.settings.shortcodesRegExp, '\n' );
			}

			text = text.replace( this.settings.spaceRegExp, ' ' );

			if ( type === 'words' ) {
				text = text.replace( this.settings.HTMLEntityRegExp, '' );
				text = text.replace( this.settings.connectorRegExp, ' ' );
				text = text.replace( this.settings.removeRegExp, '' );
			} else {
				text = text.replace( this.settings.HTMLEntityRegExp, 'a' );
				text = text.replace( this.settings.astralRegExp, 'a' );
			}

			text = text.match( this.settings[ type + 'RegExp' ] );

			if ( text ) {
				count = text.length;
			}
		}

		return count;
	};

	window.wp = window.wp || {};
	window.wp.utils = window.wp.utils || {};
	window.wp.utils.WordCounter = WordCounter;
} )();
=======
/* global wordCountL10n */
var wpWordCount;
(function($,undefined) {
	wpWordCount = {

		settings : {
			strip : /<[a-zA-Z\/][^<>]*>/g, // strip HTML tags
			clean : /[0-9.(),;:!?%#$¿'"_+=\\/-]+/g, // regexp to remove punctuation, etc.
			w : /\S\s+/g, // word-counting regexp
			c : /\S/g // char-counting regexp for asian languages
		},

		block : 0,

		wc : function(tx, type) {
			var t = this, w = $('.word-count'), tc = 0;

			if ( type === undefined )
				type = wordCountL10n.type;
			if ( type !== 'w' && type !== 'c' )
				type = 'w';

			if ( t.block )
				return;

			t.block = 1;

			setTimeout( function() {
				if ( tx ) {
					tx = tx.replace( t.settings.strip, ' ' ).replace( /&nbsp;|&#160;/gi, ' ' );
					tx = tx.replace( t.settings.clean, '' );
					tx.replace( t.settings[type], function(){tc++;} );
				}
				w.html(tc.toString());

				setTimeout( function() { t.block = 0; }, 2000 );
			}, 1 );
		}
	};

	$(document).bind( 'wpcountwords', function(e, txt) {
		wpWordCount.wc(txt);
	});
}(jQuery));
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
