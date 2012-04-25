var RTOOLBAR = {
	html: { name: 'html', title: RLANG.html, func: 'toggle' },	
	styles: 
	{
		name: 'styles', title: RLANG.styles, func: 'show', 
		dropdown: 
		{
			p: 			{exec: 'formatblock', name: '<p>', title: RLANG.paragraph},
			blockquote: {exec: 'formatblock', name: '<blockquote>', title: RLANG.quote},
			code: 		{exec: 'formatblock', name: '<pre>', title: RLANG.code},
			h2: 		{exec: 'formatblock', name: '<h2>', title: RLANG.header1, style: 'font-size: 18px;'},
			h3: 		{exec: 'formatblock', name: '<h3>', title: RLANG.header2, style: 'font-size: 14px; font-weight: bold;'}																	
		}
	},
	format: 
	{
		name: 'format', title: RLANG.format, func: 'show',
		dropdown: 
		{
			bold: 		  {exec: 'bold', name: 'bold', title: RLANG.bold, style: 'font-weight: bold;'},
			italic: 	  {exec: 'italic', name: 'italic', title: RLANG.italic, style: 'font-style: italic;'},
			superscript:  {exec: 'superscript', name: 'superscript', title: RLANG.superscript},
			strikethrough:  {exec: 'StrikeThrough', name: 'StrikeThrough', title: RLANG.strikethrough, style: 'text-decoration: line-through !important;'},
			removeformat: {exec: 'removeformat', name: 'removeformat', title: RLANG.removeformat}
		}						
	},
	lists: 	
	{
		name: 'lists', title: RLANG.lists, func: 'show',
		dropdown: 
		{
			ul: 	 {exec: 'insertunorderedlist', name: 'insertunorderedlist', title: '&bull; ' + RLANG.unorderedlist},
			ol: 	 {exec: 'insertorderedlist', name: 'insertorderedlist', title: '1. ' + RLANG.orderedlist},
			outdent: {exec: 'outdent', name: 'outdent', title: '< ' + RLANG.outdent},
			indent:  {exec: 'indent', name: 'indent', title: '> ' + RLANG.indent}
		}			
	},				
	image: { name: 'image', title: RLANG.image, func: 'showImage' },
	table:
	{ 
		name: 'table', title: RLANG.table, func: 'show',
		dropdown: 
		{
			insert_table: { name: 'insert_table', title: RLANG.insert_table, func: 'showTable' },
			separator_drop1: { name: 'separator' },	
			insert_row_above: { name: 'insert_row_above', title: RLANG.insert_row_above, func: 'insertRowAbove' },
			insert_row_below: { name: 'insert_row_below', title: RLANG.insert_row_below, func: 'insertRowBelow' },
			insert_column_left: { name: 'insert_column_left', title: RLANG.insert_column_left, func: 'insertColumnLeft' },
			insert_column_right: { name: 'insert_column_right', title: RLANG.insert_column_right, func: 'insertColumnRight' },												
			separator_drop2: { name: 'separator' },	
			add_head: { name: 'add_head', title: RLANG.add_head, func: 'addHead' },									
			delete_head: { name: 'delete_head', title: RLANG.delete_head, func: 'deleteHead' },							
			separator_drop3: { name: 'separator' },				
			delete_column: { name: 'insert_table', title: RLANG.delete_column, func: 'deleteColumn' },									
			delete_row: { name: 'delete_row', title: RLANG.delete_row, func: 'deleteRow' },									
			delete_table: { name: 'delete_table', title: RLANG.delete_table, func: 'deleteTable' }																		
		}		
	},
	video: { name: 'video', title: RLANG.video, func: 'showVideo' },
	file: { name: 'file', title: RLANG.file, func: 'showFile' },	
	link: 
	{
		name: 'link', title: RLANG.link, func: 'show',
		dropdown: 
		{
			link: 	{name: 'link', title: RLANG.link_insert, func: 'showLink'},
			unlink: {exec: 'unlink', name: 'unlink', title: RLANG.unlink}
		}			
	}
};