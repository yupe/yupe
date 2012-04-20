var RTOOLBAR = {	
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
	separator9: { name: 'separator' },				
	bold: 	{exec: 'Bold', name: 'bold', title: RLANG.bold},				
	italic: 	{exec: 'italic', name: 'italic', title: RLANG.italic},				
	separator3: { name: 'separator' },			
	ul: 	 {exec: 'insertunorderedlist', name: 'unorderlist', title: '&bull; ' + RLANG.unorderedlist},
	ol: 	 {exec: 'insertorderedlist', name: 'orderlist', title: '1. ' + RLANG.orderedlist},
	outdent: {exec: 'outdent', name: 'outdent', title: '< ' + RLANG.outdent},
	indent:  {exec: 'indent', name: 'indent', title: '> ' + RLANG.indent},
	separator5: { name: 'separator' },			
	image: { name: 'image', title: RLANG.image, func: 'showImage' },
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