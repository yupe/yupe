var RTOOLBAR = {	
	styles: 
	{
		name: 'styles', title: RLANG.styles, func: 'show', 
		dropdown: 
		{
			p: 			{exec: 'formatblock', name: '<p>', title: RLANG.paragraph},
			blockquote: {exec: 'formatblock', name: '<blockquote>', title: RLANG.quote},
			pre: 		{exec: 'formatblock', name: '<pre>', title: RLANG.code},
			h2: 		{exec: 'formatblock', name: '<h2>', title: RLANG.header1, style: 'font-size: 18px;'},
			h3: 		{exec: 'formatblock', name: '<h3>', title: RLANG.header2, style: 'font-size: 14px; font-weight: bold;'}																	
		},
		separator: true
	},		
	bold: 	{exec: 'Bold', name: 'bold', title: RLANG.bold},				
	italic: 	{exec: 'italic', name: 'italic', title: RLANG.italic, separato: true},					
	insertunorderedlist:
	{
		title: '&bull; ' + RLANG.unorderedlist,
		exec: 'insertunorderedlist',
	 	param: null
	},
	insertorderedlist:
	{
		title: '1. ' + RLANG.orderedlist,
		exec: 'insertorderedlist',	
	 	param: null
	},
	outdent:
	{
		title: '< ' + RLANG.outdent,
		exec: 'outdent',
	 	param: null		
	},
	indent:
	{
		title: '> ' + RLANG.indent,
		exec: 'indent',
	 	param: null,
		separator: true	 			 			
	},		
	link: 
	{
		name: 'link', title: RLANG.link, func: 'show',
		dropdown: 
		{
			link: 	{name: 'link', title: RLANG.link_insert, func: 'showLink'},
			unlink: {exec: 'unlink', name: 'unlink', title: RLANG.unlink}
		}			
	},
	fullscreen:
	{
		title: RLANG.fullscreen,
		func: 'fullscreen'
	}	
};