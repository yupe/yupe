(function($, window, undefined){
    
    $.fn.tagger = function(options){
        
        /**
         * @returns {Boolean} true if value is the option separator
         * @param {Object} opts plugin options
         * @param {int} value test keycode to check if is a separator
         */
        function isCodeSeparator(opts, value){
            return opts.separator.charCodeAt(0) == value;
        }
		
		/**
         * @returns {Boolean} true if value is the option separator
         * @param {Object} opts plugin options
         * @param {String} value test char to check if is a separator
         */
        function isSeparator(opts, value){
            return opts.separator.charAt(0) == value.charAt(0);
        }
        
        /**
         * @returns {boolean} true if the tag is accepted by regex. If not regex defined, then also returns true.
         * @param {String} lastValue last string readed to try to convert to tag
         * @param {Object} opts options of the plugin
         */
        function isValidTag(lastValue, opts){
            if(opts.acceptedTagRegex != undefined)
                return opts.acceptedTagRegex.test(lastValue);
            else
                if(opts.rejectedTagRegex != undefined)
                    return !opts.rejectedTagRegex.test(lastValue);
                else return true;
        }
        
        /**
         * @returns {void} nothing
         * @param {String} lastValue string with the new tag label
         * @param {Object} opts plugin options
         * @param {jQuery Object} $cur input object to apply tagger
         * @param {Input Hidden Element} $hidden object to manage the submit
         */
        function addTag(lastValue, opts, $cur, $hidden){
            
            // Check if limit is reached
            if(opts.limit == undefined || $cur.parent().find("span." + opts.tagClass).length < opts.limit){
                
                // Check if it got a valid last value
                if(lastValue != undefined && lastValue != ""){
                    
                    // Check if the new string fits in the given RegExp in the configuration of the plugin
                    if(isValidTag(lastValue, opts)){
                        // Create the close element
                        var $close = $("<a class='" + opts.closeClass + "'>" + opts.closeChar + "</a>").click(function(){
                            $(this).parent().remove();
                            
                            // When removing, don't forget to remove the entry in the hidden
                            $hidden.val($hidden.val().replace(lastValue + ",", ""))
                        });
                        
                        // Generate colors (if needed)
                        var colors = undefined, styleString = "";
                        if(opts.useColorFunction)
                            colors = opts.colorFunction(lastValue);
                            
                        // Add the tag
                        var $tag = $("<span class='" + opts.tagClass + "'>" + lastValue + "</span>").append($close);
                        if(colors != undefined)
                            $tag.css({"color":colors.font, "background-color":colors.background});
                        $tag.insertBefore($cur);
                        
                        // Update hidden
                        $cur.next().val(lastValue + opts.separator + $cur.next().val());
                        
                        // Callback
                        opts.tagPlacedCallback($tag, lastValue);
                    }
                    else{
                        
                        // Rejected callback
                        opts.rejectedTagCallback($cur, lastValue);
                    }
                    
                }
            }
			else{
				opts.limitReachedCallback();
			}
        }
        
        // Options merge
        var opts = $.extend({}, $.fn.tagger.defaults, options);
        
        /**
         * Chainability
         */
        return this.each(function(){
            
            // Format input
            var $input = $(this); var iName = $input.attr("name");$input.attr("name", "tagger_old_" + iName);
            
            // Create hidden replace
            var $hidden = $("<input type='hidden' name='" + iName + "' />")
            
            // Fill new container
            var $inputContainer = $("<div class='" + opts.taggerWrapperClass + "'></div>");
            $inputContainer.css("width", opts.width);
            $input.replaceWith($inputContainer);$inputContainer.append($input).append($hidden);
            $inputContainer.click(function(){$input.focus();})
            
            // Initial state
            var ivalue = $input.val();
            var buffer = "";
            for(var i = 0; i< ivalue.length; i++){
                if(isSeparator(opts, ivalue.charAt(i))){
                    
                    // Add tag
                    buffer = $.trim(buffer);
                    addTag(buffer, opts, $input, $hidden);
					buffer = "";
                    
                }
                else{
					buffer += ivalue.charAt(i);
					
					// Last char
					if(i == ivalue.length - 1){
						// Add tag
						buffer = $.trim(buffer);
						addTag(buffer, opts, $input, $hidden);
						buffer = "";
					}
                }
            }
			$input.val("");
            for(var i = 0; i < opts.startWith.length; i++)addTag(opts.startWith[i], opts, $input, $hidden);
            
            // Keydown event over the current input
            var clr = false;
            $input.keypress(function(event){
                
                // Input
                var $cur = $(this);
                
                // If a separator is detected
                if(isCodeSeparator(opts, event.which)){
                    
                    // Get last value
                    var lastValue = $.trim($(this).val());
                    lastValue = lastValue.substr(0, lastValue.length);
                     
                    // Add tag
                    addTag(lastValue, opts, $cur, $hidden);
                    
                    // Clear input
                    $cur.val("");
                    return false;
                }
                return true;
            });
			
			// To manage delete and enter
			$input.keydown(function(event){
				// Delete
				if(event.which == 8){
					if($.trim($(this).val()) != "")
						return true;
					if($(this).prev().length > 0){
						$rtag = $(this).prev().find("a").trigger("click");
					}
					return false;
				}
				// Enter
				if(event.which == 13){
					// Get last value
                    var lastValue = $.trim($(this).val());
                    lastValue = lastValue.substr(0, lastValue.length);
                     
                    // Add tag
                    addTag(lastValue, opts, $(this), $hidden);
                    
                    // Clear input
                    $(this).val("");
                    return false;
					
				}
				return true;
			});
			
			// Behaviour on lost focus
			$input.focusout(function(event){
				// Get last value
				var lastValue = $.trim($(this).val());
				lastValue = lastValue.substr(0, lastValue.length);
				 
				// Add tag
				addTag(lastValue, opts, $(this), $hidden);
				
				// Clear input 
				$(this).val("");
			});
        })
    }
    
    // Configuration defaults
    $.fn.tagger.defaults = {
        separator: ",", // Separator used to generate tags
        width: "100%",
        useColorFunction: true, // Indicates if is used a coloring function to color tags
        colorFunction: function(label){return {font:"#333", background:"#CCC"}}, // Returns bg and font color for tags
        startWith: new Array(), // Starting array of tags (for edition purposes)
        closeChar: "x", // Char used in the closing anchor of each tag
        tagClass: "tag", // CSS class for the span tag container
        taggerWrapperClass: "tagger-input-container", // CSS class for the div container
        closeClass: "close", // CSS class for the close anchor for each tag
        tagPlacedCallback: function($tag, stag){}, // Callback function called each time a tag is created
        rejectedTagCallback: function($input, stag){}, // Callback function called each time a tag is rejected
        limitReachedCallback: function(){}, // Callback function called each time the limit is reached
		acceptedTagRegex: undefined, // RegExp object to test new tags for acceptance. rejectedTagRegex is used only if acceptedTagRegex is undefined
        rejectedTagRegex: undefined, // RegExp object to test new tags for rejection
        limit: undefined // int to tell the plugin if there is a limit number of tags to create
    }; 
})(jQuery, window);