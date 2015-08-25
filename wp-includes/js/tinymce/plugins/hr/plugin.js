/**
 * plugin.js
 *
<<<<<<< HEAD
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
=======
 * Copyright, Moxiecode Systems AB
 * Released under LGPL License.
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/*global tinymce:true */

tinymce.PluginManager.add('hr', function(editor) {
	editor.addCommand('InsertHorizontalRule', function() {
		editor.execCommand('mceInsertContent', false, '<hr />');
	});

	editor.addButton('hr', {
		icon: 'hr',
		tooltip: 'Horizontal line',
		cmd: 'InsertHorizontalRule'
	});

	editor.addMenuItem('hr', {
		icon: 'hr',
		text: 'Horizontal line',
		cmd: 'InsertHorizontalRule',
		context: 'insert'
	});
});
