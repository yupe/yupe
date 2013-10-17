jQuery(function($){
	var settings = {
		onShiftEnter:{keepDefault:false, openWith:'\n\n'},
		markupSet: [
			{
				name: 'Headers',
				className: 'hs',
				dropMenu: [
					{
						className:'h1',
						name:'Heading 1',
						key:'1',
						placeHolder:'Your title here...',
						closeWith:function(markItUp){
							return markdownTitle(markItUp, '=');
						}
					},
					{
						className:'h2',
						name:'Heading 2', key:'2', placeHolder:'Your title here...', closeWith:function (markItUp){
							return markdownTitle(markItUp, '-');
						}
					},
					{
						className: 'h3',
						name:'Heading 3',
						key:'3',
						openWith:'### ',
						placeHolder:'Your title here...'
					},
					{
						className: 'h4',
						name:'Heading 4',
						key:'4',
						openWith:'#### ',
						placeHolder:'Your title here...'
					},
					{
						className: 'h5',
						name:'Heading 5',
						key:'5',
						openWith:'##### ',
						placeHolder:'Your title here...'
					},
					{
						className: 'h6',
						name:'Heading 6',
						key:'6',
						openWith:'###### ',
						placeHolder:'Your title here...'
					}
				]
			},

			{separator:'---------------' },
			{className: 'bold', name:'Bold', key:'B', openWith:'**', closeWith:'**'},
			{className: 'italic', name:'Italic', key:'I', openWith:'_', closeWith:'_'},
			{separator:'---------------' },
			{className: 'ul', name:'Unordered List', openWith:'- ' },
			{className: 'ol', name:'Ordered List', openWith:function(markItUp){
					return markItUp.line+'. ';
				}
			},
			{separator:'---------------' },
			{className: 'img', name:'Picture', key:'P', replaceWith:'![[![Alternative text]!]]([![Url:!:http://]!] "[![Title]!]")'},
			{className: 'link', name:'WikiLink', key:'W', openWith:'[[', closeWith:']]', placeHolder:'Your text to link here...' },
			{className: 'a', name:'Link', key:'L', openWith:'[', closeWith:']([![Url:!:http://]!] "[![Title]!]")', placeHolder:'Your text to link here...' },
			{separator:'---------------'},
			{className: 'quote', name:'Quotes', openWith:'> '},
			{className: 'code', name:'Code Block / Code (ALT)', openWith:'(!(~~~\n|!|`)!)', closeWith:'(!(\n~~~|!|`)!)'}
		]
	}


	function markdownTitle(markItUp, char){
		var heading = '';
		var n = $.trim(markItUp.selection || markItUp.placeHolder).length;
		for(var i = 0; i < n; i++){
			heading += char;
		}
		return '\n'+heading;
	}

	$('#edit-page-form textarea').markItUp(settings);
});