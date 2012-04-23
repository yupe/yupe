/*
	editor v7.1.1
	
	In English http://imperavi.com/
	In Russian http://imperavi.ru/	
 
	Copyright (c) 2009-2011, Imperavi Ltd.
	Dual licensed under the MIT or GPL Version 2 licenses.
	
	Usage: $('#content').editor();	
*/

var isCtrl = false;
var editorActive = false;

var $table = false;
var $tbody = false;
var $thead = false;
var $current_tr = false;
var $current_td = false;

var deviceAndroid = "android";
var uagent = navigator.userAgent.toLowerCase();

// detect iOS and Android
function isiOS()
{
    return ((navigator.platform.indexOf("iPhone") != -1) || (navigator.platform.indexOf("iPod") != -1) || (navigator.platform.indexOf("iPad") != -1));
}

function detectAndroid()
{
   if (uagent.search(deviceAndroid) > -1) return true;
   else return false;
}

function detectAndroidWebKit()
{
   if (detectAndroid())
   {
		if (detectWebkit()) return true;
		else return false;
   }
   else return false;
}

function detectWebkit()
{
	if (uagent.search('webkit') > -1) return true;
	else return false;
}

// editor 
(function($){


	// Initialization	
	$.fn.editor = function(options)
	{				
		if (isiOS() || detectAndroid() || detectAndroidWebKit()) return false;

		var obj = new Construct(this, options);	
		
		obj.init();
		
		return obj;
	};
	
	// Options and variables	
	function Construct(el, options) {

		this.opts = $.extend({	
			air: false,
			toolbar: 'classic', // false, main, mini, air
			lang: 'ru', // ru, en, fr, ua, pt_br, pl		
			typo: '/typo.php',
			autosave: false, // false or url
			interval: 20, // seconds
			resize: true,
			visual: true,
			focus: false,
			image_upload: 'upload.php',
			imageUploadParams: '', // GET params
			imageUploadFunction: false, // callback function
			file_upload: 'file.php',	
			file_download: '/file.php?file=',		
			file_delete: '/file.php?delete=',	
			fileUploadFunction: false, // callback function
			
			autoclear: true,
			remove_classes: false,
			remove_styles: true,
			convert_links: true,	
			autoformat: true,
			init_clear: false,					
			overlay: true, // modal overlay
			path: '',
			pathCss: 'css/',
			css: ['blank.css']
		}, options);
		
		this.$el = $(el);
	};

	// Functionality
	Construct.prototype = {
	
		init: function()
		{
			this.cssUrl = Array();
			
			// get editor css path
			if (this.opts.path == '')
			{
				path = '';
				$("script").each(function(i,s)
				{
					if (s.src && s.src.match(/\/editor\.js/)) path = s.src.replace(/editor\.js/, '');
				});
				this.opts.path = path;
			}
			
			if (this.opts.pathCss.substr(0,1) != '/') this.opts.pathCss = this.opts.path + this.opts.pathCss;
			
			for (key in this.opts.css)
			{
				//if (!this.opts.css[key].hasOwnProperty(key)) continue;
				if (this.opts.css[key].substr(0,1) != '/') this.cssUrl[key] = this.opts.pathCss + this.opts.css[key];
				else this.cssUrl[key] = this.opts.css[key];
			}
			
			if (this.opts.air) this.opts.toolbar = 'air';
			
			// include lang and toolbar
			this.include();
					
			// sizes and id
	   		this.frameID = this.$el.attr('id');
	   		this.width = this.$el.css('width');
	   		this.height = this.$el.css('height'); 
	   		  		
	   		
	   		// modal overlay
	   		if ($('#editor_imp_modal_overlay').size() == 0)
	   		{
		   		this.overlay = $('<div id="editor_imp_modal_overlay" style="display: none;"></div>');
		   		$('body').prepend(this.overlay);
		   	}
	   		
	   		// create container
			this.box = $('<div id="imp_editor_box_' + this.frameID + '" style="width: ' + this.width + ';" class="imp_editor_box imp_editor_box"></div>');
		
			// air box
			if (this.opts.air)
			{
				this.air = $('<div id="imp_editor_air_' + this.frameID + '" class="editor_air" style="display: none;"></div>');
			}
			
	
	 		// create iframe
			this.frame = $('<iframe frameborder="0" marginheight="0" marginwidth="0" vspace="0" hspace="0" scrolling="auto"  id="imp_editor_frame_' + this.frameID + '" style="height: ' + this.height + ';" class="imp_editor_frame"></iframe>');
	   	
			this.$el.hide().tabby();	
					   	
	   	
			// append box and frame
			$(this.box).insertAfter(this.$el).append(this.frame).append(this.$el);

 			// toolbar
 			if (this.opts.toolbar !== false)
 			{										
		   		this.toolbar = $('<ul id="imp_editor_toolbar_' + this.frameID + '" class="imp_editor_toolbar"></ul>');
		   		
		   		if (this.opts.air)
		   		{
		   			$(this.air).append(this.toolbar);
		   			this.box.prepend(this.air);
		   		}
				else $(this.box).prepend(this.toolbar);
				
				this.buildToolbar();
			}
			

			// resizer
			if (this.opts.resize)
			{
				this.resizer = $('<div id="imp_editor_resize' + this.frameID + '" class="imp_editor_resize"><div></div></div>');
				$(this.box).append(this.resizer);
	
	           $(this.resizer).mousedown(function(e) { this.initResize(e) }.bind2(this));
			}
			
			
			// enable	
	   		this.enable(this.$el.val());

			$(this.doc).click(function() { this.hideAllDropDown() }.bind2(this));
			
			if (this.opts.autoclear)
			{
				$(this.doc).bind('paste', function(e)
				{ 
					 setTimeout(function () { this.clearWord(); }.bind2(this), 200);
				}.bind2(this));
			}

			// air enable
			this.enableAir();

			// doc events
			$(this.doc).keydown(function(e)
		    {
		        if (e.ctrlKey || e.metaKey) isCtrl = true;
		                
		        if (e.keyCode == 9) { this.execCommand('indent', false); return false; }
		        if (e.keyCode == 66 && isCtrl) { this.execCommand('bold', 'bold'); return false; }
		        if (e.keyCode == 73 && isCtrl) { this.execCommand('italic', 'italic'); return false; }	
		        

		        
		    }.bind2(this)).keyup(function(e)
		    {
				isCtrl = false;		
				
		        if (e.keyCode == 13)
		        {
			        $(this.doc).linkify();
			        return true;
		        }				
					        
				this.syncCode();	
					        	        
		    }.bind2(this));

			
			// autosave	
			if (this.opts.autosave)	
			{	
				setInterval(function()
				{
					var html = this.getHtml();
					$.post(this.opts.autosave, { data: html });

				}.bind2(this), this.opts.interval*1000);
				
			}		
			
			this.formSets();	

			// focus
			if (this.opts.focus) this.focus();   		 
		},
		
		/* 	
			API 
		*/
		setHtml: function(html)
		{
			this.doc.body.innerHTML = html;			
			this.docObserve();
		},
		getHtml: function(clear)
		{
			if (clear === true)  
			{
				this.paragraphise();

				var html = this.doc.body.innerHTML;
				html = this.preClear(html);			
				html = this.cleanWHtml(html);			
				return this.tidyUp(html);	
			}
			else return this.doc.body.innerHTML;
		},
		getCode: function(clear)
		{
			if (clear === true) 
			{
				var html = this.$el.val();
				html = this.preClear(html);			
				html = this.cleanWHtml(html);			
				return this.tidyUp(html);				
			}
			else return this.$el.val();
		},			
		focus: function()
		{
			if ($.browser.msie) $(this.frame).load(function() { $(this).get(0).contentWindow.focus(); });
			else this.frame.get(0).contentWindow.focus();
		},	
		typo: function()
		{
			var html = this.getHtml();
			$.ajax({
				url: this.opts.typo,
				type: 'post',
				data: 'editor=' + escape(encodeURIComponent(html)),
				success: function(data)
				{
					this.setHtml(data);
				}.bind2(this)
			});
		},	
		syncCode: function()
		{
			var html = this.getHtml();
			
			html = this.tidyUp(html);
			
			html = html.replace(/\%7B/gi, '{');
			html = html.replace(/\%7D/gi, '}');
	
			html = html.replace(/<hr class="editor_cut">/gi, '<!--more-->');
			html = html.replace(/<hr class=editor_cut>/gi, '<!--more-->');
	
			this.$el.val(html);
		},
		destroy: function()
		{
			var html = this.getCode();
			$(this.box).after(this.$el)
			this.box.remove();
			this.$el.val(html).show();
		},
		
		/*
			Include
		*/
		include: function()
		{
			// lang
			$('head').append($('<script type="text/javascript" src="' + this.opts.path + 'langs/' + this.opts.lang + '.js"></script>'));
			
			// include
			if (this.opts.toolbar !== false) $('head').append($('<script type="text/javascript" src="' + this.opts.path + 'toolbars/' + this.opts.toolbar + '.js"></script>')); 		
		},
		
		/* 	
			Enable 
		*/	
		enable: function(html)
		{				
	   		this.doc = this.contentDocumentFrame(this.frame);
	   		
			// flash replace
			html = html.replace(/\<object([\w\W]*?)\<\/object\>/gi, '<p class="editor_video_box"><object$1</object></p>');	   		
	   		
	   		if (html == '')
	   		{
	   			if (this.opts.autoformat === true) 
	   			{
	   				if ($.browser.msie) html = "<p></p>";
		   			else html = "<p>&nbsp;</p>";
		   		}
	   		}
	   		
			this.editorWrite(this.geteditorDoc(html));
			
			if (this.opts.init_clear) this.clearWord();
					
			
			this.designMode();		
		},
		enableAir: function()
		{
			if (this.opts.air)
			{	
				$('#imp_editor_air_' + this.frameID).hide();
				
				$(this.doc).bind('textselect', this.frameID, function(e)
				{
					$('#imp_editor_air_' + this.frameID).css({ left: e.clientX + 'px', top: (e.clientY + 8) + 'px' }).show();
					
				}.bind2(this));
				
				$(this.doc).bind('textunselect', this.frameID, function()
				{
					$('#imp_editor_air_' + this.frameID).hide();
					
				}.bind2(this)); 			
			}		
		},
		editorWrite: function(html)
		{
			this.doc.open();
			this.doc.write(html);
			this.doc.close();		
		},
		geteditorDoc: function(html)
		{		
			css = '';
			for (key in this.cssUrl)
			{
				css += '<link media="all" type="text/css" href="' + this.cssUrl[key] + '" rel="stylesheet">';
			}

	    	var frameHtml = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\n';
			frameHtml += '<html><head>' + css + '</head><body>';
			frameHtml += html;
			frameHtml += '</body></html>';
			return frameHtml;
		},	
		contentDocumentFrame: function(frame)
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
				this.frame.load(function()
				{ 				
					this.enableObjects();
					this.docObserve();			
	   				this.doc.designMode = 'on'; 
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
		
	
		/*
			Observers
		*/		
		docObserve: function()
		{
			var body = $(this.doc).find('body');
			
			body.find('img').click(function(e) { this.imageEdit(e); }.bind2(this));
			body.find('table').click(function(e) { this.tableObserver(e); }.bind2(this));
			body.find('.editor_file_link').click(function(e) { this.fileEdit(e); }.bind2(this));

		},		
				
		/*
			Format on submit form 
		*/
		formSets: function()
		{
			var oldOnsubmit = null;		
	
			var theForm = $(this.box).parents('form');
			if (theForm.length == 0) return false;
	
			oldOnsubmit = theForm.get(0).onsubmit;
	
			if (typeof theForm.get(0).onsubmit != "function")
			{
				theForm.get(0).onsubmit = function()
				{
	          		if (this.opts.visual)
					{
						this.syncCode();
						
						return true;
					}
				}.bind2(this)
			}
			else
			{
				theForm.get(0).onsubmit = function()
				{
	            	if (this.opts.visual)
					{
						this.syncCode();
	
						return oldOnsubmit();
					}
				}.bind2(this)
			}
	
			return true;
		},			
		
		/*
			Exec
		*/		
		execCommand: function(cmd, param)
		{		
			if (this.opts.visual)
			{
				if (this.doc)
				{
	    			try
		    		{
	    				this.frame.get(0).contentWindow.focus();
						
		    			if (cmd == 'inserthtml' && $.browser.msie) this.doc.selection.createRange().pasteHTML(param);
		    			else   			
						{											
							this.doc.execCommand(cmd, false, param);
							
							if (param == "blockquote" || param == 'pre')
							{
	    			    		this.doc.body.appendChild(this.doc.createElement("BR"));
						    }					
						}
					}
					catch (e) { }
					
					this.syncCode();		
				}
			}
		},						
		
		/*
			Format and clean
		*/	
		clearWord: function()
		{		
			this.paragraphise();

			var html = this.getHtml();

	

			html = this.preClear(html);			
			html = this.cleanWHtml(html);			
			html = this.tidyUp(html);	

			this.setHtml(html);
	
			return html;
		},	
		preClear: function(html)
		{
			// msie lowercase
			if ($.browser.msie) 
			{
				html = html.replace(/< *(\/ *)?(\w+)/g,function(w){return w.toLowerCase()});				
				html = html.replace(/ jQuery(.*?)=\"(.*?)\"/gi, '');
				
			}
			
			// prepend cleaning
			html = html.replace(/\<font(.*?)color="(.*?)"(.*?)>([\w\W]*?)\<\/font\>/gi, "<span style=\"color:$2;\">$4</span>");					
				
			var re= new RegExp('<font[^><]*>|<\/font[^><]*>','g')
			html = html.replace(re,'');

			// convert rgb to hex
			var matches = html.match(/rgb\((.*?)\)/gi);
			for (i in matches)
			{
				var hex = this.convertRGB(matches[i]);
				html = html.replace(matches[i], hex);
			}			

			if ($.browser.mozilla) html = this.convertSpan(html);
			
			return html;			
		},
		cleanWHtml: function(html)
		{
			var s = html.replace(/\r/g, '\n').replace(/\n/g, ' ');
					

			var rs = [];
			rs.push(/<!--.+?-->/g);
			rs.push(/<title>.+?<\/title>/g); 
			rs.push(/<(meta|link|.?o:|.?style|.?div|.?html|body|!\[)[^>]*?>/g); 
			rs.push(/ v:.*?=".*?"/g); 
			
			rs.push(/ class="Apple-style-span"/g); 
			rs.push(/ class="MsoNormal"/g); 
			rs.push(/ align="left"/g); 	
			rs.push(/ align="center"/g); 
			rs.push(/ align="left"/g); 			
			
			// remove styles
			if (this.opts.remove_styles) rs.push(/ style=".*?"/g); 

			// remove classes
			if (this.opts.remove_classes) rs.push(/ class=".*?"/g);
			
			rs.push(/(&nbsp;){2,}/g); 
			rs.push(/<p>(\s|&nbsp;)*?<\/p>/g);
			$.each(rs, function() {
			    s = s.replace(this, '');
			});
			
			s = s.replace(/\s+/g, ' ');
									
			return s;
		},
		tidyUp: function (html)
		{
			if (!$.browser.msie) 
			{
				html = html.replace(/\<p>&nbsp;([\w\W]*?)\<\/p\>/gi, "<p>$1</p>");	
				html = html.replace(/\<p>([\w\W]*?)&nbsp;\<\/p\>/gi, "<p>$1</p>");	
			}
			
			if (this.opts.convert_links) html = this.convertLinks(html);

			html = html.replace(/[\t]*/g, ''); 
			html = html.replace(/[\r\n]*/g, ''); 
			html = html.replace(/\n\s*\n/g, "\n"); 
			html = html.replace(/^[\s\n]*/, '');
			html = html.replace(/[\s\n]*$/, '');		
			
			var lb = '\r\n';
			var btags = ["<html","</html>","</head>","<title","</title>","<meta","<link","<style","</style>","</body>","<body","<head","<div","<p","<form","<fieldset","<label","</label>","<legend","</legend>","<object","</object>","<embed","</embed>","<select","</select>","<option","<option","<input","<textarea","</textarea>","</form>","</fieldset>","<br>","<br />","<hr","<pre","</pre>","<blockquote","</blockquote>","<ul","</ul>","<ol","</ol>","<li","<dl","</dl>","<dt","</dt>","<dd","</dd>","<\!--","<table","</table>","</thead>","<tbody","</tbody>","<caption","</caption>","<th","</th>","<tr","</tr>","<td","<script","</script>","<noscript","</noscript>"];
			for (i = 0; i < btags.length; ++i)
			{
				var bbb = btags[i];
				html = html.replace(new RegExp(bbb,'gi'),lb+bbb);
			}

			// indenting
			html = html.replace(/<li/g, "\t<li");
			html = html.replace(/<tr/g, "\t<tr");
			html = html.replace(/<td/g, "\t\t<td");		
			html = html.replace(/<\/tr>/g, "\t</tr>");	
			
			// empty tags
			var btags = ["<pre></pre>","<blockquote></blockquote>","<ul></ul>","<ol></ol>","<li></li>","<table></table>","<tr></tr>","<span><span>", "<p>&nbsp;</p>", "<p></p>", "<p><br></p>", "<div></div>"];
			for (i = 0; i < btags.length; ++i)
			{
				var bbb = btags[i];
				html = html.replace(new RegExp(bbb,'gi'), "");
			}
		
			return html;
		},
		
		convertLinks: function(html)
		{
			html = html.replace(/\<a(.*?)href="http:\/\/(.*?)"(.*?)>([\w\W]*?)\<\/a\>/gi, "<a$1href=\"rttp://$2\"$3>$4</a>");
			html = html.replace(/\<a(.*?)href="rttp:\/\/(.*?)"(.*?)>http:\/\/([\w\W]*?)\<\/a\>/gi, "<a$1href=\"rttp://$2\"$3>rttp:\/\/$4</a>");				

			//var url1 = /(^|>|\s)(www\..+?\..+?)(\s|<|$)/g;
			var url2 = /(^|>|\s)(((https?|ftp):\/\/|mailto:).+?)(\s|<|$)/g;

			//html = html.replace(url1, '$1<a href="http://$2">$2</a>$3')
			html = html.replace(url2, '$1<a href="$2">$2</a>$5');		

			html = html.replace(/\<a(.*?)href="rttp:\/\/(.*?)"(.*?)>([\w\W]*?)\<\/a\>/gi, "<a$1href=\"http://$2\"$3>$4</a>");
			html = html.replace(/\<a(.*?)href="http:\/\/(.*?)"(.*?)>rttp:\/\/([\w\W]*?)\<\/a\>/gi, "<a$1href=\"http://$2\"$3>http://$4</a>");
			
			return html;			
		},

		convertRGB: function(rgbString)
		{
			var parts = rgbString.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
			
			delete (parts[0]);
			for (var i = 1; i <= 3; ++i)
			{
			    parts[i] = parseInt(parts[i]).toString(16);
			    if (parts[i].length == 1) parts[i] = '0' + parts[i];
			}
			return '#' + parts.join('');
		},

		convertSpan: function(html)
		{
			html = html.replace(/\<span(.*?)style="font-weight: bold;"\>([\w\W]*?)\<\/span\>/gi, "<b>$2</b>");
			html = html.replace(/\<span(.*?)style="font-style: italic;"\>([\w\W]*?)\<\/span\>/gi, "<i>$2</i>");
			html = html.replace(/\<span(.*?)style="font-weight: bold; font-style: italic;"\>([\w\W]*?)\<\/span\>/gi, "<i><b>$2</b></i>");
			html = html.replace(/\<span(.*?)style="font-style: italic; font-weight: bold;"\>([\w\W]*?)\<\/span\>/gi, "<b><i>$2</i></b>");
	
			return html;
	  	},

		/*
			Paragraphise
		*/
		paragraphise: function()
		{

			if (this.opts.autoformat === false) return true;
			if (this.opts.visual)
			{
				var theBody = this.doc.body;
	
				/* Remove all text nodes containing just whitespace */
				for (var i = 0; i < theBody.childNodes.length; i++)
				{
					if (theBody.childNodes[i].nodeName.toLowerCase() == "#text" && theBody.childNodes[i].data.search(/^\s*$/) != -1)
					{
						theBody.removeChild(theBody.childNodes[i]);
						i--;
					}
				}
	
				var removedElements = new Array();
				for (var i = 0; i < theBody.childNodes.length; i++)
				{
					if (theBody.childNodes[i].nodeName.isInlineName())
					{
						removedElements.push(theBody.childNodes[i].cloneNode(true));
						theBody.removeChild(theBody.childNodes[i]);	
						i--;
					}
					else if (theBody.childNodes[i].nodeName.toLowerCase() == "br")
					{
						if (i + 1 < theBody.childNodes.length)
						{
							if (theBody.childNodes[i + 1].nodeName.toLowerCase() == "br")
							{
								while (i < theBody.childNodes.length && theBody.childNodes[i].nodeName.toLowerCase() == "br")
								{
									theBody.removeChild(theBody.childNodes[i]);
								}
	
								if (removedElements.length > 0)
								{
									this.insertNewParagraph(removedElements, theBody.childNodes[i]);
									removedElements = new Array();
								}
							}
							else if (!theBody.childNodes[i + 1].nodeName.isInlineName()) theBody.removeChild(theBody.childNodes[i]);
							else if (removedElements.length > 0)
							{
								removedElements.push(theBody.childNodes[i].cloneNode(true));	
								theBody.removeChild(theBody.childNodes[i]);
							}
							else theBody.removeChild(theBody.childNodes[i]);
							i--;
						}
						else theBody.removeChild(theBody.childNodes[i]);
					}
					else if (removedElements.length > 0)
					{
						this.insertNewParagraph(removedElements, theBody.childNodes[i]);
						removedElements = new Array();
					}
				}
	
				if (removedElements.length > 0) this.insertNewParagraph(removedElements);
			}
	
			return true;
		},
		insertNewParagraph: function(elementArray, succeedingElement)
		{
			var theBody = this.doc.getElementsByTagName("body")[0];
			var theParagraph = this.doc.createElement("p");
	
			for (var i = 0; i < elementArray.length; i++) theParagraph.appendChild(elementArray[i]);
	
			if (typeof(succeedingElement) != "undefined") theBody.insertBefore(theParagraph, succeedingElement);
			else theBody.appendChild(theParagraph);
	
			return true;
		},

		/*
			Selection
		*/			
		get_selection: function ()
		{
			if (this.frame.get(0).contentWindow.getSelection) return this.frame.get(0).contentWindow.getSelection();
			else if (this.frame.get(0).contentWindow.document.selection) return this.frame.contentWindow.get(0).document.selection.createRange();
		},				
		
		setCut: function()
		{
			this.execCommand('inserthtml', '<hr class="editor_cut" />');
		},		
		
		/*
			Toggle
		*/
		toggle: function()
		{
			if (this.opts.visual)
			{
				this.addSelButton('html');
				
				var html = this.clearWord();
	
				html = html.replace(/\%7B/gi, '{');
				html = html.replace(/\%7D/gi, '}');
	
				// flash replace
				html = html.replace(/<p(.*?)class="editor_video_box"(.*?)>([\w\W]*?)\<\/p>/gi, "$3");
		
				// files replace
				html = html.replace(/<a(.*?)rel="(.*?)"(.*?)class="editor_file_link(.*?)"(.*?)>([\w\W]*?)\<\/a>/gi, "<a href=\"" + this.opts.file_download +  "$2\" rel=\"$2\" class=\"editor_file_link$4\">$6</a>");

				// cut replace	
				html = html.replace(/<hr class="editor_cut"\/>/gi, '<!--more-->');
				html = html.replace(/<hr class=editor_cut>/gi, '<!--more-->');
		
		
				this.frame.hide();
				this.$el.val(html);
				this.$el.show().focus();
	
				var height = this.$el.height();
				
				this.opts.visual = false;
			}
			else
			{
				this.removeSelButton('html');
				this.$el.hide();
	
				var html = this.$el.val();
				
				// cut replace
				html = html.replace(/<!--more-->/gi, '<hr class="editor_cut"/>');
	
				// flash replace
				html = html.replace(/\<object([\w\W]*?)\<\/object\>/gi, '<p class="editor_video_box"><object$1</object></p>');
	
				// files replace	
				html = html.replace(/<a(.*?)href="(.*?)"(.*?)rel="(.*?)"(.*?)class="editor_file_link(.*?)">(.*?)<\/a>/gi, "<a href=\"javascript:void(null);\" rel=\"$4\" class=\"editor_file_link$6\">$7</a>");

					
				this.opts.visual = true;
	
				this.setHtml(html);
				
				this.frame.show();
				this.focus();
			}
		},	
		
		
		/*
			Video
		*/
		showVideo: function()
		{
			editorActive = this;
			this.modalInit(RLANG.video, this.opts.path + 'plugins/video.html', 600, 360, function()
			{
				$('#editor_insert_video_area').focus();			
			});
		},	
		insertVideo: function()
		{
			var data = $('#editor_insert_video_area').val();
			if (editorActive.opts.visual) 
			{
				// iframe video
				if (data.search('iframe')) {}
				// flash
				else data = '<p class="editor_video_box">' + data + '</p>';
			}
	
			editorActive.execCommand('inserthtml', data);
			this.modalClose();
			
		},	

	
		
		/*
			File
		*/
		showFile: function()
		{
			editorActive = this;
			
            var handler = function()
            {
                var params = '';

                if (this.opts.fileUploadFunction) var params = this.opts.fileUploadFunction();
                this.uploadInit('editorUploadFileForm', { url: this.opts.file_upload + params, trigger: 'editorUploadBtn', success: function(data) {
                    this.fileUploadCallback(data);
                }.bind2(this)  });           

            }.bind2(this);
            
        
            editorActive = this;
			this.modalInit(RLANG.file, this.opts.path + 'plugins/file.html', 400, 200, handler);
		},	
		fileUploadCallback: function(data)
		{
			editorActive.frame.get(0).contentWindow.focus();
			editorActive.execCommand('inserthtml', data);
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
				$('#editorFileDeleteBtn').click(function()
				{
					this.fileDelete(el, file_id);					
				}.bind2(this));
				
				$('#editorFileDownloadBtn').click(function()
				{				
					this.fileDownload(el, file_id);
				}.bind2(this));
			
			}.bind2(this);
			
			editorActive = this;
			this.modalInit(RLANG.file, this.opts.path + 'plugins/file_edit.html', 400, 200, handler);
		},
		fileDelete: function(el, file_id)
		{
			$(el).remove();
			$.get(this.opts.file_delete + file_id);
			editorActive.frame.get(0).contentWindow.focus();
			this.modalClose();				
		},
		fileDownload: function(el, file_id)
		{
			top.location.href = this.opts.file_download + file_id;				
		},		

  		/*
            Table
        */
        showTable: function()
        {       
            editorActive = this;
            this.modalInit(RLANG.table, this.opts.path + 'plugins/table.html', 360, 200);
        },
        insertTable: function()
        {           
            var rows = $('#editor_table_rows').val();
            var columns = $('#editor_table_columns').val();
            
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
 			else  html += '<p>&nbsp;</p>';           
                        
            editorActive.execCommand('inserthtml', html);            
   			this.enableObjects();
            this.docObserve();          
            this.modalClose();
            
            $table = $(this.doc).find('body').find('#table' + tableid);
    
            
        },
		tableObserver: function(e)
		{
			$table = $(e.target).parents('table');

			$tbody = $(e.target).parents('tbody');
			$thead = $($table).find('thead');

			$current_td = $(e.target);
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
			var index = $($current_td).attr('cellIndex');
            
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
            var index = $($current_td).attr('cellIndex');
            
			$($table).find('tr').each(function(i,s)
			{   
			    var current = $(s).find('td').eq(index);    
			    var td = current.clone();   
			    td.html('&nbsp;');
			    if (type == 'after') $(current).after(td);
			    else $(current).before(td);			    
			});			
		},
    
        /*
            Image
        */  
        imageEdit: function(e)
        {
            var handler = function()
            {
                var $el = $(e.target);
                var src = $el.attr('src');      
                $('#editor_image_edit_src').attr('href', src);
                $('#editor_image_edit_delete').click(function() { this.deleteImage(e.target);  }.bind2(this));
                $('#editorSaveBtn').click(function() { this.imageSave(e.target);  }.bind2(this));

                $('#editor_file_alt').val($el.attr('alt'));
                
                var float = $el.css('float');
                if (float == 'none') float = 0;
                
                $('#editor_form_image_align').val(float);

            }.bind2(this);       
        
            editorActive = this;      
            this.modalInit(RLANG.image, this.opts.path + 'plugins/image_edit.html', 380, 290, handler);
        },
        imageSave: function(el)
        {
            $(el).attr('alt', $('#editor_file_alt').val());
    
            var style = '';
            if ($('#editor_form_image_align') != 0)
            {
                var float = $('#editor_form_image_align').val();
                
                if (float == 'left') $(el).css({ float: 'left', margin: '10px' });
                else if (float == 'right') $(el).css({ float: 'right', margin: '10px' });
            }
            else $(el).css({ float: 'none', margin: '0' });

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
            if (jQuery.browser.msie)
            {
                this.execCommand('inserthtml', '<span id="span' + this.spanid + '"></span>');
            }
            
            var handler = function()
            {
                var params = '';

                if (this.opts.imageUploadFunction) var params = this.opts.imageUploadFunction();
                this.uploadInit('editorInsertImageForm', { url: this.opts.image_upload + params, trigger: 'editorUploadBtn', success: function(data) {
                    this.imageUploadCallback(data);
                }.bind2(this)  });           

            }.bind2(this);
            
        
            editorActive = this;
            this.modalInit(RLANG.image, this.opts.path + 'plugins/image.html', 450, 330, handler);
        },
        imageUploadCallback: function(data)
        {
            if ($('#editor_file_link').val() != '') data = $('#editor_file_link').val();
            var alt = $('#editor_file_alt').val();
    
            var className = '';
            if ($('#editor_form_image_align') != 0)
            {
                var float = $('#editor_form_image_align').val();
                
                if (float == 'left') className = 'class=="img_left"';
                else if (float == 'right') className = 'class="img_right"';
                
                var html = '<img alt="' + alt + '" src="' + data + '" ' + className + ' />';
            }
            else
            {
                var html = '<p><img alt="' + alt + '" src="' + data + '" /></p>'; 
            }
        
            editorActive.frame.get(0).contentWindow.focus();
            
            if ($.browser.msie)
            {       
                $(editorActive.doc.getElementById('span' + editorActive.spanid)).after(html);
                $(editorActive.doc.getElementById('span' + editorActive.spanid)).remove();
            }   
            else
            {
                editorActive.execCommand('inserthtml', html);
            }
    
            this.modalClose();
            this.docObserve();          
    
        },              
        				
	
		/*
			Link
		*/				
		showLink: function()
		{
			editorActive = this;

			var handler = function()
			{
				var sel = this.get_selection();
				if ($.browser.msie)
				{
						var temp = sel.htmlText.match(/href="(.*?)"/gi);
						if (temp != null)
						{
							temp = new String(temp);
							temp = temp.replace(/href="(.*?)"/gi, '$1');
						}

  					 	var text = sel.text;
						if (temp != null) var url = temp;
						else  var url = '';
						var title = '';
				}
				else
				{
					if (sel.anchorNode.parentNode.tagName == 'A')
					{
						var url = sel.anchorNode.parentNode.href;
						var text = sel.anchorNode.parentNode.text;
						var title = sel.anchorNode.parentNode.title;
						if (sel.toString() == '') this.insert_link_node = sel.anchorNode.parentNode

					}
					else
					{
					 	var text = sel.toString();
						var url = '';
						var title = '';
					}
				}

				$('#editor_link_url').val(url).focus();
				$('#editor_link_text').val(text);
				$('#editor_link_title').val(title);	
						
			}.bind2(this);

			this.modalInit(RLANG.link, this.opts.path + 'plugins/link.html', 400, 300, handler);
	
		},	
		insertLink: function()
		{
			var value = $('#editor_link_text').val();
			if (value == '') return true;
			
			var title = $('#editor_link_title').val();
			if (title != '') title = ' title="' + $('#editor_link_title').val() + '"';			
			
			if ($('#editor_link_id_url').get(0).checked)  var mailto = '';
			else var mailto = 'mailto:';
			
			var a = '<a href="' + mailto + $('#editor_link_url').val() + '"' + title +'>' + value + '</a> ';
	
			if (a)
			{
				if (this.insert_link_node)
				{
					$(this.insert_link_node).text(value);
					$(this.insert_link_node).attr('href', $('#editor_link_url').val());
					
					var title = $('#editor_link_title').val();
					if (title != '') $(this.insert_link_node).attr('title', title);
	
					this.modalClose();
				}
				else
				{
					editorActive.frame.get(0).contentWindow.focus();
					editorActive.execCommand('inserthtml', a);
				}
			}
			
			this.modalClose();
		},	
		

		/*
			Modal
		*/
		modalInit: function(title, url, width, height, handler, scroll)
		{
			if (this.opts.overlay) 
			{
				$('#editor_imp_modal_overlay').show();
				$('#editor_imp_modal_overlay').click(function() { this.modalClose(); }.bind2(this));
			}
			
			if ($('#editor_imp_modal').size() == 0)
			{
				this.modal = $('<div id="editor_imp_modal" style="display: none;"><div id="editor_imp_modal_close"></div><div id="editor_imp_modal_header"></div><div id="editor_imp_modal_inner"></div></div>');
				$('body').append(this.modal);
			}
			
			$('#editor_imp_modal_close').click(function() { this.modalClose(); }.bind2(this));
			$(document).keyup(function(e) { if( e.keyCode == 27) this.modalClose(); }.bind2(this));
			$(this.doc).keyup(function(e) { if( e.keyCode == 27) this.modalClose(); }.bind2(this));			

			$.ajax({
				url: url,
				success: function(data)
				{		

					// parse lang
					$.each(RLANG, function(i,s)
					{
						var re = new RegExp("%RLANG\." + i + "%","gi");
						data = data.replace(re, s);						
					});
					
					$('#editor_imp_modal_inner').html(data);
					$('#editor_imp_modal_header').html(title);
					
					if (height === false) theight = 'auto';
					else theight = height + 'px';
					
					$('#editor_imp_modal').css({ width: width + 'px', height: theight, marginTop: '-' + height/2 + 'px', marginLeft: '-' + width/2 + 'px' }).fadeIn('fast');					

					if (scroll === true)
					{					
						$('#imp_editor_table_box').height(height-$('#editor_imp_modal_header').outerHeight()-130).css('overflow', 'auto');						
					}
					
					if (typeof(handler) == 'function') handler();
				}.bind2(this)
			});
		},
		modalClose: function()
		{

			$('#editor_imp_modal_close').unbind('click', function() { this.modalClose(); }.bind2(this));
			$('#editor_imp_modal').fadeOut('fast', function()
			{
				$('#editor_imp_modal_inner').html('');			
				
				if (this.opts.overlay) 
				{
					$('#editor_imp_modal_overlay').hide();		
					$('#editor_imp_modal_overlay').unbind('click', function() { this.modalClose(); }.bind2(this));					
				}			
				
				$(document).unbind('keyup', function(e) { if( e.keyCode == 27) this.modalClose(); }.bind2(this));
				$(this.doc).unbind('keyup', function(e) { if( e.keyCode == 27) this.modalClose(); }.bind2(this));
				
			}.bind2(this));

		},
				
        /*
            Upload
        */  
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
                this.element.submit(function(e) { return false; });
                this.uploadSubmit();
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
                var formId = 'editorUploadForm' + this.id;
                var fileId = 'editorUploadFile' + this.id;
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
	
		/*
			Toolbar
		*/
		buildToolbar: function()
		{	
			$.each(RTOOLBAR, 
	   			function (i, s)
	   			{
	   				if (s.name == 'separator')
	   				{
						var li = $('<li class="separator"></li>');
		   				$(this.toolbar).append(li);	   			
	   				}
	   				else
	   				{
	   			
						var a = $('<a href="javascript:void(null);" class="imp_btn imp_btn_' + s.name + '" title="' + s.title + '"></a>');
						
						if (typeof(s.func) == 'undefined') a.click(function() { this.execCommand(s.exec, s.name); }.bind2(this));
						else if (s.func != 'show') a.click(function(e) { this[s.func](e); }.bind2(this));
						
						var li = $('<li class="imp_li_btn imp_li_btn_' + s.name + '"></li>');
						$(li).append(a);   						   						
		   				$(this.toolbar).append(li);
	
						// build dropdown box
						if (s.name == 'backcolor' || s.name == 'fontcolor' || typeof(s.dropdown) != 'undefined')
						{
							var ul = $('<ul class="imp_editor_drop_down imp_editor_drop_down' + this.frameID + '" id="imp_editor_drop_down' + this.frameID + '_' + s.name + '" style="display: none;"></ul>');
							if ($.browser.msie) ul.css({ borderLeft: '1px solid #ddd',  borderRight: '1px solid #ddd',  borderBottom: '1px solid #ddd' });
						}
	
						// build dropdown
						if (typeof(s.dropdown) != 'undefined')
						{
										
							$.each(s.dropdown,
		   						function (x, d)
								{
									if (typeof(d.style) == 'undefined') d.style = '';
									
									if (d.name == 'separator')
					   				{
										var ul_li = $('<li class="separator_drop"></li>');
										$(ul).append(ul_li);
						   			}
						   			else
						   			{
														
										var ul_li = $('<li></li>');
										var ul_li_a = $('<a href="javascript:void(null);" style="' + d.style + '">' + d.title + '</a>');
										$(ul_li).append(ul_li_a); 
										$(ul).append(ul_li);
										
										if (typeof(d.func) == 'undefined') $(ul_li_a).click(function() { this.execCommand(d.exec, d.name); }.bind2(this));
										else $(ul_li_a).click(function(e) { this[d.func](e); }.bind2(this));										
									}
									
								
									  									
								}.bind2(this)
							);
						}
						else a.mouseover(function() { this.hideAllDropDown() }.bind2(this));	
						
						// observing dropdown
						if (s.name == 'backcolor' || s.name == 'fontcolor' || typeof(s.dropdown) != 'undefined')
						{
							$('#imp_editor_toolbar_' + this.frameID).after(ul);
			
							this.hdlHideDropDown = function(e) { this.hideDropDown(e, ul, s.name) }.bind2(this);
							this.hdlShowDropDown = function(e) { this.showDropDown(e, ul, s.name) }.bind2(this);
							this.hdlShowerDropDown = function(e) { this.showerDropDown(e, ul, s.name) }.bind2(this);   	
	
							a.click(this.hdlShowDropDown).mouseover(this.hdlShowerDropDown);  							
	
							$(document).click(this.hdlHideDropDown);							
						}
						
						
					}
	   			}.bind2(this)
	   		);		
		},
		
		/*
			DropDown
		*/
		showedDropDown: false,
		showDropDown: function(e, ul, name)
		{
		
			if (this.showedDropDown) this.hideAllDropDown();
			else
			{
				this.showedDropDown = true;
				this.showingDropDown(e, ul, name);
			}		
				
		},
		showingDropDown: function(e, ul, name)
		{
			this.hideAllDropDown();			 	
	   		this.addSelButton(name);
	   		
			var left = $('#imp_editor_toolbar_' + this.frameID + ' li.imp_li_btn_' + name).position().left;
			$(ul).css('left', left + 'px').show();	   		
		},
		showerDropDown: function(e, ul, name)
		{
			if (this.showedDropDown) this.showingDropDown(e, ul, name);
		},
		hideAllDropDown: function()
		{
			$('#imp_editor_toolbar_' + this.frameID + ' li.imp_li_btn').removeClass('act');
	   		$('ul.imp_editor_drop_down' + this.frameID).hide();
		},
		hideDropDown: function(e, ul, name)
		{
			if (!$(e.target).parent().hasClass('act'))
			{
				this.showedDropDown = false;
				this.hideAllDropDown();
			}	

			$(document).unbind('click', this.hdlHideDropDown);
			$(this.doc).unbind('click', this.hdlHideDropDown);
			
		},
		addSelButton: function(name)
		{
			var element = $('#imp_editor_toolbar_' + this.frameID + ' li.imp_li_btn_' + name);
			element.addClass('act');
		},
		removeSelButton: function(name)
		{
			var element = $('#imp_editor_toolbar_' + this.frameID + ' li.imp_li_btn_' + name);
			element.removeClass('act');
		},	
		toggleSelButton: function(name)
		{
			$('#imp_editor_toolbar_' + this.frameID + ' li.imp_li_btn_' + name).toggleClass('act');
		},
			
	
		/*
			Resizer
		*/
		initResize: function(e)
		{	
			if (e.preventDefault) e.preventDefault();
			else e.returnValue = false;
			
			this.splitter = e.target;
	
			if (this.opts.visual)
			{
				this.element_resize = this.frame;
				this.element_resize.get(0).style.visibility = 'hidden';
				this.element_resize_parent = this.$el;
			}
			else
			{
				this.element_resize = this.$el;
				this.element_resize_parent = this.frame;
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
			else e.returnValue = false;
			
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
		}
			
	};


	String.prototype.isInlineName = function()
	{
		var inlineList = new Array("#text", "a", "em", "font", "span", "strong", "u");
		var theName = this.toLowerCase();
		
		for (var i = 0; i < inlineList.length; i++)
		{
			if (theName == inlineList[i])
			{
				return true;
			}
		}
		
		return false;
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


/*
 *	Tabby jQuery plugin version 0.12
 *
 *	Ted Devito - http://teddevito.com/demos/textarea.html
 *
 *	Copyright (c) 2009 Ted Devito
 *	 
 *	Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following 
 *	conditions are met:
 *	
 *		1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 *		2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer  
 *			in the documentation and/or other materials provided with the distribution.
 *		3. The name of the author may not be used to endorse or promote products derived from this software without specific prior written 
 *			permission. 
 *	 
 *	THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 *	IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE AUTHOR BE 
 *	LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, 
 *	PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY 
 *	THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT 
 *	OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */
(function($){$.fn.tabby=function(options){var opts=$.extend({},$.fn.tabby.defaults,options);var pressed=$.fn.tabby.pressed;return this.each(function(){$this=$(this);var options=$.meta?$.extend({},opts,$this.data()):opts;$this.bind('keydown',function(e){var kc=$.fn.tabby.catch_kc(e);if(16==kc)pressed.shft=true;if(17==kc){pressed.ctrl=true;setTimeout("$.fn.tabby.pressed.ctrl = false;",1000);}
if(18==kc){pressed.alt=true;setTimeout("$.fn.tabby.pressed.alt = false;",1000);}
if(9==kc&&!pressed.ctrl&&!pressed.alt){e.preventDefault;pressed.last=kc;setTimeout("$.fn.tabby.pressed.last = null;",0);process_keypress($(e.target).get(0),pressed.shft,options);return false;}}).bind('keyup',function(e){if(16==$.fn.tabby.catch_kc(e))pressed.shft=false;}).bind('blur',function(e){if(9==pressed.last)$(e.target).one('focus',function(e){pressed.last=null;}).get(0).focus();});});};$.fn.tabby.catch_kc=function(e){return e.keyCode?e.keyCode:e.charCode?e.charCode:e.which;};$.fn.tabby.pressed={shft:false,ctrl:false,alt:false,last:null};function debug($obj){if(window.console&&window.console.log)
window.console.log('textarea count: '+$obj.size());};function process_keypress(o,shft,options){var scrollTo=o.scrollTop;if(o.setSelectionRange)gecko_tab(o,shft,options);else if(document.selection)ie_tab(o,shft,options);o.scrollTop=scrollTo;}
$.fn.tabby.defaults={tabString:String.fromCharCode(9)};function gecko_tab(o,shft,options){var ss=o.selectionStart;var es=o.selectionEnd;if(ss==es){if(shft){if("\t"==o.value.substring(ss-options.tabString.length,ss)){o.value=o.value.substring(0,ss-options.tabString.length)+o.value.substring(ss);o.focus();o.setSelectionRange(ss-options.tabString.length,ss-options.tabString.length);}
else if("\t"==o.value.substring(ss,ss+options.tabString.length)){o.value=o.value.substring(0,ss)+o.value.substring(ss+options.tabString.length);o.focus();o.setSelectionRange(ss,ss);}}
else{o.value=o.value.substring(0,ss)+options.tabString+o.value.substring(ss);o.focus();o.setSelectionRange(ss+options.tabString.length,ss+options.tabString.length);}}
else{var lines=o.value.split("\n");var indices=new Array();var sl=0;var el=0;var sel=false;for(var i in lines){el=sl+lines[i].length;indices.push({start:sl,end:el,selected:(sl<=ss&&el>ss)||(el>=es&&sl<es)||(sl>ss&&el<es)});sl=el+1;}
var modifier=0;for(var i in indices){if(indices[i].selected){var pos=indices[i].start+modifier;if(shft&&options.tabString==o.value.substring(pos,pos+options.tabString.length)){o.value=o.value.substring(0,pos)+o.value.substring(pos+options.tabString.length);modifier-=options.tabString.length;}
else if(!shft){o.value=o.value.substring(0,pos)+options.tabString+o.value.substring(pos);modifier+=options.tabString.length;}}}
o.focus();var ns=ss+((modifier>0)?options.tabString.length:(modifier<0)?-options.tabString.length:0);var ne=es+modifier;o.setSelectionRange(ns,ne);}}
function ie_tab(o,shft,options){var range=document.selection.createRange();if(o==range.parentElement()){if(''==range.text){if(shft){var bookmark=range.getBookmark();range.moveStart('character',-options.tabString.length);if(options.tabString==range.text){range.text='';}else{range.moveToBookmark(bookmark);range.moveEnd('character',options.tabString.length);if(options.tabString==range.text)
range.text='';}
range.collapse(true);range.select();}
else{range.text=options.tabString;range.collapse(false);range.select();}}
else{var selection_text=range.text;var selection_len=selection_text.length;var selection_arr=selection_text.split("\r\n");var before_range=document.body.createTextRange();before_range.moveToElementText(o);before_range.setEndPoint("EndToStart",range);var before_text=before_range.text;var before_arr=before_text.split("\r\n");var before_len=before_text.length;var after_range=document.body.createTextRange();after_range.moveToElementText(o);after_range.setEndPoint("StartToEnd",range);var after_text=after_range.text;var end_range=document.body.createTextRange();end_range.moveToElementText(o);end_range.setEndPoint("StartToEnd",before_range);var end_text=end_range.text;var check_html=$(o).html();$("#r3").text(before_len+" + "+selection_len+" + "+after_text.length+" = "+check_html.length);if((before_len+end_text.length)<check_html.length){before_arr.push("");before_len+=2;if(shft&&options.tabString==selection_arr[0].substring(0,options.tabString.length))
selection_arr[0]=selection_arr[0].substring(options.tabString.length);else if(!shft)selection_arr[0]=options.tabString+selection_arr[0];}else{if(shft&&options.tabString==before_arr[before_arr.length-1].substring(0,options.tabString.length))
before_arr[before_arr.length-1]=before_arr[before_arr.length-1].substring(options.tabString.length);else if(!shft)before_arr[before_arr.length-1]=options.tabString+before_arr[before_arr.length-1];}
for(var i=1;i<selection_arr.length;i++){if(shft&&options.tabString==selection_arr[i].substring(0,options.tabString.length))
selection_arr[i]=selection_arr[i].substring(options.tabString.length);else if(!shft)selection_arr[i]=options.tabString+selection_arr[i];}
if(1==before_arr.length&&0==before_len){if(shft&&options.tabString==selection_arr[0].substring(0,options.tabString.length))
selection_arr[0]=selection_arr[0].substring(options.tabString.length);else if(!shft)selection_arr[0]=options.tabString+selection_arr[0];}
if((before_len+selection_len+after_text.length)<check_html.length){selection_arr.push("");selection_len+=2;}
before_range.text=before_arr.join("\r\n");range.text=selection_arr.join("\r\n");var new_range=document.body.createTextRange();new_range.moveToElementText(o);if(0<before_len)new_range.setEndPoint("StartToEnd",before_range);else new_range.setEndPoint("StartToStart",before_range);new_range.setEndPoint("EndToEnd",range);new_range.select();}}}})(jQuery);

// Define: Linkify plugin from stackoverflow
(function($){

 // var url1 = /(^|&lt;|\s)(www\..+?\..+?)(\s|&gt;|$)/g,
     var url2 = /(^|&lt;|\s)(((https?|ftp):\/\/|mailto:).+?)(\s|&gt;|$)/g;

      linkifyThis = function () {
        var childNodes = this.childNodes,
            i = childNodes.length;
        while(i--)
        {
          var n = childNodes[i];
          if (n.nodeType == 3) {
            var html = $.trim(n.nodeValue);
            if (html)
            {
              html = html.replace(/&/g, '&amp;')
                         .replace(/</g, '&lt;')
                         .replace(/>/g, '&gt;')
                         //.replace(url1, '$1<a href="http://$2">$2</a>$3')
                         .replace(url2, '$1<a href="$2">$2</a>$5');
              $(n).after(html).remove();
            }
          }
          else if (n.nodeType == 1  &&  !/^(a|button|textarea)$/i.test(n.tagName)) {
            linkifyThis.call(n);
          }
        }
      };

  $.fn.linkify = function () {
    	this.each(linkifyThis);
  };

})(jQuery);


/* jQuery plugin textselect
 * version: 0.9
 * tested on jQuery 1.3.2
 * author: Josef Moravec, josef.moravec@gmail.com
 * updated: Imperavi Ltd. 
 * 
 */

(function($){$.event.special.textselect={setup:function(data,namespaces)
{$(this).data("textselected",false);$(this).data("ttt",data);$(this).bind('mouseup',$.event.special.textselect.handler);},teardown:function(data)
{$(this).unbind('mouseup',$.event.special.textselect.handler);},handler:function(event)
{var data=$(this).data("ttt");var text=$.event.special.textselect.getSelectedText(data).toString();if(text!='')
{$(this).data("textselected",true);event.type="textselect";event.text=text;$.event.handle.apply(this,arguments);}},getSelectedText:function(data)
{var text='';var frame=$('#imp_editor_frame_'+data).get(0);if(frame.contentWindow.getSelection)text=frame.contentWindow.getSelection();else if(frame.contentWindow.document.getSelection) text=frame.contentWindow.document.getSelection();else if(frame.contentWindow.document.selection)text=frame.contentWindow.document.selection.createRange().text;return text;}}
$.event.special.textunselect={setup:function(data,namespaces){$(this).data("rttt",data);$(this).data("textselected",false);$(this).bind('mouseup',$.event.special.textunselect.handler);$(this).bind('keyup',$.event.special.textunselect.handlerKey)},teardown:function(data){$(this).unbind('mouseup',$.event.special.textunselect.handler);},handler:function(event){if($(this).data("textselected")){var data=$(this).data("rttt");var text=$.event.special.textselect.getSelectedText(data).toString();if(text==''){$(this).data("textselected",false);event.type="textunselect";$.event.handle.apply(this,arguments);}}},handlerKey:function(event){if($(this).data("textselected")){var data=$(this).data("rttt");var text=$.event.special.textselect.getSelectedText(data).toString();if((event.keyCode=27)&&(text=='')){$(this).data("textselected",false);event.type="textunselect";$.event.handle.apply(this,arguments);}}}}})(jQuery);

