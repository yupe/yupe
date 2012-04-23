/*
	Redactor v7.5.3
	Updated 09.04.2012
	
	In English http://imperavi.com/
	In Russian http://imperavi.ru/	
 
	Copyright (c) 2009-2012, Imperavi Ltd.
	Dual licensed under the MIT or GPL Version 2 licenses.
	
	Usage: $('#content').redactor();	
*/

var redactorActive = false;
var $table, $table_tr, $table_td, $tbody, $thead, $current_tr, $current_td;

(function($){

	// Initialization	
	$.fn.redactor = function(options)
	{				
		var obj = new Construct(this, options);			
		obj.init();		
		return obj;
	};

	// Options and variables	
	function Construct(el, options) 
	{
		this.opts = $.extend({	
			lang: 'ru', // ru, en, fr, ua, pt_br, pl, lt
			air: false,
			toolbar: 'main', // false, main, mini, air
			path: false,
			focus: true,			
			resize: true,
			handler: false, // false or url
			autoclear: true,
			autoformat: true,
			
			removeClasses: true,
			removeStyles: false,
			
			convertLinks: true,										
			autosave: false, // false or url
			interval: 20, // seconds
						
			imageUpload: '/tests/upload.php', // url or false
			imageGetJson: false, // url (ex. /folder/images.json ) or false
			imageUploadFunction: false, // callback function
			
			fileUpload: '/tests/file_upload.php',	
			fileDownload: '/tests/file_download.php?file=',		
			fileDelete: '/tests/file_delete.php?delete=',		
			fileUploadFunction: false, // callback function
						
			
			css: 'blank.css',	
			
			visual: true,
			fullscreen: false,
			overlay: true, // modal overlay			
			
			colors: Array(
				'#ffffff', '#000000', '#eeece1', '#1f497d', '#4f81bd', '#c0504d', '#9bbb59', '#8064a2', '#4bacc6', '#f79646', '#ffff00',
				'#f2f2f2', '#7f7f7f', '#ddd9c3', '#c6d9f0', '#dbe5f1', '#f2dcdb', '#ebf1dd', '#e5e0ec', '#dbeef3', '#fdeada', '#fff2ca',
				'#d8d8d8', '#595959', '#c4bd97', '#8db3e2', '#b8cce4', '#e5b9b7', '#d7e3bc', '#ccc1d9', '#b7dde8', '#fbd5b5', '#ffe694',
				'#bfbfbf', '#3f3f3f', '#938953', '#548dd4', '#95b3d7', '#d99694', '#c3d69b', '#b2a2c7', '#b7dde8', '#fac08f', '#f2c314',
				'#a5a5a5', '#262626', '#494429', '#17365d', '#366092', '#953734', '#76923c', '#5f497a', '#92cddc', '#e36c09', '#c09100',
				'#7f7f7f', '#0c0c0c', '#1d1b10', '#0f243e', '#244061', '#632423', '#4f6128', '#3f3151', '#31859b', '#974806', '#7f6000')
			
		}, options);
		
		this.$el = $(el);
	};

	// Functionality
	Construct.prototype = {

	
		// DYNAMICALLY LOAD
		_loadFile: function(file, array)
		{
			var item = array[0];
			array.splice(0, 1);	

			if (typeof(item) == 'function') var callback = item;
			else 
			{			
				var callback = function()
				{
					this._loadFile(item, array);					
					
				}.bind2(this);
			}
		
			this.dynamicallyLoad(file, callback);
		},
		loadFiles: function(array)
		{
			var item = array[0];
			array.splice(0, 1);
			
			this._loadFile(item, array);
		},
		dynamicallyLoad: function (url, callback)
		{
			var head = document.getElementsByTagName("head")[0];
			var script = document.createElement("script");
			script.src = url;
		
			// Handle Script loading
			var done = false;
		
			// Attach handlers for all browsers
			script.onload = script.onreadystatechange = function(){
				if (!done && (!this.readyState || this.readyState == "loaded" || this.readyState == "complete")) {
				   done = true;
				   if (callback){
				      callback();
				   }
				   // Handle memory leak in IE
				   script.onload = script.onreadystatechange = null;
				}
			};
			head.appendChild(script);
		
			// We handle everything using the script element injection
			return undefined;
		},
		
		// INITIALIZATION
		init: function()
		{
			// get path to langs, plugins and toolbars
			if (this.opts.path === false)
			{
				$('script').each(function(i,s) 
				{ 
					if (s.src) 
					{
						if (s.src.match(/\/redactor\.min\.js.*$/)) this.opts.path = s.src.replace(/redactor\.min\.js(\?.*)?$/, ''); 
						else if (s.src.match(/\/redactor\.js.*$/)) this.opts.path = s.src.replace(/redactor\.js(\?.*)?$/, ''); 
					}
				}.bind2(this));
			}
			
			
			// get dimensions
			this.height = this.$el.css('height');
			this.width = this.$el.css('width');

			// get editor ID
			this.editorID = this.$el.attr('id');			
			if (typeof(this.editorID) == 'undefined') this.editorID = this.getRandomID();
			
			// air box
			if (this.opts.air)
			{
				this.opts.toolbar = 'air';
				this.air = $('<div id="imp_redactor_air_' + this.editorID + '" class="redactor_air" style="display: none;"></div>');
			}	
						
			
			// load files	
			var files = [];
			
			files.push(this.opts.path + 'langs/' + this.opts.lang + '.js');

			if (this.opts.toolbar !== false) 
			{
				files.push(this.opts.path + 'toolbars/' + this.opts.toolbar + '.js');
			}

			files.push(function() { this.start(); }.bind2(this));						
				
			this.loadFiles(files);
			
			
			// constract editor
			this.build();
			
			// enable
	   		this.enable(this.$el.val());		   					
					
		},
		
		start: function()
		{
			// build toolbar
			this.buildToolbar();
					
			// resizer
			this.buildResizer();	
			
			// air enable
			this.enableAir();
			
			// clean
			$(this.doc).bind('paste', function(e)
			{ 
				 setTimeout(function () 
				 { 

				 	var node = $('<span id="pastemarkerend">&nbsp;</span>');
				 	this.insertNodeAtCaret(node.get(0));

				 	this.clean(); 				 	
				 	
				 }.bind2(this), 200);
			}.bind2(this));					
		
			// doc events
			$(this.doc).keypress(function(e)
		    {
				var key = e.keyCode || e.which;

				if (navigator.userAgent.indexOf('AppleWebKit') != -1)
				{
					if (e.shiftKey && key == 13)
					{
						if (e.preventDefault) e.preventDefault();
					
						var node1 = $('<span><br /></span>')
						this.insertNodeAtCaret(node1.get(0));
						
						this.setFocusNode(node1.get(0));
						
						return false;
					}
				}

						
		        if (key == 13 && !e.shiftKey && !e.ctrlKey && !e.metaKey)
		        {
		        	if (this.getParentNodeName() == 'BODY')
		        	{
		        		if (e.preventDefault) e.preventDefault();
		        		
			        	var node = $('<p><br /></p>')
			        	this.insertNodeAtCaret(node.get(0));
			        	
			        	return false;
			        }
			        else return true;

		        }	
			
					        	        
		    }.bind2(this));			
			
			$(this.doc).keyup(function(e)
		    {			
				var key = e.keyCode || e.which;
				
				if (key == 8 || key == 46)
				{
					if ($(this.doc.body).html() == '')
					{
						if (e.preventDefault) e.preventDefault();
						
						var node = $('<p><br /></p>').get(0);
						$(this.doc.body).append(node);
						this.setFocusNode(node);
						
						return false;
					}

				}		

				
				if (key == 13 && !e.shiftKey && !e.ctrlKey && !e.metaKey)	
				{	

					if (this.getParentNodeName() == 'BODY')
					{
						if (e.preventDefault) e.preventDefault();
						
						element = $(this.getCurrentNode());
						if (element.get(0).tagName != 'P')
						{
						    newElement = $('<p>').append(element.clone().get(0).childNodes);
						    element.replaceWith(newElement);		
   						    newElement.html('<br />');					    
						    this.setFocusNode(newElement.get(0));
						    
						    return false;				
						 }
						 
						 // convert links
						 if (this.opts.convertLinks) $(this.doc).linkify();
					} 
					else return true;

				}
								        	        
		    }.bind2(this));				

			// shortcuts
			this.shortcuts();			
			
			// autosave
			this.autoSave();		
				

			// focus
			if (this.opts.focus) this.focus();

		},
		shortcuts: function()
		{
			$(this.doc).keydown(function(e)
			{
				var key = e.keyCode || e.which;

				if (e.ctrlKey) 
				{
					// Ctrl + z
					if (key == 90)
					{
						if (e.preventDefault) e.preventDefault();
						this.execCommand('undo', null);
					}		
					// Ctrl + Shift + z	
					else if (key == 90 && e.shiftKey)
					{
						if (e.preventDefault) e.preventDefault();
						this.execCommand('redo', null);
					}					
					// Ctrl + m	
					else if (key == 77)
					{
						if (e.preventDefault) e.preventDefault();
						this.execCommand('removeFormat', null);
					}			
					// Ctrl + b												
					else if (key == 66)
					{
						if (e.preventDefault) e.preventDefault();
						this.execCommand('bold', null);
					}	
					// Ctrl + i				
					else if (key == 73)
					{
						if (e.preventDefault) e.preventDefault();
						this.execCommand('italic', null);
					}	
					// Ctrl + j
					else if (key == 74)
					{
						if (e.preventDefault) e.preventDefault();
						this.execCommand('insertunorderedlist', null);
					}	
					// Ctrl + k				
					else if (key == 75)
					{
						if (e.preventDefault) e.preventDefault();
						this.execCommand('insertorderedlist', null);
					}	
					// Ctrl + l
					else if (key == 76)
					{
						if (e.preventDefault) e.preventDefault();
						this.execCommand('superscript', null); 
					}				
				}

				// Tab
				if (!e.shiftKey && key == 9)
				{
					if (e.preventDefault) e.preventDefault();
					this.execCommand('indent', null);
				}		
				// Shift + tab				
				else if (e.shiftKey && key == 9 )
				{
					if (e.preventDefault) e.preventDefault();
					this.execCommand('outdent', null);
				}
																					

			
			}.bind2(this));
		
		},
		
		focus: function()
		{
			if ($.browser.msie) this.$frame.get(0).contentWindow.focus();
			else this.$frame.focus();
		},			
		build: function()
		{		
			// container
			this.$box = $('<div id="redactor_box_' + this.editorID + '" class="redactor_box"></div>');				

			// frame
			this.$frame = $('<iframe frameborder="0" scrolling="auto" id="redactor_frame_' + this.editorID + '" style="height: ' + this.height + ';" class="redactor_frame"></iframe>');	   	
			
			// hide textarea
			this.$el.hide();
			
			// append box and frame			
			this.$box.insertAfter(this.$el).append(this.$frame).append(this.$el);
			
			// form submit
			this.formSubmit();			
					
		},
		enable: function(html)
		{				
	   		this.doc = this.getDoc(this.$frame);
	   		
	   		if (typeof(html) == 'undefined' || html == '')
	   		{
	   			if (this.opts.autoformat === true) 
	   			{
	   				if ($.browser.msie) html = "<p></p>";
		   			else html = "<p><br /></p>";
		   		}
	   		}
	   		
			this.write(this.setDoc(html));
						
			this.designMode();				
		},
		enableAir: function()
		{
			if (this.opts.air === false) return false;
				
			$('#imp_redactor_air_' + this.editorID).hide();
			
			$(this.doc).bind('textselect', this.editorID, function(e)
			{
				var width = $('#imp_redactor_air_' + this.editorID).width();
				var width_area = this.$frame.width();
				
				var diff = width_area - e.clientX;
				if (diff < width) e.clientX = e.clientX - width;
				
				$('#imp_redactor_air_' + this.editorID).css({ left: e.clientX + 'px', top: (e.clientY + 8) + 'px' }).show();
				
			}.bind2(this));
			
			$(this.doc).bind('textunselect', this.editorID, function()
			{
				$('#imp_redactor_air_' + this.editorID).hide();
				
			}.bind2(this)); 			
					
		},		
		write: function(html)
		{
			if (this.doc != null) 
			{
				this.doc.open();
				this.doc.write(html);
				this.doc.close();		
			}
		},
		setDoc: function(html)
		{		
	    	var frameHtml = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\n';
			frameHtml += '<html><head><link media="all" type="text/css" href="' + this.opts.path + 'css/' + this.opts.css + '" rel="stylesheet"></head>';
			frameHtml += '<body>';
			frameHtml += html;
			frameHtml += '</body></html>';
			return frameHtml;			
		},	
		getDoc: function(frame)
		{	
			frame = frame.get(0);
	
			if (frame.contentDocument) return frame.contentDocument;
			else if (frame.contentWindow && frame.contentWindow.document) return frame.contentWindow.document;
			else if (frame.document) return frame.document;
			else return null;
			
		},
		designMode: function()
		{
			if (this.doc)
			{
				this.doc.designMode = 'on';
				this.$frame.load(function()
				{ 				
					if ($.browser.mozilla) this.enableObjects();
							
	   				this.doc.designMode = 'on'; 
	   				
	   				this.docObserve();	
	   				
	   			}.bind2(this));
			}
		},
		enableObjects: function()
		{
			if ($.browser.mozilla)
			{
				this.doc.execCommand("enableObjectResizing", false, "false");
				this.doc.execCommand("enableInlineTableEditing", false, "false");	   						
			}
		},	
		docObserve: function()
		{
			$(this.doc.body).find('img').click(function(e) { this.imageEdit(e); }.bind2(this));
			$(this.doc.body).find('table').click(function(e) { this.tableObserver(e); }.bind2(this));
			$(this.doc.body).find('.redactor_file_link').click(function(e) { this.fileEdit(e); }.bind2(this));
		},			
		
		// FORM SUBMIT
		formSubmit: function()
		{
          	if (this.opts.visual === false) return false;
	
			var form = this.$box.parents('form');
			if (form.size() == 0) return false;
			
			form.submit(function()
			{
				this.clean(false);
          		this.syncCodeToTextarea();					
				return true;
				
			}.bind2(this));
		
			return true;
		},			
				
		// EXECCOMMAND		
		execCommand: function(cmd, param)
		{		
			if (this.opts.visual && this.doc)
			{
    			try
	    		{
    				this.focus();
										
	    			if (cmd == 'inserthtml' && $.browser.msie) this.doc.selection.createRange().pasteHTML(param);	
	    			else if (cmd == 'formatblock' && $.browser.msie) this.doc.execCommand(cmd, false, '<' +param + '>');	
	    			else if (cmd == 'indent' && $.browser.mozilla) this.doc.execCommand('formatblock', false, 'blockquote');
	    			else   			
					{											
						this.doc.execCommand(cmd, false, param);
					}
				}
				catch (e) { }
				
				this.syncCodeToTextarea();	
				
				if (this.opts.air) $('#imp_redactor_air_' + this.frameID).hide();		

			}
		},			
		
		// CLEAN
		clean: function(marker)
		{
			var html = this.getCodeEditor();
			
			if (marker !== false) html = html.replace(/<span id="pastemarkerend">&nbsp;<\/span>/, '#marker#');			
			
			html = this.formating(html);			
			
			html = html.replace(/(<\!\-\-([\w\W]*?)\-\->)/ig,"");

			html = this._clean(html);

			html = html.replace(/<div(.*?)>/gi, "<p$1>"); 			
			html = html.replace(/<\/div>/, '</p>');
			
			html = html.replace(/ lang="([\w\W]*?)"/gi, '');
			
			if (this.opts.removeClasses) html = html.replace(/ class="([\w\W]*?)"/gi, '');	
			else html = this._cleanClasses(html);
			
			if (this.opts.removeStyles) html = html.replace(/ style="([\w\W]*?)"/gi, '');	
			else html = this._cleanStyles(html);	
									

			html = html.replace(/<a name="(.*?)">([\w\W]*?)<\/a>/gi, '');			

			html = html.replace(/\&nbsp;\&nbsp;\&nbsp;/gi, ' ');			
			html = html.replace(/\&nbsp;\&nbsp;/gi, ' ');			

			html = html.replace( /\s*style="\s*"/gi, '' );

			//html = html.replace(/\n/gi, ' ');	
			html = html.replace(/\<span>&nbsp;<\/span>/gi, '');
			
			html = html.replace(/<span>([\w\W]*?)<\/span>/gi, '$1');				

			html = this._clean(html);
			
			html = this.formating(html);

			if (marker !== false) html = html.replace(/#marker#/, '<span id="pastemarkerend">&nbsp;</span>');

			this.setCodeEditor(html);
			
			if (marker !== false) 
			{
				var node = $(this.doc.body).find('#pastemarkerend').get(0);
				this.setFocusNode(node);
			}
		
		},	
		_cleanClasses: function(html)
		{
			html = html.replace(/\s*class="TOC(.*?)"/gi, "" ) ;		
			html = html.replace(/\s*class="Heading(.*?)"/gi, "" ) ;					
			html = html.replace(/\s*class="Body(.*?)"/gi, "" ) ;
			
			html = html.replace( /<p(.*?)>&nbsp;<\/p>/gi, '');		
			
			return html;					
		},
		_cleanStyles: function(html)
		{
			html = html.replace( /\s*mso-[^:]+:[^;"]+;?/gi, "" ) ;
			html = html.replace( /\s*margin(.*?)pt\s*;/gi, "" ) ;
			html = html.replace( /\s*margin(.*?)cm\s*;/gi, "" ) ;			
			html = html.replace( /\s*text-indent:(.*?)\s*;/gi, "" ) ;
			html = html.replace( /\s*line-height:(.*?)\s*;/gi, "" ) ;			
			html = html.replace( /\s*page-break-before: [^\s;]+;?"/gi, "\"" ) ;
			html = html.replace( /\s*font-variant: [^\s;]+;?"/gi, "\"" ) ;
			html = html.replace( /\s*tab-stops:[^;"]*;?/gi, "" ) ;
			html = html.replace( /\s*tab-stops:[^"]*/gi, "" ) ;
			html = html.replace( /\s*face="[^"]*"/gi, "" ) ;
			html = html.replace( /\s*face=[^ >]*/gi, "" ) ;
			html = html.replace( /\s*font:(.*?);/gi, "" ) ;
			html = html.replace( /\s*font-size:(.*?);/gi, "" ) ;
			html = html.replace( /\s*font-weight:(.*?);/gi, "" ) ;				
			html = html.replace( /\s*font-family:[^;"]*;?/gi, "" ) ;
			html = html.replace(/<span style="Times New Roman&quot;">\s\n<\/span>/gi, '');	
			
			return html;				
					
		},
		_clean: function(html)
		{		
			return html.replace(/<(?!\s*\/?(span|label|a|br|p|b|i|del|strike|img|video|audio|iframe|object|embed|param|blockquote|mark|cite|small|ul|ol|li|hr|dl|dt|dd|sup|sub|big|pre|code|figure|figcaption|strong|em|table|tr|td|th|tbody|thead|tfoot|h1|h2|h3|h4|h5|h6)\b)[^>]+>/gi,"");
		},	
		
		// TEXTAREA CODE FORMATTING
		formating: function (html)
		{
			// lowercase
			if ($.browser.msie) 
			{
				html = html.replace(/< *(\/ *)?(\w+)/g,function(w){return w.toLowerCase()});	
				html = html.replace(/style="(.*?)"/g,function(w){return w.toLowerCase()});									
				html = html.replace(/ jQuery(.*?)=\"(.*?)\"/gi, '');
			}	
			
			// Firefox Convert Span
			if ($.browser.mozilla) html = this.convertSpan(html);				

			//html = html.replace(/<span id="pastemarkerend">([\w\W]*?)<\/span>/, "$1");

			html = html.replace(/\<font([\w\W]*?)color="(.*?)">([\w\W]*?)\<\/font\>/gi, '<span style="color: $2;">$3</span>');
			html = html.replace(/\<font([\w\W]*?)>([\w\W]*?)\<\/font\>/gi, "<span$1>$2</span>");
			html = html.replace(/\<p><span>([\w\W]*?)<\/span><\/p>/gi, "<p>$1</p>");						
			html = html.replace(/<span>([\w\W]*?)<\/span>/gi, '$1');				
			
			// mini clean
			html = html.replace(/ class="Apple-style-span"/gi, '');
			html = html.replace(/ class="Apple-tab-span"/gi, '');			
			html = html.replace(/<p><p>/g, '<p>');
			html = html.replace(/<\/p><\/p>/g, '</p>'); 
			html = html.replace(/<hr(.*?)>/g, '<hr>'); 
			html = html.replace(/<p>&nbsp;/g, '<p>'); 			
			html = html.replace(/<p><ul>/g, '<ul>'); 
			html = html.replace(/<p><ol>/g, '<ol>'); 
			html = html.replace(/<\/ul><\/p>/g, '</ul>'); 
			html = html.replace(/<\/ol><\/p>/g, '</ol>'); 									
			
			// remove formatting
			html = html.replace(/[\t]*/g, ''); 
			//html = html.replace(/[\r\n]*/g, ''); 
			html = html.replace(/\n\s*\n/g, "\n"); 
			html = html.replace(/^[\s\n]*/, '');
			html = html.replace(/[\s\n]*$/, '');	

			// empty tags
			var btags = ["<pre></pre>","<blockquote></blockquote>","<em></em>","<b></b>","<ul></ul>","<ol></ol>","<li></li>","<table></table>","<tr></tr>","<span><span>", "<span>&nbsp;<span>", "<p> </p>", "<p></p>", "<p>&nbsp;</p>",  "<p><br></p>", "<div></div>"];
			for (i = 0; i < btags.length; ++i)
			{
				var bbb = btags[i];
				html = html.replace(new RegExp(bbb,'gi'), "");
			}	
			
			// add formatting before
			var lb = '\r\n';
			var btags = ["<form","<fieldset","<legend","<object","<embed","<select","<option","<input","<textarea","<br>","<br />","<pre","<blockquote","<ul","<ol","<li","<dl","<dt","<dd","<\!--","<table", "<thead","<tbody","<caption","</caption>","<th","<tr","<td","<figure"];
			for (i = 0; i < btags.length; ++i)
			{
				var bbb = btags[i];
				html = html.replace(new RegExp(bbb,'gi'),lb+bbb);
			}		
			
			// add formatting after
			var etags = ['</p>', '</div>', '</ul>', '</ol>', '</h1>', '</h2>', '</h3>', '</h4>', '</h5>', '</h6>', '</dl>', '</dt>', '</dd>', '</form>', '</blockquote>', '</pre>', '</legend>', '</fieldset>', '</object>', '</embed>', '</textarea>', '</select>', '</option>', '</table>', '</thead>', '</tbody>', '</tr>', '</td>', '</th>', '</figure>'];
			for (i = 0; i < etags.length; ++i)
			{
				var bbb = etags[i];
				html = html.replace(new RegExp(bbb,'gi'),bbb+lb);
			}
						
			// indenting
			html = html.replace(/<li/g, "\t<li");
			html = html.replace(/<tr/g, "\t<tr");
			html = html.replace(/<td/g, "\t\t<td");		
			html = html.replace(/<\/tr>/g, "\t</tr>");	
			
		
			return html;
		},
		convertSpan: function(html)
		{
			html = html.replace(/\<span(.*?)style="font-weight: bold;"\>([\w\W]*?)\<\/span\>/gi, "<strong>$2</strong>");
			html = html.replace(/\<span(.*?)style="font-style: italic;"\>([\w\W]*?)\<\/span\>/gi, "<em>$2</em>");
			html = html.replace(/\<span(.*?)style="font-weight: bold; font-style: italic;"\>([\w\W]*?)\<\/span\>/gi, "<em><strong>$2</strong></em>");
			html = html.replace(/\<span(.*?)style="font-style: italic; font-weight: bold;"\>([\w\W]*?)\<\/span\>/gi, "<strong><em>$2</em></strong>");
	
			return html;
	  	},			
		
		// TOOLBAR
		buildToolbar: function()
		{
			if (this.opts.toolbar === false) return false;
		
			this.$toolbar = $('<ul>').addClass('redactor_toolbar');
			
	   		if (this.opts.air)
	   		{
	   			$(this.air).append(this.$toolbar);
	   			this.$box.prepend(this.air);
	   		}
			else this.$box.prepend(this.$toolbar);			
									
			$.each(RTOOLBAR, function(key,s)
			{

				var li = $('<li>');	   						
				
				if (key == 'fullscreen') $(li).addClass('redactor_toolbar_right');
				
				var a = $('<a href="javascript:void(null);" title="' + s.title + '" class="redactor_btn_' + key + '"><span>&nbsp;</span></a>');

				if (typeof(s.func) == 'undefined') a.click(function() { this.execCommand(s.exec, key); }.bind2(this));
				else if (s.func != 'show') a.click(function(e) { this[s.func](e); }.bind2(this));

				if (key == 'backcolor' || key == 'fontcolor' || typeof(s.dropdown) != 'undefined')
				{
					var dropdown = $('<div class="redactor_dropdown" style="display: none;">');
					
					// build colorpickers
					if (key == 'backcolor' || key == 'fontcolor')
					{
						if (key == 'backcolor')	
						{
							if ($.browser.msie) var mode = 'BackColor';
							else var mode = 'hilitecolor';								
						}	
						else var mode = 'ForeColor';
			
						$(dropdown).width(210);
						
			
						var len = this.opts.colors.length;
						for (var i = 0; i < len; ++i)
						{						
							var color = this.opts.colors[i];
							
							var swatch = $('<a rel="' + color + '" href="javascript:void(null);" class="redactor_color_link"></a>').css({ 'backgroundColor': color });
							$(dropdown).append(swatch);
							
							var _self = this;
							$(swatch).click(function()
							{
								 var color = $(this).attr('rel');
								_self.execCommand(mode, color); 
							});
						}
						
						/*
							TODO: color none
							
							var elnone = $('<a href="javascript:void(null);" class="redactor_color_none">').html(RLANG.none).click();												
							$(dropdown).append(elnone);
						*/
						
					}
					else
					{
					
						$.each(s.dropdown,
							function (x, d)
							{
								if (typeof(d.style) == 'undefined') d.style = '';
								
								if (d.name == 'separator')
				   				{
									var drop_a = $('<a class="redactor_separator_drop">');
					   			}	
					   			else
					   			{
					   				var drop_a = $('<a href="javascript:void(null);" style="' + d.style + '">' + d.title + '</a>');
					   			
				   					if (typeof(d.func) == 'undefined') $(drop_a).click(function() { this.execCommand(d.exec, x); }.bind2(this));
									else 
									{
										$(drop_a).click(function(e)
										{
											// if (typeof(d.params) != 'undefined') this[d.func](d.params);
											// else 
											
											this[d.func](e);											
											
										}.bind2(this));	
									}
					   			}					
	
								$(dropdown).append(drop_a);
								
							}.bind2(this)
						);						
					
					}
										
					this.$box.append(dropdown);			
					
				}
				
				// observing dropdown
				if (key == 'backcolor' || key == 'fontcolor' || typeof(s.dropdown) != 'undefined')
				{
					this.hdlHideDropDown = function(e) { this.hideDropDown(e, dropdown, key) }.bind2(this);
					this.hdlShowDropDown = function(e) { this.showDropDown(e, dropdown, key) }.bind2(this);

					a.click(this.hdlShowDropDown); 
					
					$(document).click(this.hdlHideDropDown);																
				}
			
				$(li).append(a);
				this.$toolbar.append(li);
				
 				if (typeof(s.separator) != 'undefined')
   				{
					var li = $('<li class="redactor_separator"></li>');
	   				this.$toolbar.append(li);	   					
	   			}
				
				
			}.bind2(this));
			
			// hide all dropdowns
			$(this.doc).click(function() { this.hideAllDropDown() }.bind2(this));
			
		},		
		
		// DROPDOWN		
		showDropDown: function(e, dropdown, key)
		{		
			this.hideAllDropDown();		
				 	
	   		this.setBtnActive(key);
			this.getBtn(key).addClass('dropact');
	   		
			var left = this.getBtn(key).position().left;
			
			if (this.opts.air)
			{
				var air_left = this.air.position().left;
				var air_top = this.air.position().top;	
				
				left += air_left;
				
				$(dropdown).css('top', air_top+28);			
			}
			
			$(dropdown).css('left', left + 'px').show();	   		
		},
		hideAllDropDown: function()
		{
			this.$toolbar.find('a.dropact').removeClass('act').removeClass('dropact');
	   		this.$box.find('.redactor_dropdown').hide();
		},
		hideDropDown: function(e, dropdown, key)
		{
			if (!$(e.target).parent().hasClass('dropact'))
			{
				$(dropdown).removeClass('act');
				this.showedDropDown = false;
				this.hideAllDropDown();
			}	
			
			$(document).unbind('click', this.hdlHideDropDown);
			$(this.doc).unbind('click', this.hdlHideDropDown);			
		},			

		
		// FULLSCREEN
		fullscreen: function()
		{	
			if (this.opts.fullscreen === false)
			{
				this.changeBtnIcon('fullscreen', 'normalscreen');
				this.setBtnActive('fullscreen');				
				this.opts.fullscreen = true;
				
				this.height = this.$frame.css('height');
				this.width = (this.$box.width() - 2) + 'px';
				
				var html = this.getCodeEditor();

				this.$box.addClass('redactor_box_fullscreen').after('<span id="fullscreen_' + this.editorID +  '"></span>');
				
				$(document.body).prepend(this.$box).css('overflow', 'hidden');

				this.enable(html);										
				this.enableAir();
				
				$(this.doc).click(function() { this.hideAllDropDown() }.bind2(this));
								
				this.fullScreenResize();				
				$(window).resize(function() { this.fullScreenResize(); }.bind2(this));
				$(document).scrollTop(0,0);
				this.focus();
			}
			else
			{
				this.removeBtnIcon('fullscreen', 'normalscreen');
				this.setBtnInactive('fullscreen');
				this.opts.fullscreen = false;					

				$(window).unbind('resize', function() { this.fullScreenResize(); }.bind2(this));	
				$(document.body).css('overflow', '');				
				
				var html = this.getCodeEditor();	
				
				this.$box.removeClass('redactor_box_fullscreen').css('width', 'auto');
				
				$('#fullscreen_' + this.editorID).after(this.$box).remove();			
			
				this.enable(html);
				this.enableAir();				
				
				$(this.doc).click(function() { this.hideAllDropDown() }.bind2(this));
				
				this.$frame.css('height', this.height);						
				this.$el.css('height', this.height);	
				this.focus();								
			}
		},
		fullScreenResize: function()
		{
			if (this.opts.fullscreen === false) return;
			
			var hfix = 42;
			if (this.opts.air) hfix = 2;
			
			var height = $(window).height() - hfix;
			
			this.$box.width($(window).width() - 2);
			this.$frame.height(height);		
			this.$el.height(height);	
		},
	
		// SELECTION AND NODE MANIPULATION		
		getSelection: function ()
		{
			if (this.$frame.get(0).contentWindow.getSelection) return this.$frame.get(0).contentWindow.getSelection();
			else if (this.$frame.get(0).contentWindow.document.selection) return this.$frame.get(0).contentWindow.document.selection.createRange();
		},	
		replaceSelection: function(html) 
		{
			var sel, range, node;
			
			if (typeof this.$frame.get(0).contentWindow.getSelection != "undefined") 
			{
			    // IE 9 and other non-IE browsers
			    sel = window.getSelection();
			
			    // Test that the Selection object contains at least one Range
			    if (sel.getRangeAt && sel.rangeCount) {
			        // Get the first Range (only Firefox supports more than one)
			        range = this.$frame.get(0).contentWindow.getSelection().getRangeAt(0);
			        range.deleteContents();
			
			        // Create a DocumentFragment to insert and populate it with HTML
			        // Need to test for the existence of range.createContextualFragment
			        // because it's non-standard and IE 9 does not support it
			        if (range.createContextualFragment) {
			            node = range.createContextualFragment(html);
			        } else {
			            // In IE 9 we need to use innerHTML of a temporary element
			            var div = this.$frame.get(0).contentWindow.document.createElement("div"), child;
			            div.innerHTML = html;
			            node = this.$frame.get(0).contentWindow.document.createDocumentFragment();
			            while ( (child = div.firstChild) ) {
			                node.appendChild(child);
			            }
			        }
			        range.insertNode(node);
			    }
			} 
			else if (this.$frame.get(0).contentWindow.document.selection && this.$frame.get(0).contentWindow.document.selection.type != "Control") 
			{
			    // IE 8 and below
			    range = this.$frame.get(0).contentWindow.document.selection.createRange();
			    range.pasteHTML(html);
			}
		},				
		saveSelection: function() 
		{
			if (window.getSelection) 
			{
				sel = this.getSelection();
				if (sel.getRangeAt && sel.rangeCount) this.cursorPosition = sel.getRangeAt(0);
			}
			else if (document.selection && document.selection.createRange) this.cursorPosition = this.getSelection();

			this.cursorPosition = null;
		},
		restoreSelection: function() 
		{
			if (this.cursorPosition)
			{
				if (window.getSelection) 
				{
					sel = this.getSelection();
					sel.removeAllRanges();
					sel.addRange(this.cursorPosition);
				}
				else if (document.selection && this.cursorPosition.select) this.cursorPosition.select();
			}
		},	
		insertNodeAtCaret: function (node) 
		{
		    if (typeof window.getSelection != "undefined") {
		        var sel = this.getSelection();
		        if (sel.rangeCount) 
		        {
		            var range = sel.getRangeAt(0);
		            range.collapse(false);
		            range.insertNode(node);		            
		            range = range.cloneRange();
		            range.selectNodeContents(node);
		            range.collapse(false);
		            sel.removeAllRanges();
		            sel.addRange(range);
		        }
		    } 
		    else if (typeof document.selection != "undefined" && document.selection.type != "Control") 
		    {
		        var html = (node.nodeType == 1) ? node.outerHTML : node.data;
		        var id = "marker_" + ("" + Math.random()).slice(2);
		        html += '<span id="' + id + '"></span>';
		        var textRange = this.getSelection();
		        textRange.collapse(false);
		        textRange.pasteHTML(html);
		        var markerSpan = document.getElementById(id);
				textRange.moveToElementText(markerSpan);
				textRange.select();
				markerSpan.parentNode.removeChild(markerSpan);
				
		    }
		},		
		getParentNodeName: function()
		{		
			if (window.getSelection) return this.getSelection().getRangeAt(0).startContainer.parentNode.nodeName;
			else if (document.selection) return this.getSelection().parentElement().nodeName;
		},
		getParentNode: function()
		{
			if (window.getSelection) return this.getSelection().getRangeAt(0).startContainer.parentNode;
			else if (document.selection) return this.getSelection().parentElement();	
		},
		getParentNodeID: function()
		{
			if (window.getSelection) return this.getSelection().getRangeAt(0).startContainer.parentNode.id;
			else if (document.selection) return this.getSelection().parentElement().id;	
		},
		getCurrentNode: function()
		{
			if (window.getSelection) return this.getSelection().getRangeAt(0).startContainer;
			else if (document.selection) return this.getSelection();	
		},	
		setFocusNode: function(node, toStart)
		{
			var range = this.doc.createRange();
		    
    		var selection = this.getSelection();
		    var toStart = toStart ? 0 : 1;

    		if (selection != null)
    		{
			    range.selectNodeContents(node);
			    selection.addRange(range);
			    selection.collapse(node, toStart);		    	
		    }
			    
		    this.focus();
		},		
		
		/*
		
		ON THE FUTURE
		
		getSelected: function()
		{
			if ($.browser.msie)
			{
				var caretPos = this.$frame.get(0).contentWindow.document.caretPos;
				if (caretPos != null) 
				{
					if (caretPos.parentElement != undefined)
					return caretPos.parentElement();
				}
			}
			else
			{
			    var sel = this.$frame.get(0).contentWindow.getSelection();
			    var node = sel.focusNode;
			    if (node) 
			    {
		    	    if (node.nodeName == "#text") return node.parentNode;
		        	else return node;
			    } 
			    else returnnull;
		    }
		},
		
		getUp: function(node, filter) 
		{
		
		  if (node)
		  {
		  
		      var tagname = node.tagName.toLowerCase();
		      
		      if (typeof(filter) == 'string')
		      {
					while (tagname != filter && tagname != 'body')
					{		        
						node = node.parentNode;
						tagname = node.tagName.toLowerCase();
					}		      
		      }
		      else 
		      {
					var bFound = false;
		        
					while (!bFound && tagname != 'body') 
					{
						for (i = 0; i < filter.length; i++) 
						{
							if (tagname == filter[i])
							{
								bFound = true;
								break;
							}
						}
						if (!bFound)
						{
							node = node.parentNode;
							tagname = node.tagName.toLowerCase();
						}
					}
				}
					
				if (tagname != 'body') return (node);
				else return (null);
		      
			} 
			else return(null);
		},		
		*/				
		

  		// TABLE
        showTable: function()
        {       
            redactorActive = this;
            this.modalInit(RLANG.table, this.opts.path + 'plugins/table.html', 360, 200);
        },
        insertTable: function()
        {           
            var rows = $('#redactor_table_rows').val();
            var columns = $('#redactor_table_columns').val();
            
            var table_box = $('<div></div>');
            
            var tableid = Math.floor(Math.random() * 99999);
            var table = $('<table id="table' + tableid + '"><tbody></tbody></table>');
            
            for (i = 0; i < rows; i++)
            {
            	var row = $('<tr></tr>')
            	for (z = 0; z < columns; z++)
            	{
            		var column = $('<td>&nbsp;</td>');
            		$(row).append(column);
            	}
            	$(table).append(row);
            }
            
            $(table_box).append(table);
            var html = $(table_box).html();
            
            if ($.browser.msie) html += '<p></p>';
 			else html += '<p>&nbsp;</p>';           
                        
            redactorActive.execCommand('inserthtml', html);            
   			this.enableObjects();
            this.docObserve();          
            this.modalClose();
            
            $table = $(this.doc).find('body').find('#table' + tableid);
    
            
        },
		tableObserver: function(e)
		{
			$table = $(e.target).parents('table');

			$table_tr = $table.find('tr');
			$table_td = $table.find('td');

			$table_td.removeClass('current');

			$tbody = $(e.target).parents('tbody');
			$thead = $($table).find('thead');

			$current_td = $(e.target);
			$current_td.addClass('current');
			
			$current_tr = $(e.target).parents('tr');
		},	
		deleteTable: function()
		{
			$($table).remove();
			$table = false;
		},
		deleteRow: function()
		{
			$($current_tr).remove();
		},
		deleteColumn: function()
		{
			var index = $($current_td).get(0).cellIndex;
            
            $($table).find('tr').each(function()
            {   
                $(this).find('td').eq(index).remove();
            });     
		},	
      	addHead: function()
        {
            if ($($table).find('thead').size() != 0) this.deleteHead();
            else
            {
                var tr = $($table).find('tr').first().clone();
                tr.find('td').html('&nbsp;');
                $thead = $('<thead></thead>');
                $thead.append(tr);
                $($table).prepend($thead);
            }
        },      
        deleteHead: function()
        {
            $($thead).remove(); 
            $thead = false;   
        },  
		insertRowAbove: function()
		{
			this.insertRow('before');		
		},	        
		insertRowBelow: function()
		{
			this.insertRow('after');	
		},
		insertColumnLeft: function()
		{
			this.insertColumn('before');		
		},
		insertColumnRight: function()
		{
			this.insertColumn('after');
		},	
		insertRow: function(type)
		{
			var new_tr = $($current_tr).clone();
			new_tr.find('td').html('&nbsp;');
			if (type == 'after') $($current_tr).after(new_tr);		
			else $($current_tr).before(new_tr);		
		},
		insertColumn: function(type)			    
		{
			var index = 0;
			
			$current_td.addClass('current');
							
			$current_tr.find('td').each(function(i,s)
			{		
				if ($(s).hasClass('current')) index = i;
			});
            
			$table_tr.each(function(i,s)
			{   
			    var current = $(s).find('td').eq(index);    
			    var td = current.clone();   
			    td.html('&nbsp;');
			    if (type == 'after') $(current).after(td);
			    else $(current).before(td);			    
			});			
		},		
		
		// INSERT FILE
		showFile: function()
		{
            
            if (jQuery.browser.msie) 
            {
            	this.spanid = Math.floor(Math.random() * 99999);
            	this.execCommand('inserthtml', '<span id="span' + this.spanid + '"></span>');
            }
            
			redactorActive = this;
			
            var handler = function()
            {
            	// upload params
                var params = '';
                if (this.opts.fileUploadFunction) params = this.opts.fileUploadFunction();
                
                $('#redactor_file').dragupload(
                { 
                	url: this.opts.fileUpload + params, 
                	success: function(data)
	                {
		                this.fileUploadCallback(data);
		                
                	}.bind2(this)
                });
                
                this.uploadInit('redactor_file', { auto: true, url: this.opts.fileUpload + params, success: function(data) {
                    
                    this.fileUploadCallback(data);
                    
                }.bind2(this)  });                  
           

            }.bind2(this);
            
        
            redactorActive = this;
			this.modalInit(RLANG.file, this.opts.path + 'plugins/file.html?r', 500, 380, handler);
		},	
		fileUploadCallback: function(data)
		{
            if ($.browser.msie)
            {       
                $(redactorActive.doc.getElementById('span' + redactorActive.spanid)).after(data);
                $(redactorActive.doc.getElementById('span' + redactorActive.spanid)).remove();
            }   
            else redactorActive.execCommand('inserthtml', data);
            
			this.modalClose();	
			this.docObserve();		
		},	
		fileEdit: function(e)
		{
			var el = e.target;
			var file_id = $(el).attr('rel');
			
			var handler = function()
            {
				$('#file').val($(el).text());
				$('#redactorFileDeleteBtn').click(function()
				{
					this.fileDelete(el, file_id);					
				}.bind2(this));
				
				$('#redactorFileDownloadBtn').click(function()
				{				
					this.fileDownload(el, file_id);
				}.bind2(this));
			
			}.bind2(this);
			
			redactorActive = this;
			this.modalInit(RLANG.file, this.opts.path + 'plugins/file_edit.html', 400, 200, handler);
		},
		fileDelete: function(el, file_id)
		{
			$(el).remove();
			$.get(this.opts.fileDelete + file_id);
			redactorActive.$frame.get(0).contentWindow.focus();
			this.modalClose();				
		},
		fileDownload: function(el, file_id)
		{
			top.location.href = this.opts.fileDownload + file_id;				
		},			


        // INSERT IMAGE 
        imageEdit: function(e)
        {
			var handler = function()
			{
				var elObj = $(e.target);
				
				$('#redactor_file_alt').val(elObj.attr('alt'));
				$('#redactor_image_edit_src').attr('href', elObj.attr('src'));				
				$('#redactor_form_image_align').val(elObj.css('float'));
				$('#redactor_image_edit_delete').click(function() { this.deleteImage(e.target); }.bind2(this));
				$('#redactorSaveBtn').click(function() { this.imageSave(e.target); }.bind2(this)); 
				
			}.bind2(this); 

			redactorActive = this;      
            this.modalInit(RLANG.image, this.opts.path + 'plugins/image_edit.html', 380, 290, handler);
            
        },
        imageSave: function(el)
        {
			$(el).attr('alt', $('#redactor_file_alt').val());

		   var floating = $('#redactor_form_image_align').val();
		
		   if (floating == 'left') $(el).css({ 'float': 'left', margin: '0 10px 10px 0' });
		   else if (floating == 'right') $(el).css({ 'float': 'right', margin: '0 0 10px 10px' });
		   else $(el).css({ 'float': 'none', margin: '0' });

			this.modalClose();
        },
        deleteImage: function(el)
        {
            $(el).remove();
            this.modalClose();
        },      
        showImage: function()
        {
            this.spanid = Math.floor(Math.random() * 99999);
            if (jQuery.browser.msie) this.execCommand('inserthtml', '<span id="span' + this.spanid + '"></span>');

            var handler = function()
            {
            
            	if (this.opts.imageGetJson !== false)
            	{
					$.getJSON(this.opts.imageGetJson, function(data) {
						  $.each(data, function(key, val)
						  {
						  		var img = $('<img src="' + val.thumb + '" rel="' + val.image + '">');
						  		img.click(function() { redactorActive.imageSetThumb($(this).attr('rel')); });
						  		
								$('#redactor_image_box').append(img);
						  });
					});    
				}    
				else
				{
					$('#redactor_tabs li').eq(1).remove();				
				}            


            	// upload params
                var params = '';
                if (this.opts.imageUploadFunction) params = this.opts.imageUploadFunction();

                
                $('#redactor_file').dragupload(
                { 
                	url: this.opts.imageUpload + params, 
                	success: function(data)
	                {
		                this.imageUploadCallback(data);
		                
                	}.bind2(this)
                });
                
                this.uploadInit('redactor_file', { auto: true, url: this.opts.imageUpload + params, success: function(data) {
                    
                    this.imageUploadCallback(data);
                    
                }.bind2(this)  });                 
  
                $('#redactorUploadBtn').click(this.imageUploadCallbackLink);
           

            }.bind2(this);            
            
        
            redactorActive = this;
            this.modalInit(RLANG.image, this.opts.path + 'plugins/image.html', 570, 410, handler);
            
        },
        imageSetThumb: function(data)
        {
        	this._imageSet('<img alt="" src="' + data + '" />');
        },
        imageUploadCallbackLink: function()
        {
            if ($('#redactor_file_link').val() != '') 
            {
            	var data = '<img src="' + $('#redactor_file_link').val() + '">';
            	
            	redactorActive._imageSet(data);
            }
            else this.modalClose();

        }, 
        imageUploadCallback: function(data)
        {        
        	redactorActive._imageSet(data);
        },
        _imageSet: function(html)             
        {
        	html = '<p>' + html + '</p>';
        
            redactorActive.$frame.get(0).contentWindow.focus();
            
            if ($.browser.msie)
            {       
                $(redactorActive.doc.getElementById('span' + redactorActive.spanid)).after(html);
                $(redactorActive.doc.getElementById('span' + redactorActive.spanid)).remove();
            }   
            else
            {
                redactorActive.execCommand('inserthtml', html);
            }
    
            this.modalClose();
            this.docObserve();                   	
        },
				
	
		// INSERT LINK				
		showLink: function()
		{
			redactorActive = this;

			var handler = function()
			{
				var sel = this.getSelection();
				
				if ($.browser.msie)
				{
					if (this.getParentNodeName() == 'A')
					{
						this.insert_link_node = $(this.getParentNode());
						var text = this.insert_link_node.text();
						var url = this.insert_link_node.attr('href');						
					}
					else
					{
						var text = sel.text;
						var url = '';
						
						this.spanid = Math.floor(Math.random() * 99999);
						
						if (sel.text != '') this.replaceSelection('<span id="span' + this.spanid + '">' + sel.text + '</span>');
						else this.execCommand('inserthtml', '<span id="span' + this.spanid + '"></span>');
					}
				}
				else
				{
					if (sel.anchorNode.parentNode.tagName == 'A')
					{
						var url = sel.anchorNode.parentNode.href;
						var text = sel.anchorNode.parentNode.text;
						if (sel.toString() == '') this.insert_link_node = sel.anchorNode.parentNode
					}
					else
					{
					 	var text = sel.toString();
						var url = '';
					}
				}

				$('#redactor_link_url').val(url).focus();
				$('#redactor_link_text').val(text);
						
			}.bind2(this);

			this.modalInit(RLANG.link, this.opts.path + 'plugins/link.html', 400, 260, handler);
	
		},	
		insertLink: function()
		{
			var value = $('#redactor_link_text').val();
			if (value == '') return false;
			
			if ($('#redactor_link_id_url').get(0).checked)  var mailto = '';
			else var mailto = 'mailto:';
			
			var a = '<a href="' + mailto + $('#redactor_link_url').val() + '">' + $.trim(value) + '</a> ';
	
			if (a)
			{
				if (redactorActive.insert_link_node)
				{
					$(redactorActive.insert_link_node).text(value);
					$(redactorActive.insert_link_node).attr('href', $('#redactor_link_url').val());								
				}
				else
				{
 					if ($.browser.msie)
		            {     
		            	$(redactorActive.doc.getElementById('span' + redactorActive.spanid)).replaceWith(a);
		            }   				
		            else 
		            {	
				      	redactorActive.execCommand('inserthtml', a);
		           }
				}
			}
			
			redactorActive.modalClose();
		},		
		
		// INSERT VIDEO		
		showVideo: function()
		{
           
            if (jQuery.browser.msie) 
            {
				this.spanid = Math.floor(Math.random() * 99999);            
            	this.execCommand('inserthtml', '<span id="span' + this.spanid + '"></span>');		
            }
		
			redactorActive = this;
			this.modalInit(RLANG.video, this.opts.path + 'plugins/video.html', 600, 360, function()
			{
				$('#redactor_insert_video_area').focus();			
			});
		},	
		insertVideo: function()
		{
			var data = $('#redactor_insert_video_area').val();
			if (redactorActive.opts.visual) 
			{
				// iframe video
				if (data.search('iframe')) {}
				
				// flash
				else data = '<p class="redactor_video_box">' + data + '</p>';
			}
			
            if ($.browser.msie)
            {       
                $(redactorActive.doc.getElementById('span' + redactorActive.spanid)).after(data);
                $(redactorActive.doc.getElementById('span' + redactorActive.spanid)).remove();
            }   			
			else redactorActive.execCommand('inserthtml', data);
			
			this.modalClose();
			
		},			
		
			
		
		// TOGGLE
		toggle: function()
		{
			if (this.opts.visual)
			{
				this.$frame.hide();
				
				var html = this.getCodeEditor();
				html = this.formating(html);
				
				this.$el.val(html).show();
				
				this.setBtnActive('html');					
				this.opts.visual = false;			
			}
			else
			{
				this.$el.hide();			
				
				this.setCodeEditor(this._clean(this.getCodeTextarea(false)));	
									
				this.$frame.show();
				
				if ($(this.doc.body).html() == '') this.setCodeEditor('<p><br /></p>');					
				
				this.focus();
				
				this.setBtnInactive('html');									
				this.opts.visual = true;							
			}
		},			
		
		// RESIZE
		buildResizer: function()
		{
			if (this.opts.resize === false) return false;
			
			this.$resizer_box = $('<div>').addClass('redactor_resizer');
			this.$resizer = $('<div>');
			
			this.$resizer_box.append(this.$resizer);
			this.$box.append(this.$resizer_box);			

           	this.$resizer.mousedown(function(e) { this.initResize(e) }.bind2(this));
					
		},				
		initResize: function(e)
		{	
			if (e.preventDefault) e.preventDefault();
			
			this.splitter = e.target;
	
			if (this.opts.visual)
			{
				this.element_resize = this.$frame;
				this.element_resize.get(0).style.visibility = 'hidden';
				this.element_resize_parent = this.$el;
			}
			else
			{
				this.element_resize = this.$el;
				this.element_resize_parent = this.$frame;
			}
	
			this.stopResizeHdl = function (e) { this.stopResize(e) }.bind2(this);
			this.startResizeHdl = function (e) { this.startResize(e) }.bind2(this);
			this.resizeHdl =  function (e) { this.resize(e) }.bind2(this);
	
			$(document).mousedown(this.startResizeHdl);
			$(document).mouseup(this.stopResizeHdl);
			$(this.splitter).mouseup(this.stopResizeHdl);
	
			this.null_point = false;
			this.h_new = false;
			this.h = this.element_resize.height();
		},
		startResize: function()
		{
			$(document).mousemove(this.resizeHdl);
		},
		resize: function(e)
		{
			if (e.preventDefault) e.preventDefault();
			
			var y = e.pageY;
			if (this.null_point == false) this.null_point = y;
			if (this.h_new == false) this.h_new = this.element_resize.height();
	
			var s_new = (this.h_new + y - this.null_point) - 10;
	
			if (s_new <= 30) return true;
	
			if (s_new >= 0)
			{
				this.element_resize.get(0).style.height = s_new + 'px';
				this.element_resize_parent.get(0).style.height = s_new + 'px';
			}
		},
		stopResize: function(e)
		{
			$(document).unbind('mousemove', this.resizeHdl);
			$(document).unbind('mousedown', this.startResizeHdl);
			$(document).unbind('mouseup', this.stopResizeHdl);
			$(this.splitter).unbind('mouseup', this.stopResizeHdl);
			
			this.element_resize.get(0).style.visibility = 'visible';
		},		
		
			
		
		// =BUTTONS MANIPULATIONS
		getBtn: function(key)
		{
			return $(this.$toolbar.find('a.redactor_btn_' + key));
		},
		setBtnActive: function(key)
		{
			this.getBtn(key).addClass('act');
		},
		setBtnInactive: function(key)
		{
			this.getBtn(key).removeClass('act');			
		},
		changeBtnIcon: function(key, classname)
		{
			this.getBtn(key).addClass('redactor_btn_' + classname);			
		},
		removeBtnIcon: function(key, classname)
		{
			this.getBtn(key).removeClass('redactor_btn_' + classname);			
		},				
		

		
		// API
		setCodeEditor: function(code)
		{
			$(this.doc.body).html(code);
			this.docObserve();			 
		},
		setCodeTextarea: function(code)
		{
			this.$el.val(code);
		},
		getCodeEditor: function()
		{
			return $(this.doc.body).html();
		},		
		getCodeTextarea: function(sync)
		{
          	if (sync !== false) 
          	{
	          	this.clean(false);
          		this.syncCodeToTextarea();	
          	}
          		
			return $.trim(this.$el.val());
		},
		syncCodeToTextarea: function()
		{
			if (this.opts.visual) this.setCodeTextarea(this.getCodeEditor());
		},
		syncCodeToEditor: function()
		{
			this.setCodeEditor(this.getCodeTextarea(false));		
		},		
		handler: function()
		{
			var html = this.getCodeEditor();
			
			$.ajax({
				url: this.opts.handler,
				type: 'post',
				data: 'redactor=' + escape(encodeURIComponent(html)),
				success: function(data)
				{
					this.setCodeEditor(data);
					this.syncCodeToTextarea();					
					
				}.bind2(this)
			});	
				
		},
		destroy: function()
		{			
			var html = this.getCodeEditor();
			
			this.$box.after(this.$el)
			this.$box.remove();
			this.$el.val(html).show();			
						
		},		
		
	  	  					
		
		// AUTOSAVE	
		autoSave: function()
		{
			if (this.opts.autosave === false) return false;

			setInterval(function()
			{
				$.post(this.opts.autosave, { data: this.getCodeEditor() });
				
			}.bind2(this), this.opts.interval*1000);
		},
			

		// MODAL
		modalInit: function(title, url, width, height, handler, scroll)
		{
	   		// modal overlay
	   		if ($('#redactor_modal_overlay').size() == 0)
	   		{
		   		this.overlay = $('<div id="redactor_modal_overlay" style="display: none;"></div>');
		   		$('body').prepend(this.overlay);
		   	}		
		
			if (this.opts.overlay) 
			{
				$('#redactor_modal_overlay').show();
				$('#redactor_modal_overlay').click(function() { this.modalClose(); }.bind2(this));
			}
			
			if ($('#redactor_modal').size() == 0)
			{
				this.modal = $('<div id="redactor_modal" style="display: none;"><div id="redactor_modal_close">&times;</div><div id="redactor_modal_header"></div><div id="redactor_modal_inner"></div></div>');
				$('body').append(this.modal);
			}
			
			$('#redactor_modal_close').click(function() { this.modalClose(); }.bind2(this));
			$(document).keyup(function(e) { if( e.keyCode == 27) this.modalClose(); }.bind2(this));
			$(this.doc).keyup(function(e) { if( e.keyCode == 27) this.modalClose(); }.bind2(this));			

			$.ajax({
				dataType: 'html',
				type: 'get',
				url: url,
				success: function(data)
				{		
					// parse lang
					$.each(RLANG, function(i,s)
					{
						var re = new RegExp("%RLANG\." + i + "%","gi");
						data = data.replace(re, s);						
					});
					
					$('#redactor_modal_inner').html(data);
					$('#redactor_modal_header').html(title);
					
					if (height === false) theight = 'auto';
					else theight = height + 'px';
					
					$('#redactor_modal').css({ width: width + 'px', height: theight, marginTop: '-' + height/2 + 'px', marginLeft: '-' + width/2 + 'px' }).fadeIn('fast');					

					if (scroll === true)
					{					
						$('#imp_redactor_table_box').height(height-$('#redactor_modal_header').outerHeight()-130).css('overflow', 'auto');						
					}
					
					if (typeof(handler) == 'function') handler();
					
					
				}.bind2(this)
			});
		},
		modalClose: function()
		{

			$('#redactor_modal_close').unbind('click', function() { this.modalClose(); }.bind2(this));
			$('#redactor_modal').fadeOut('fast', function()
			{
				$('#redactor_modal_inner').html('');			
				
				if (this.opts.overlay) 
				{
					$('#redactor_modal_overlay').hide();		
					$('#redactor_modal_overlay').unbind('click', function() { this.modalClose(); }.bind2(this));					
				}			
				
				$(document).unbind('keyup', function(e) { if( e.keyCode == 27) this.modalClose(); }.bind2(this));
				$(this.doc).unbind('keyup', function(e) { if( e.keyCode == 27) this.modalClose(); }.bind2(this));
				
			}.bind2(this));

		},	
		
				
        // UPLOAD
        uploadInit: function(element, options)
        {
            /*
                Options
            */
            this.uploadOptions = {
                url: false,
                success: false,
                start: false,
                trigger: false,
                auto: false,
                input: false
            };
      
            $.extend(this.uploadOptions, options);
    
    
            // Test input or form                 
            if ($('#' + element).get(0).tagName == 'INPUT')
            {
                this.uploadOptions.input = $('#' + element);
                this.element = $($('#' + element).get(0).form);
            }
            else
            {
                this.element = $('#' + element);
            }
            
    
            this.element_action = this.element.attr('action');
    
            // Auto or trigger
            if (this.uploadOptions.auto)
            {
				$(this.uploadOptions.input).change(function()
				{
					this.element.submit(function(e) { return false; });
					this.uploadSubmit();
				}.bind2(this));

            }
            else if (this.uploadOptions.trigger)
            {
                $('#' + this.uploadOptions.trigger).click(function() { this.uploadSubmit(); }.bind2(this)); 
            }
        },
        uploadSubmit : function()
        {
            this.uploadForm(this.element, this.uploadFrame());
        },  
        uploadFrame : function()
        {
            this.id = 'f' + Math.floor(Math.random() * 99999);
        
            var d = document.createElement('div');
            var iframe = '<iframe style="display:none" src="about:blank" id="'+this.id+'" name="'+this.id+'"></iframe>';
            d.innerHTML = iframe;
            document.body.appendChild(d);
    
            // Start
            if (this.uploadOptions.start) this.uploadOptions.start();
    
            $('#' + this.id).load(function () { this.uploadLoaded() }.bind2(this));
    
            return this.id;
        },
        uploadForm : function(f, name)
        {
            if (this.uploadOptions.input)
            {
                var formId = 'redactorUploadForm' + this.id;
                var fileId = 'redactorUploadFile' + this.id;
                this.form = $('<form  action="' + this.uploadOptions.url + '" method="POST" target="' + name + '" name="' + formId + '" id="' + formId + '" enctype="multipart/form-data"></form>');    
    
                var oldElement = this.uploadOptions.input;
                var newElement = $(oldElement).clone();
                $(oldElement).attr('id', fileId);
                $(oldElement).before(newElement);
                $(oldElement).appendTo(this.form);
                $(this.form).css('position', 'absolute');
                $(this.form).css('top', '-2000px');
                $(this.form).css('left', '-2000px');
                $(this.form).appendTo('body');  
                
                this.form.submit();
            }
            else
            {
                f.attr('target', name);
                f.attr('method', 'POST');
                f.attr('enctype', 'multipart/form-data');       
                f.attr('action', this.uploadOptions.url);
    
                this.element.submit();
            }
    
        },
        uploadLoaded : function()
        {
            var i = $('#' + this.id);
            
            if (i.contentDocument) var d = i.contentDocument;
            else if (i.contentWindow) var d = i.contentWindow.document;
            else var d = window.frames[this.id].document;
            
            if (d.location.href == "about:blank") return true;
    
            // Success
            if (this.uploadOptions.success) this.uploadOptions.success(d.body.innerHTML);
    
            this.element.attr('action', this.element_action);
            this.element.attr('target', '');
            //this.element.unbind('submit');
            //if (this.uploadOptions.input) $(this.form).remove();
        },								

		// UTILITY
		getRandomID: function()
		{
			return Math.floor(Math.random() * 99999);
		}		
	};
	

	// bind2
	Function.prototype.bind2 = function(object)
	{
	    var method = this; var oldArguments = $.makeArray(arguments).slice(1);
	    return function (argument)
	    {
	        if (argument == new Object) { method = null; oldArguments = null; }
	        else if (method == null) throw "Attempt to invoke destructed method reference.";
	        else { var newArguments = $.makeArray(arguments); return method.apply(object, oldArguments.concat(newArguments)); }
	    };
	};	
	

})(jQuery);


// Define: Linkify plugin from stackoverflow
(function($){
     
	var url1 = /(^|&lt;|\s)(www\..+?\..+?)(\s|&gt;|$)/g,
     url2 = /(^|&lt;|\s)(((https?|ftp):\/\/|mailto:).+?)(\s|&gt;|$)/g,     

      linkifyThis = function () 
      {
			var childNodes = this.childNodes,
			i = childNodes.length;
			while(i--)
			{
				var n = childNodes[i];
				if (n.nodeType == 3) 
				{
					var html = n.nodeValue;
					if (html)
					{
						html = html.replace(/&/g, '&amp;')
								   .replace(/</g, '&lt;')
								   .replace(/>/g, '&gt;')
	                               .replace(url1, '$1<a href="http://$2">$2</a>$3')
								   .replace(url2, '$1<a href="$2">$2</a>$5');
						
						$(n).after(html).remove();
					}
				}
				else if (n.nodeType == 1  &&  !/^(a|button|textarea)$/i.test(n.tagName)) 
				{
					linkifyThis.call(n);
				}
			}
      };
	
	$.fn.linkify = function () 
	{
		this.each(linkifyThis);
	};

})(jQuery);


// redactor_tabs
function showRedactorTabs(el, index)
{
	$('#redactor_tabs a').removeClass('redactor_tabs_act');
	$(el).addClass('redactor_tabs_act');
	
	$('.redactor_tabs').hide();
	$('#redactor_tabs' + index).show();
}


/*
	Plugin Drag and drop Upload v1.0.1
	http://imperavi.com/ 
	Copyright 2012, Imperavi Ltd.
*/
(function($){
	
	// Initialization	
	$.fn.dragupload = function(options)
	{		
		return this.each(function() {
			var obj = new Construct(this, options);
			obj.init();
		});
	};
	
	// Options and variables	
	function Construct(el, options) {

		this.opts = $.extend({
		
			url: false,
			success: false,
			preview: false,
			
			text: RLANG.drop_file_here,
			atext: RLANG.or_choose
			
		}, options);
		
		this.$el = $(el);
	};

	// Functionality
	Construct.prototype = {
		init: function()
		{	
			if (!$.browser.opera && !$.browser.msie) 
			{	

				this.droparea = $('<div class="redactor_droparea"></div>');
				this.dropareabox = $('<div class="redactor_dropareabox">' + this.opts.text + '</div>');	
				this.dropalternative = $('<div class="redactor_dropalternative">' + this.opts.atext + '</div>');
				
				this.droparea.append(this.dropareabox);	
				
				this.$el.before(this.droparea);	
				this.$el.before(this.dropalternative);	
								
				// drag over
				this.dropareabox.bind('dragover', function() { return this.ondrag(); }.bind2(this));
				
				// drag leave
				this.dropareabox.bind('dragleave', function() { return this.ondragleave(); }.bind2(this));	

		
				// drop
			    this.dropareabox.get(0).ondrop = function(event)
			    {
			        event.preventDefault();
			        
			        this.dropareabox.removeClass('hover').addClass('drop');
			        
			        var file = event.dataTransfer.files[0];

			  		var fd = new FormData();		        
	 				fd.append('file', file); 
	 				
					$.ajax({
						dataType: 'html',
					    url: this.opts.url,
					    data: fd,
					    //xhr: provider,
					    cache: false,
					    contentType: false,
					    processData: false,
					    type: 'POST',
					    success: function(data)
					    {
					    	if (this.opts.success !== false) this.opts.success(data);
					    	if (this.opts.preview === true) this.dropareabox.html(data);
					    }.bind2(this)
					});		   
			        
			  
			    }.bind2(this);				
			}
		},
		ondrag: function()
		{
			this.dropareabox.addClass('hover');
			return false;
		},
		ondragleave: function()
		{
			this.dropareabox.removeClass('hover'); 
			return false;
		}
	};

	
})(jQuery);


/* jQuery plugin textselect
 * version: 0.9
 * author: Josef Moravec, josef.moravec@gmail.com
 * updated: Imperavi 
 * 
 */
(function($){$.event.special.textselect={setup:function(data,namespaces)
{$(this).data("textselected",false);$(this).data("ttt",data);$(this).bind('mouseup',$.event.special.textselect.handler);},teardown:function(data)
{$(this).unbind('mouseup',$.event.special.textselect.handler);},handler:function(event)
{var data=$(this).data("ttt");var text=$.event.special.textselect.getSelectedText(data).toString();if(text!='')
{$(this).data("textselected",true);event.type="textselect";event.text=text;$.event.handle.apply(this,arguments);}},getSelectedText:function(data)
{var text='';var frame=$('#redactor_frame_'+data).get(0);if(frame.contentWindow.getSelection)text=frame.contentWindow.getSelection();else if(frame.contentWindow.document.getSelection) text=frame.contentWindow.document.getSelection();else if(frame.contentWindow.document.selection)text=frame.contentWindow.document.selection.createRange().text;return text;}}
$.event.special.textunselect={setup:function(data,namespaces){$(this).data("rttt",data);$(this).data("textselected",false);$(this).bind('mouseup',$.event.special.textunselect.handler);$(this).bind('keyup',$.event.special.textunselect.handlerKey)},teardown:function(data){$(this).unbind('mouseup',$.event.special.textunselect.handler);},handler:function(event){if($(this).data("textselected")){var data=$(this).data("rttt");var text=$.event.special.textselect.getSelectedText(data).toString();if(text==''){$(this).data("textselected",false);event.type="textunselect";$.event.handle.apply(this,arguments);}}},handlerKey:function(event){if($(this).data("textselected")){var data=$(this).data("rttt");var text=$.event.special.textselect.getSelectedText(data).toString();if((event.keyCode=27)&&(text=='')){$(this).data("textselected",false);event.type="textunselect";$.event.handle.apply(this,arguments);}}}}})(jQuery);


