/**
 * jQRangeSlider
 * A javascript slider selector that supports dates
 *
 * Copyright (C) Guillaume Gautreau 2012
 * Dual licensed under the MIT or GPL Version 2 licenses.
 */

 (function($, undefined){

 	"use strict";

 	$.widget("ui.rangeSliderMouseTouch", $.ui.mouse, {

 		_mouseInit: function(){
 			var that = this;
 			$.ui.mouse.prototype._mouseInit.apply(this);
 			this._mouseDownEvent = false;

 			this.element.bind('touchstart.' + this.widgetName, function(event) {
				return that._touchStart(event);
			});
 		},

 		_mouseDestroy: function(){
 			$(document)
 				.unbind('touchmove.' + this.widgetName, this._touchMoveDelegate)
				.unbind('touchend.' + this.widgetName, this._touchEndDelegate);
 			
 			$.ui.mouse.prototype._mouseDestroy.apply(this);
 		},

 		_touchStart: function(event){
 			event.which = 1;
 			event.preventDefault();

 			this._fillTouchEvent(event);

 			var that = this,
 				downEvent = this._mouseDownEvent;

 			this._mouseDown(event);

 			if (downEvent !== this._mouseDownEvent){

 				this._touchEndDelegate = function(event){
 					that._touchEnd(event);
 				}

 				this._touchMoveDelegate = function(event){
 					that._touchMove(event);
 				}

 				$(document)
					.bind('touchmove.' + this.widgetName, this._touchMoveDelegate)
					.bind('touchend.' + this.widgetName, this._touchEndDelegate);
 			}
 		},

 		_touchEnd: function(event){
 			this._fillTouchEvent(event);
 			this._mouseUp(event);

 			$(document)
				.unbind('touchmove.' + this.widgetName, this._touchMoveDelegate)
				.unbind('touchend.' + this.widgetName, this._touchEndDelegate);

			this._mouseDownEvent = false;

			// No other choice to reinitialize mouseHandled
			$(document).trigger("mouseup");
 		},

 		_touchMove: function(event){
 			event.preventDefault();
 			this._fillTouchEvent(event);

 			return this._mouseMove(event);
 		},

 		_fillTouchEvent: function(event){
 			var touch;

 			if (typeof event.targetTouches === "undefined" && typeof event.changedTouches === "undefined"){
 				touch = event.originalEvent.targetTouches[0] || event.originalEvent.changedTouches[0];
 			} else {
 				touch = event.targetTouches[0] || event.changedTouches[0];
 			}

 			event.pageX = touch.pageX;
 			event.pageY = touch.pageY;
 		}
 	});
 })(jQuery);
 
 /**
 * jQRangeSlider
 * A javascript slider selector that supports dates
 *
 * Copyright (C) Guillaume Gautreau 2012
 * Dual licensed under the MIT or GPL Version 2 licenses.
 */

 (function($, undefined){
 	"use strict";

 	$.widget("ui.rangeSliderDraggable", $.ui.rangeSliderMouseTouch, {
 		cache: null,

 		options: {
 			containment: null
 		},

 		_create: function(){
 			setTimeout($.proxy(this._initElement, this), 10);
 		},

 		_initElement: function(){
 			this._mouseInit();
 			this._cache();
 		},

 		_setOption: function(key, value){
 			if (key == "containment"){
 				if (value === null || $(value).length == 0){
 					this.options.containment = null
 				}else{
 					this.options.containment = $(value);
 				}
 			}
 		},

 		/*
 		 * UI mouse widget
 		 */

 		_mouseStart: function(event){
 			this._cache();
 			this.cache.click = {
 					left: event.pageX,
 					top: event.pageY
 			};

 			this.cache.initialOffset = this.element.offset();

 			this._triggerMouseEvent("mousestart");

 			return true;
 		},

 		_mouseDrag: function(event){
 			var position = event.pageX - this.cache.click.left;

 			position = this._constraintPosition(position + this.cache.initialOffset.left);

 			this._applyPosition(position);

 			this._triggerMouseEvent("sliderDrag");

 			return false;
 		},

 		_mouseStop: function(event){
 			this._triggerMouseEvent("stop");
 		},

 		/*
 		 * To be overriden
 		 */

 		_constraintPosition: function(position){
 			if (this.element.parent().length !== 0 && this.cache.parent.offset != null){
 				position = Math.min(position, 
 					this.cache.parent.offset.left + this.cache.parent.width - this.cache.width.outer);
 				position = Math.max(position, this.cache.parent.offset.left);
 			}

 			return position;
 		},

 		_applyPosition: function(position){
 			var offset = {
 				top: this.cache.offset.top,
 				left: position
 			}

 			this.element.offset({left:position});

 			this.cache.offset = offset;
 		},

 		/*
 		 * Private utils
 		 */

 		_cacheIfNecessary: function(){
 			if (this.cache === null){
 				this._cache();
 			}
 		},

 		_cache: function(){
 			this.cache = {};

 			this._cacheMargins();
 			this._cacheParent();
 			this._cacheDimensions();

 			this.cache.offset = this.element.offset();
 		},

 		_cacheMargins: function(){
 			this.cache.margin = {
 				left: this._parsePixels(this.element, "marginLeft"),
 				right: this._parsePixels(this.element, "marginRight"),
 				top: this._parsePixels(this.element, "marginTop"),
 				bottom: this._parsePixels(this.element, "marginBottom")
 			};
 		},

 		_cacheParent: function(){
 			if (this.options.parent !== null){
 				var container = this.element.parent();

	 			this.cache.parent = {
	 				offset: container.offset(),
	 				width: container.width()
	 			}
 			}else{
 				this.cache.parent = null;
 			}
 		},

 		_cacheDimensions: function(){
 			this.cache.width = {
 				outer: this.element.outerWidth(),
 				inner: this.element.width()
 			}
 		},

 		_parsePixels: function(element, string){
 			return parseInt(element.css(string), 10) || 0;
 		},

 		_triggerMouseEvent: function(event){
 			var data = this._prepareEventData();

 			this.element.trigger(event, data);
 		},

 		_prepareEventData: function(){
 			return {
 				element: this.element,
 				offset: this.cache.offset || null
 			};
 		}
 	});
	
 })(jQuery);
 /**
 * jQRangeSlider
 * A javascript slider selector that supports dates
 *
 * Copyright (C) Guillaume Gautreau 2012
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 */


 (function($, undefined){
	"use strict";

	$.widget("ui.rangeSliderHandle", $.ui.rangeSliderDraggable, {
		currentMove: null,
		margin: 0,
		parentElement: null,

		options: {
			isLeft: true,
			bounds: {min:0, max:100},
			range: false,
			value: 0,
			step: false
		},

		_value: 0,
		_left: 0,

		_create: function(){
			$.ui.rangeSliderDraggable.prototype._create.apply(this);

			this.element
				.css("position", "absolute")
				.css("top", 0)
				.addClass("ui-rangeSlider-handle")
				.toggleClass("ui-rangeSlider-leftHandle", this.options.isLeft)
				.toggleClass("ui-rangeSlider-rightHandle", !this.options.isLeft);

			this._value = this.options.value;
		},

		_setOption: function(key, value){
			if (key === "isLeft" && (value === true || value === false) && value != this.options.isLeft){
				this.options.isLeft = value;

				this.element
					.toggleClass("ui-rangeSlider-leftHandle", this.options.isLeft)
					.toggleClass("ui-rangeSlider-rightHandle", !this.options.isLeft);

				this._position(this._value);

				this.element.trigger("switch", this.options.isLeft);
			} else if (key === "step" && this._checkStep(value)){
				this.options.step = value;
				this.update();
			} else if (key === "bounds"){
				this.options.bounds = value;
				this.update();
			}else if (key === "range" && this._checkRange(value)){
				this.options.range = value;
				this.update();
			}

			$.ui.rangeSliderDraggable.prototype._setOption.apply(this, [key, value]);
		},

		_checkRange: function(range){
			return range === false ||
				((typeof range.min === "undefined" || range.min === false || parseFloat(range.min) === range.min)
					&& (typeof range.max === "undefined" || range.max === false || parseFloat(range.max) === range.max));
		},

		_checkStep: function(step){
			return (step === false || parseFloat(step) == step);
		},

		_initElement: function(){
			$.ui.rangeSliderDraggable.prototype._initElement.apply(this);
			
			if (this.cache.parent.width === 0 || this.cache.parent.width === null){
				setTimeout($.proxy(this._initElement, this), 500);
			}else{
				this._position(this.options.value);
				this._triggerMouseEvent("initialize");
			}
		},

		_bounds: function(){
			return this.options.bounds;
		},

		/*
		 * From draggable
		 */

		_cache: function(){
			$.ui.rangeSliderDraggable.prototype._cache.apply(this);

			this._cacheParent();
		},

		_cacheParent: function(){
			var parent = this.element.parent();

			this.cache.parent = {
				element: parent,
				offset: parent.offset(),
				padding: {
					left: this._parsePixels(parent, "paddingLeft")
				},
				width: parent.width()
			}
		},

		_position: function(value){
			var left = this._getPositionForValue(value);

			this._applyPosition(left);
		},

		_constraintPosition: function(position){
			var value = this._getValueForPosition(position);

			return this._getPositionForValue(value);
		},

		_applyPosition: function(left){
			$.ui.rangeSliderDraggable.prototype._applyPosition.apply(this, [left]);

			this._left = left;
			this._setValue(this._getValueForPosition(left));
			this._triggerMouseEvent("moving");
		},

		_prepareEventData: function(){
			var data = $.ui.rangeSliderDraggable.prototype._prepareEventData.apply(this);

			data.value = this._value;

			return data;
		},

		/*
		 * Value
		 */
		_setValue: function(value){
			if (value != this._value){
				this._value = value;
			}
		},

		_constraintValue: function(value){
			value = Math.min(value, this._bounds().max);
			value = Math.max(value, this._bounds().min);
		
			value = this._round(value);

			if (this.options.range !== false){
				var min = this.options.range.min || false,
					max = this.options.range.max || false;

				if (min !== false){
					value = Math.max(value, this._round(min));
				}

				if (max !== false){
					value = Math.min(value, this._round(max));
				}
			}

			return value;
		},

		_round: function(value){
			if (this.options.step !== false && this.options.step > 0){
				return Math.round(value / this.options.step) * this.options.step;
			}

			return value;
		},

		_getPositionForValue: function(value){
			if (this.cache.parent.offset == null){
				return 0;
			}

			value = this._constraintValue(value);

			var ratio = (value - this.options.bounds.min) / (this.options.bounds.max - this.options.bounds.min),
				availableWidth = this.cache.parent.width - this.cache.width.outer,
				parentPosition = this.cache.parent.offset.left;


			return ratio * availableWidth + parentPosition;
		},

		_getValueForPosition: function(position){
			var raw = this._getRawValueForPositionAndBounds(position, this.options.bounds.min, this.options.bounds.max);

			return this._constraintValue(raw);
		},

		_getRawValueForPositionAndBounds: function(position, min, max){
			var parentPosition =  this.cache.parent.offset == null ? 0 : this.cache.parent.offset.left,
					availableWidth = this.cache.parent.width - this.cache.width.outer,
					ratio = (position - parentPosition) / availableWidth;

			return	ratio * (max - min) + min;
		},

		/*
		 * Public
		 */

		value: function(value){
			if (typeof value != "undefined"){
				this._cache();

				value = this._constraintValue(value);

				this._position(value);
			}

			return this._value;
		},

		update: function(){
			this._cache();
			var value = this._constraintValue(this._value),
				position = this._getPositionForValue(value);

			if (value != this._value){
				this._triggerMouseEvent("updating");
				this._position(value);
				this._triggerMouseEvent("update");
			}else if (position != this.cache.offset.left){
				this._triggerMouseEvent("updating");
				this._position(value);
				this._triggerMouseEvent("update");
			}
		},

		position: function(position){
			if (typeof position != "undefined"){
				this._cache();
				
				position = this._constraintPosition(position);
				this._applyPosition(position);
			}

			return this._left;
		},

		add: function(value, step){
			return value + step;
		},

		substract: function(value, step){
			return value - step;
		},

		stepsBetween: function(val1, val2){
			if (this.options.step === false){
				return val2 - val1;
			}

			return (val2 - val1) / this.options.step;
		},

		multiplyStep: function(step, factor){
			return step * factor;
		},

		moveRight: function(quantity){
			var previous;

			if (this.options.step == false){
				previous = this._left;
				this.position(this._left + quantity);

				return this._left - previous;
			}
			
			previous = this._value;
			this.value(this.add(previous, this.multiplyStep(this.options.step, quantity)));

			return this.stepsBetween(previous, this._value);
		},

		moveLeft: function(quantity){
			return -this.moveRight(-quantity);
		},

		stepRatio: function(){
			if (this.options.step == false){
				return 1;
			}else{
				var steps = (this.options.bounds.max - this.options.bounds.min) / this.options.step;
				return this.cache.parent.width / steps;
			}
		}
	});
 })(jQuery);
 
 /**
 * jQRangeSlider
 * A javascript slider selector that supports dates
 *
 * Copyright (C) Guillaume Gautreau 2012
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 */

(function($, undefined){
	"use strict";

	$.widget("ui.rangeSliderBar", $.ui.rangeSliderDraggable, {
		options: {
			leftHandle: null,
			rightHandle: null,
			bounds: {min: 0, max: 100},
			type: "rangeSliderHandle",
			range: false,
			drag: function() {},
			stop: function() {},
			values: {min: 0, max:20},
			wheelSpeed: 4,
			wheelMode: null
		},

		_values: {min: 0, max: 20},
		_waitingToInit: 2,
		_wheelTimeout: false,

		_create: function(){
			$.ui.rangeSliderDraggable.prototype._create.apply(this);

			this.element
				.css("position", "absolute")
				.css("top", 0)
				.addClass("ui-rangeSlider-bar");

			this.options.leftHandle
				.bind("initialize", $.proxy(this._onInitialized, this))
				.bind("mousestart", $.proxy(this._cache, this))
				.bind("stop", $.proxy(this._onHandleStop, this));

			this.options.rightHandle
				.bind("initialize", $.proxy(this._onInitialized, this))
				.bind("mousestart", $.proxy(this._cache, this))
				.bind("stop", $.proxy(this._onHandleStop, this));

			this._bindHandles();

			this._values = this.options.values;
			this._setWheelModeOption(this.options.wheelMode);
		},

		_setOption: function(key, value){
			if (key === "range"){
				this._setRangeOption(value);
			} else if (key === "wheelSpeed"){
				this._setWheelSpeedOption(value);
			} else if (key === "wheelMode"){
				this._setWheelModeOption(value);
			}
		},

		_setRangeOption: function(value){
			if (typeof value != "object" || value === null){
				value = false;
			}

			if (value === false && this.options.range === false){
				return;
			}

			if (value !== false){
				var min = typeof value.min === "undefined" ? this.options.range.min || false : value.min,
					max = typeof value.max === "undefined" ? this.options.range.max || false : value.max;

				this.options.range = {
					min: min,
					max: max
				};
			}else{
				this.options.range = false;
			}

			this._setLeftRange();
			this._setRightRange();
		},

		_setWheelSpeedOption: function(value){
			if (typeof value === "number" && value > 0){
				this.options.wheelSpeed = value;
			}
		},

		_setWheelModeOption: function(value){
			if (value === null || value === false || value === "zoom" || value === "scroll"){
				if (this.options.wheelMode !== value){
					this.element.parent().unbind("mousewheel.bar");
				}

				this._bindMouseWheel(value);
				this.options.wheelMode = value;
			}
		},

		_bindMouseWheel: function(mode){
			if (mode === "zoom"){
				this.element.parent().bind("mousewheel.bar", $.proxy(this._mouseWheelZoom, this));
			}else if (mode === "scroll"){
				this.element.parent().bind("mousewheel.bar", $.proxy(this._mouseWheelScroll, this));
			}
		},

		_setLeftRange: function(){
			if (this.options.range == false){
				return false;
			}

			var rightValue = this._values.max,
				leftRange = {min: false, max: false};

			if ((this.options.range.min || false) !== false){
				leftRange.max = this._leftHandle("substract", rightValue, this.options.range.min);
			}else{
				leftRange.max = false;
			}

			if ((this.options.range.max || false) !== false){
				leftRange.min = this._leftHandle("substract", rightValue, this.options.range.max);
			}else{
				leftRange.min = false;
			}

			this._leftHandle("option", "range", leftRange);
		},

		_setRightRange: function(){
			var leftValue = this._values.min,
				rightRange = {min: false, max:false};

			if ((this.options.range.min || false) !== false){
				rightRange.min = this._rightHandle("add", leftValue, this.options.range.min);
			}else {
				rightRange.min = false;
			}

			if ((this.options.range.max || false) !== false){
				rightRange.max = this._rightHandle("add", leftValue, this.options.range.max);
			}else{
				rightRange.max = false;
			}

			this._rightHandle("option", "range", rightRange);
		},

		_deactivateRange: function(){
			this._leftHandle("option", "range", false);
			this._rightHandle("option", "range", false);
		},

		_reactivateRange: function(){
			this._setRangeOption(this.options.range);
		},

		_onInitialized: function(){
			this._waitingToInit--;

			if (this._waitingToInit === 0){
				this._initMe();
			}
		},

		_initMe: function(){
			this._cache();
			this.min(this.options.values.min);
			this.max(this.options.values.max);

			var left = this._leftHandle("position"),
				right = this._rightHandle("position") + this.options.rightHandle.width();

			this.element.offset({
				left: left
			});

			this.element.css("width", right - left);
		},

		_leftHandle: function(){
			return this._handleProxy(this.options.leftHandle, arguments);
		},

		_rightHandle: function(){
			return this._handleProxy(this.options.rightHandle, arguments);
		},

		_handleProxy: function(element, args){
			var array = Array.prototype.slice.call(args);

			return element[this.options.type].apply(element, array);
		},

		/*
		 * Draggable
		 */

		_cache: function(){
			$.ui.rangeSliderDraggable.prototype._cache.apply(this);

			this._cacheHandles();
		},

		_cacheHandles: function(){
			this.cache.rightHandle = {};
			this.cache.rightHandle.width = this.options.rightHandle.width();
			this.cache.rightHandle.offset = this.options.rightHandle.offset();

			this.cache.leftHandle = {};
			this.cache.leftHandle.offset = this.options.leftHandle.offset();
		},

		_mouseStart: function(event){
			$.ui.rangeSliderDraggable.prototype._mouseStart.apply(this, [event]);

			this._deactivateRange();
		},

		_mouseStop: function(event){
			$.ui.rangeSliderDraggable.prototype._mouseStop.apply(this, [event]);

			this._cacheHandles();

			this._values.min = this._leftHandle("value");
			this._values.max = this._rightHandle("value");
			this._reactivateRange();

			this._leftHandle().trigger("stop");
			this._rightHandle().trigger("stop");
		},

		/*
		 * Event binding
		 */

		_onDragLeftHandle: function(event, ui){
			this._cacheIfNecessary();

			if (this._switchedValues()){
				this._switchHandles();
				this._onDragRightHandle(event, ui);
				return;
			}

			this._values.min = ui.value;
			this.cache.offset.left = ui.offset.left;
			this.cache.leftHandle.offset = ui.offset;

			this._positionBar();
		},

		_onDragRightHandle: function(event, ui){
			this._cacheIfNecessary();

			if (this._switchedValues()){
				this._switchHandles(),
				this._onDragLeftHandle(event, ui);
				return;
			}

			this._values.max = ui.value;
			this.cache.rightHandle.offset = ui.offset;

			this._positionBar();
		},

		_positionBar: function(){
			var width = this.cache.rightHandle.offset.left + this.cache.rightHandle.width - this.cache.leftHandle.offset.left;
			this.cache.width.inner = width;

			this.element
				.css("width", width)
				.offset({left: this.cache.leftHandle.offset.left});
		},

		_onHandleStop: function(){
			this._setLeftRange();
			this._setRightRange();
		},

		_switchedValues: function(){
			if (this.min() > this.max()){
				var temp = this._values.min;
				this._values.min = this._values.max;
				this._values.max = temp;

				return true;
			}

			return false;
		},

		_switchHandles: function(){
			var temp = this.options.leftHandle;

			this.options.leftHandle = this.options.rightHandle;
			this.options.rightHandle = temp;

			this._leftHandle("option", "isLeft", true);
			this._rightHandle("option", "isLeft", false);

			this._bindHandles();
			this._cacheHandles();
		},

		_bindHandles: function(){
			this.options.leftHandle
				.unbind(".bar")
				.bind("sliderDrag.bar update.bar moving.bar", $.proxy(this._onDragLeftHandle, this));

			this.options.rightHandle
				.unbind(".bar")
				.bind("sliderDrag.bar update.bar moving.bar", $.proxy(this._onDragRightHandle, this));
		},

		_constraintPosition: function(left){
			var position = {},
				right;

			position.left = $.ui.rangeSliderDraggable.prototype._constraintPosition.apply(this, [left]);

			position.left = this._leftHandle("position", position.left);

			right = this._rightHandle("position", position.left + this.cache.width.outer - this.cache.rightHandle.width);
			position.width = right - position.left + this.cache.rightHandle.width;

			return position;
		},

		_applyPosition: function(position){
			$.ui.rangeSliderDraggable.prototype._applyPosition.apply(this, [position.left]);
			this.element.width(position.width);
		},

		/*
		 * Mouse wheel
		 */

		_mouseWheelZoom: function(event, delta, deltaX, deltaY){
			var middle = this._values.min + (this._values.max - this._values.min) / 2,
				leftRange = {},
				rightRange = {};

			if (this.options.range === false || this.options.range.min === false){
				leftRange.max = middle;
				rightRange.min = middle;
			} else {
				leftRange.max = middle - this.options.range.min / 2;
				rightRange.min = middle + this.options.range.min / 2;
			}

			if (this.options.range !== false && this.options.range.max !== false){
				leftRange.min = middle - this.options.range.max / 2;
				rightRange.max = middle + this.options.range.max / 2;
			}

			this._leftHandle("option", "range", leftRange);
			this._rightHandle("option", "range", rightRange);

			clearTimeout(this._wheelTimeout);
			this._wheelTimeout = setTimeout($.proxy(this._wheelStop, this), 200);

			this.zoomOut(deltaY * this.options.wheelSpeed);

			return false;
		},

		_mouseWheelScroll: function(event, delta, deltaX, deltaY){
			if (this._wheelTimeout === false){
				this.startScroll();
			} else {
				clearTimeout(this._wheelTimeout);
			}

			this._wheelTimeout = setTimeout($.proxy(this._wheelStop, this), 200);

			this.scrollLeft(deltaY * this.options.wheelSpeed);
			return false;
		},

		_wheelStop: function(){
			this.stopScroll();
			this._wheelTimeout = false;
		},

		/*
		 * Public
		 */

		min: function(value){
			return this._leftHandle("value", value);
		},

		max: function(value){
			return this._rightHandle("value", value);
		},

		startScroll: function(){
			this._deactivateRange();
		},

		stopScroll: function(){
			this._reactivateRange();
			this._triggerMouseEvent("stop");
		},

		scrollLeft: function(quantity){
			quantity = quantity || 1;

			if (quantity < 0){
				return this.scrollRight(-quantity);
			}

			quantity = this._leftHandle("moveLeft", quantity);
			this._rightHandle("moveLeft", quantity);

			this.update();
			this._triggerMouseEvent("scroll");
		},

		scrollRight: function(quantity){
			quantity = quantity || 1;

			if (quantity < 0){
				return this.scrollLeft(-quantity);
			}

			quantity = this._rightHandle("moveRight", quantity);
			this._leftHandle("moveRight", quantity);

			this.update();
			this._triggerMouseEvent("scroll");
		},

		zoomIn: function(quantity){
			quantity = quantity || 1;

			if (quantity < 0){
				return this.zoomOut(-quantity);
			}

			var newQuantity = this._rightHandle("moveLeft", quantity);

			if (quantity > newQuantity){
				newQuantity = newQuantity / 2;
				this._rightHandle("moveRight", newQuantity);
			}

			this._leftHandle("moveRight", newQuantity);

			this.update();
			this._triggerMouseEvent("zoom");
		},

		zoomOut: function(quantity){
			quantity = quantity || 1;

			if (quantity < 0){
				return this.zoomIn(-quantity);
			}

			var newQuantity = this._rightHandle("moveRight", quantity);

			if (quantity > newQuantity){
				newQuantity = newQuantity / 2;
				this._rightHandle("moveLeft", newQuantity);
			}

			this._leftHandle("moveLeft", newQuantity);

			this.update();
			this._triggerMouseEvent("zoom");
		},

		values: function(min, max){
			if (typeof min !== "undefined" && typeof max !== "undefined")
			{
				var minValue = Math.min(min, max),
					maxValue = Math.max(min, max);

				this._deactivateRange();
				this.options.leftHandle.unbind(".bar");
				this.options.rightHandle.unbind(".bar");

				this._values.min = this._leftHandle("value", minValue);
				this._values.max = this._rightHandle("value", maxValue);

				this._bindHandles();
				this._reactivateRange();

				this.update();
			}

			return {
				min: this._values.min,
				max: this._values.max
			};
		},

		update: function(){
			this._values.min = this.min();
			this._values.max = this.max();

			this._cache();
			this._positionBar();
		}

	});

})(jQuery);

/**
 * jQRangeSlider
 * A javascript slider selector that supports dates
 *
 * Copyright (C) Guillaume Gautreau 2012
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 */

(function($, undefined){
	
	"use strict";

	$.widget("ui.rangeSliderLabel", $.ui.rangeSliderMouseTouch, {
		options: {
			handle: null,
			formatter: false,
			handleType: "rangeSliderHandle",
			show: "show",
			durationIn: 0,
			durationOut: 500,
			delayOut: 500,
			isLeft: false
		},

		cache: null,
		_positionner: null,
		_valueContainer:null,
		_innerElement:null,

		_create: function(){
			this.options.isLeft = this._handle("option", "isLeft");

			this.element
				.addClass("ui-rangeSlider-label")
				.css("position", "absolute")
				.css("display", "block");

			this._valueContainer = $("<div class='ui-rangeSlider-label-value' />")
				.appendTo(this.element);

			this._innerElement = $("<div class='ui-rangeSlider-label-inner' />")
				.appendTo(this.element);

			this._toggleClass();

			this.options.handle
				.bind("moving", $.proxy(this._onMoving, this))
				.bind("update", $.proxy(this._onUpdate, this))
				.bind("switch", $.proxy(this._onSwitch, this));

			if (this.options.show !== "show"){
				this.element.hide();
			}

			this._mouseInit();
		},

		_handle: function(){
			var args = Array.prototype.slice.apply(arguments);

			return this.options.handle[this.options.handleType].apply(this.options.handle, args);
		},

		_setOption: function(key, value){
			if (key === "show"){
				this._updateShowOption(value);
			} else if (key === "durationIn" || key === "durationOut" || key === "delayOut"){
				this._updateDurations(key, value);
			}
		},

		_updateShowOption: function(value){
			this.options.show = value;

			if (this.options.show !== "show"){
				this.element.hide();
			}else{
				this.element.show();
				this._display(this.options.handle[this.options.handleType]("value"));
				this._positionner.PositionLabels();
			}
			
			this._positionner.options.show = this.options.show;
		},

		_updateDurations: function(key, value){
			if (parseInt(value) !== value) return;

			this._positionner.options[key] = value;
			this.options[key] = value;
		},

		_display: function(value){
			if (this.options.formatter == false){
				this._displayText(Math.round(value));
			}else{
				this._displayText(this.options.formatter(value));
			}
		},

		_displayText: function(text){
			this._valueContainer.text(text);
		},

		_toggleClass: function(){
			this.element.toggleClass("ui-rangeSlider-leftLabel", this.options.isLeft)
				.toggleClass("ui-rangeSlider-rightLabel", !this.options.isLeft);
		},

		/*
		 * Mouse touch redirection
		 */
		_mouseDown: function(event){
			this.options.handle.trigger(event);
		},

		_mouseUp: function(event){
			this.options.handle.trigger(event);
		},

		_mouseMove: function(event){
			this.options.handle.trigger(event);
		},

		/*
		 * Event binding
		 */
		_onMoving: function(event, ui){
			this._display(ui.value);
		},

		_onUpdate: function(event, ui){
			if (this.options.show === "show"){
				this.update();
			}
		},

		_onSwitch: function(event, isLeft){
			this.options.isLeft = isLeft;
			
			this._toggleClass();
			this._positionner.PositionLabels();
		},

		/*
		 * Label pair
		 */
		pair: function(label){
			if (this._positionner != null) return;

			this._positionner = new LabelPositioner(this.element, label, this.widgetName, {
				show: this.options.show,
				durationIn: this.options.durationIn,
				durationOut: this.options.durationOut,
				delayOut: this.options.delayOut
			});

			label[this.widgetName]("positionner", this._positionner);
		},

		positionner: function(pos){
			if (typeof pos !== "undefined"){
				this._positionner = pos;
			}

			return this._positionner;
		},

		update: function(){
			this._positionner.cache = null;
			this._display(this._handle("value"));

			if (this.options.show == "show"){
				this._positionner.PositionLabels();
			}
		}
	});

	function LabelPositioner(label1, label2, type, options){
		this.label1 = label1;
		this.label2 = label2;
		this.type = type;
		this.options = options;
		this.handle1 = this.label1[this.type]("option", "handle");
		this.handle2 = this.label2[this.type]("option", "handle");
		this.cache = null;
		this.left = label1;
		this.right = label2;
		this.moving = false;
		this.initialized = false;
		this.updating = false;

		this.Init = function(){
			this.BindHandle(this.handle1);
			this.BindHandle(this.handle2);

			if (this.options.show === "show"){
				setTimeout($.proxy(this.PositionLabels, this), 1);
				this.initialized = true;
			}else{
				setTimeout($.proxy(this.AfterInit, this), 1000);
			}
		}

		this.AfterInit = function () {
			this.initialized = true;
		}

		this.Cache = function(){
			if (this.label1.css("display") == "none"){
				return;
			}

			this.cache = {};
			this.cache.label1 = {};
			this.cache.label2 = {};
			this.cache.handle1 = {};
			this.cache.handle2 = {};
			this.cache.offsetParent = {};

			this.CacheElement(this.label1, this.cache.label1);
			this.CacheElement(this.label2, this.cache.label2);
			this.CacheElement(this.handle1, this.cache.handle1);
			this.CacheElement(this.handle2, this.cache.handle2);
			this.CacheElement(this.label1.offsetParent(), this.cache.offsetParent);
		}

		this.CacheIfNecessary = function(){
			if (this.cache === null){
				this.Cache();
			}else{
				this.CacheWidth(this.label1, this.cache.label1);
				this.CacheWidth(this.label2, this.cache.label2);
				this.CacheHeight(this.label1, this.cache.label1);
				this.CacheHeight(this.label2, this.cache.label2);
				this.CacheWidth(this.label1.offsetParent(), this.cache.offsetParent);
			}
		}

		this.CacheElement = function(label, cache){
			this.CacheWidth(label, cache);
			this.CacheHeight(label, cache);

			cache.offset = label.offset();
			cache.margin = {
				left: this.ParsePixels("marginLeft", label),
				right: this.ParsePixels("marginRight", label)
			};

			cache.border = {
				left: this.ParsePixels("borderLeftWidth", label),
				right: this.ParsePixels("borderRightWidth", label)
			};
		}

		this.CacheWidth = function(label, cache){
			cache.width = label.width();
			cache.outerWidth = label.outerWidth();
		}

		this.CacheHeight = function(label, cache){
			cache.outerHeightMargin = label.outerHeight(true);
		},

		this.ParsePixels = function(name, element){
			return parseInt(element.css(name), 10) || 0;
		}

		this.BindHandle = function(handle){
			handle.bind("updating", $.proxy(this.onHandleUpdating, this));
			handle.bind("update", $.proxy(this.onHandleUpdated, this));
			handle.bind("moving", $.proxy(this.onHandleMoving, this));
			handle.bind("stop", $.proxy(this.onHandleStop, this));
		}

		this.PositionLabels = function(){
			this.CacheIfNecessary();

			if (this.cache == null){
				return;
			}

			var label1Pos = this.GetRawPosition(this.cache.label1, this.cache.handle1),
				label2Pos = this.GetRawPosition(this.cache.label2, this.cache.handle2);

			this.ConstraintPositions(label1Pos, label2Pos);

			this.PositionLabel(this.label1, label1Pos.left, this.cache.label1);
			this.PositionLabel(this.label2, label2Pos.left, this.cache.label2);
		}

		this.PositionLabel = function(label, leftOffset, cache){
			var parentShift = this.cache.offsetParent.offset.left + this.cache.offsetParent.border.left,
					parentRightPosition,
					labelRightPosition,
					rightPosition;

			if ((parentShift - leftOffset) >= 0){
				label.css("right", "");
				label.offset({left: leftOffset});
			}else{
				parentRightPosition = parentShift
																			+ this.cache.offsetParent.width;
				labelRightPosition = leftOffset
																			+ cache.margin.left
																			+ cache.outerWidth
																			+ cache.margin.right,
				rightPosition = parentRightPosition - labelRightPosition;

				label.css("left", "");
				label.css("right", rightPosition);
			}
		}

		this.ConstraintPositions = function(pos1, pos2){
			if (pos1.center < pos2.center && pos1.outerRight > pos2.outerLeft){
				pos1 = this.getLeftPosition(pos1, pos2);
				pos2 = this.getRightPosition(pos1, pos2);
			}else if (pos1.center > pos2.center && pos2.outerRight > pos1.outerLeft){
				pos2 = this.getLeftPosition(pos2, pos1);
				pos1 = this.getRightPosition(pos2, pos1);
			}
		}

		this.getLeftPosition = function(left, right){
			var center = (right.center + left.center) / 2,
				leftPos = center - left.cache.outerWidth - left.cache.margin.right + left.cache.border.left;

			left.left = leftPos;

			return left;
		}

		this.getRightPosition = function(left, right){
			var center = (right.center + left.center) / 2;

			right.left = center + right.cache.margin.left + right.cache.border.left;

			return right;
		}

		this.ShowIfNecessary = function(){
			if (this.options.show === "show" || this.moving || !this.initialized || this.updating) return;

			this.label1.stop(true, true).fadeIn(this.options.durationIn || 0);
			this.label2.stop(true, true).fadeIn(this.options.durationIn || 0);
			this.moving = true;
		},

		this.HideIfNeeded = function(lastMove){
			if (this.moving === true){
				this.label1.stop(true, true).delay(this.options.delayOut || 0).fadeOut(this.options.durationOut || 0);
				this.label2.stop(true, true).delay(this.options.delayOut || 0).fadeOut(this.options.durationOut || 0);
				this.moving = false;
			}
		},

		this.onHandleMoving = function(event, ui){
			this.ShowIfNecessary();
			this.CacheIfNecessary();
			this.UpdateHandlePosition(ui);

			this.PositionLabels();
		}

		this.onHandleUpdating = function(){
			this.updating = true;
		}

		this.onHandleUpdated = function(){
			this.updating = false;
			this.cache = null;
		}

		this.onHandleStop = function(event, ui){
			this.HideIfNeeded();
		},

		this.UpdateHandlePosition = function(ui){
			if (this.cache == null) return;
			
			if (ui.element[0] == this.handle1[0]){
				this.UpdatePosition(ui, this.cache.handle1);
			}else{
				this.UpdatePosition(ui, this.cache.handle2);
			}
		}

		this.UpdatePosition = function(element, cache){
			cache.offset = element.offset;
		}

		this.GetRawPosition = function(labelCache, handleCache){
			var handleCenter = handleCache.offset.left + handleCache.outerWidth / 2,
				labelLeft = handleCenter - labelCache.outerWidth / 2,
				labelRight = labelLeft + labelCache.outerWidth - labelCache.border.left - labelCache.border.right,
				outerLeft = labelLeft - labelCache.margin.left - labelCache.border.left,
				top = handleCache.offset.top - labelCache.outerHeightMargin;

			return {
				left: labelLeft,
				outerLeft: outerLeft,
				top: top,
				right: labelRight,
				outerRight: outerLeft + labelCache.outerWidth + labelCache.margin.left + labelCache.margin.right,
				cache: labelCache,
				center: handleCenter
			}
		}

		this.Init();
	}

})(jQuery);


/**
 * jQRangeSlider
 * A javascript slider selector that supports dates
 *
 * Copyright (C) Guillaume Gautreau 2012
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 */

(function ($, undefined) {
	"use strict";

	$.widget("ui.rangeSlider", {
		options: {
			bounds: {min:0, max:100},
			defaultValues: {min:20, max:50},
			wheelMode: null,
			wheelSpeed: 4,
			arrows: true,
			valueLabels: "show",
			formatter: null,
			durationIn: 0,
			durationOut: 400,
			delayOut: 200,
			range: {min: false, max: false},
			step: false
		},

		_values: null,
		_valuesChanged: false,

		// Created elements
		bar: null,
		leftHandle: null,
		rightHandle: null,
		innerBar: null,
		container: null,
		arrows: null,
		labels: null,
		changing: {min:false, max:false},
		changed: {min:false, max:false},

		_create: function(){
			this._values = {
				min: this.options.defaultValues.min,
				max: this.options.defaultValues.max
			};

			this.labels = {left: null, right:null, leftDisplayed:true, rightDisplayed:true};
			this.arrows = {left:null, right:null};
			this.changing = {min:false, max:false};
			this.changed = {min:false, max:false};

			if (this.element.css("position") !== "absolute"){
				this.element.css("position", "relative");
			}

			this.container = $("<div class='ui-rangeSlider-container' />")
				.css("position", "absolute")
				.appendTo(this.element);
			
			this.innerBar = $("<div class='ui-rangeSlider-innerBar' />")
				.css("position", "absolute")
				.css("top", 0)
				.css("left", 0);

			this.leftHandle = this._createHandle({
					isLeft: true,
					bounds: this.options.bounds,
					value: this.options.defaultValues.min,
					step: this.options.step
			}).appendTo(this.container);
	
			this.rightHandle = this._createHandle({
				isLeft: false,
				bounds: this.options.bounds,
				value: this.options.defaultValues.max,
				step: this.options.step
			}).appendTo(this.container);

			this._createBar();

			this.container.prepend(this.innerBar);

			this.arrows.left = this._createArrow("left");
			this.arrows.right = this._createArrow("right");

			this.element.addClass("ui-rangeSlider");

			if (!this.options.arrows){
				this.arrows.left.css("display", "none");
				this.arrows.right.css("display", "none");
				this.element.addClass("ui-rangeSlider-noArrow");
			}else{
				this.element.addClass("ui-rangeSlider-withArrows");
			}
			if (this.options.valueLabels !== "hide"){
				this._createLabels();
			}else{
				this._destroyLabels();
			}

			this._bindResize();

			setTimeout($.proxy(this.resize, this), 1);
			setTimeout($.proxy(this._initValues, this), 1);
		},

		_bindResize: function(){
			var that = this;

			this._resizeProxy = function(e){
				that.resize(e);
			};

			$(window).resize(this._resizeProxy);
		},

		_initWidth: function(){
			this.container.css("width", this.element.width() - this.container.outerWidth(true) + this.container.width());
			this.innerBar.css("width", this.container.width() - this.innerBar.outerWidth(true) + this.innerBar.width());
		},

		_initValues: function(){
			this.values(this.options.defaultValues.min, this.options.defaultValues.max);
		},

		_setOption: function(key, value) {
			var option = this.options;
			
			if (key === "defaultValues")
			{
				if ((typeof value.min !== "undefined") && (typeof value.max !== "undefined") && parseFloat(value.min) === value.min && parseFloat(value.max) === value.max)
				{
					this.options.defaultValues = value;
				}
			}else if (key === "wheelMode" || key === "wheelSpeed"){
				this._bar("option", key, value);
				this.options[key] = this._bar("option", key);
			}else if (key === "arrows" && (value === true || value === false) && value !== this.options.arrows){
				this._setArrowsOption(value);
			}else if (key === "valueLabels"){
				this._setLabelsOption(value);
			}else if (key === "durationIn" || key === "durationOut" || key === "delayOut"){
				this._setLabelsDurations(key, value);
			}else if (key === "formatter" && value !== null && typeof value === "function"){
				this.options.formatter = value;
				
				if (this.options.valueLabels !== "hide"){
					this._destroyLabels();
					this._createLabels();
				}
			}else if (key === "bounds" && typeof value.min !== "undefined" && typeof value.max !== "undefined"){
				this.bounds(value.min, value.max);
			}else if (key === "range"){
				this._bar("option", "range", value);
				this.options.range = this._bar("option", "range");
				this._changed(true);
			}else if (key === "step"){
				this.options.step = value;
				this._leftHandle("option", "step", value);
				this._rightHandle("option", "step", value);
				this._changed(true);
			}
		},

		_validProperty: function(object, name, defaultValue){
			if (object === null || typeof object[name] === "undefined"){
				return defaultValue;
			}

			return object[name];
		},

		_setLabelsOption: function(value){
			if (value !== "hide" && value !== "show" && value !== "change"){
				return;
			}

			this.options.valueLabels = value;

			if (value !== "hide"){
				this._createLabels();
				this._leftLabel("update");
				this._rightLabel("update");
			}else{
				this._destroyLabels();
			}
		},

		_setArrowsOption: function(value){
			if (value === true){
				this.element
					.removeClass("ui-rangeSlider-noArrow")
					.addClass("ui-rangeSlider-withArrows");
				this.arrows.left.css("display", "block");
				this.arrows.right.css("display", "block");
				this.options.arrows = true;
			}else if (value === false){
				this.element
					.addClass("ui-rangeSlider-noArrow")
					.removeClass("ui-rangeSlider-withArrows");
				this.arrows.left.css("display", "none");
				this.arrows.right.css("display", "none");
				this.options.arrows = false;
			}

			this._initWidth();
		},

		_setLabelsDurations: function(key, value){
			if (parseInt(value, 10) !== value) return;

			if (this.labels.left !== null){
				this._leftLabel("option", key, value);
			}

			if (this.labels.right !== null){
				this._rightLabel("option", key, value);
			}

			this.options[key] = value;
		},

		_createHandle: function(options){
			return $("<div />")
				[this._handleType()](options)
				.bind("sliderDrag", $.proxy(this._changing, this))
				.bind("stop", $.proxy(this._changed, this));
		},
		
		_createBar: function(){
			this.bar = $("<div />")
				.prependTo(this.container)
				.bind("sliderDrag scroll zoom", $.proxy(this._changing, this))
				.bind("stop", $.proxy(this._changed, this));
			
			this._bar({
					leftHandle: this.leftHandle,
					rightHandle: this.rightHandle,
					values: {min: this.options.defaultValues.min, max: this.options.defaultValues.max},
					type: this._handleType(),
					range: this.options.range,
					wheelMode: this.options.wheelMode,
					wheelSpeed: this.options.wheelSpeed
				});

			this.options.range = this._bar("option", "range");
			this.options.wheelMode = this._bar("option", "wheelMode");
			this.options.wheelSpeed = this._bar("option", "wheelSpeed");
		},

		_createArrow: function(whichOne){
			var arrow = $("<div class='ui-rangeSlider-arrow' />")
				.append("<div class='ui-rangeSlider-arrow-inner' />")
				.addClass("ui-rangeSlider-" + whichOne + "Arrow")
				.css("position", "absolute")
				.css(whichOne, 0)
				.appendTo(this.element),
				target;

			if (whichOne === "right"){
				target = $.proxy(this._scrollRightClick, this);
			}else{
				target = $.proxy(this._scrollLeftClick, this);
			}

			arrow.bind("mousedown touchstart", target);

			return arrow;
		},

		_proxy: function(element, type, args){
			var array = Array.prototype.slice.call(args);

			return element[type].apply(element, array);
		},

		_handleType: function(){
			return "rangeSliderHandle";
		},

		_barType: function(){
			return "rangeSliderBar";
		},

		_bar: function(){
			return this._proxy(this.bar, this._barType(), arguments);
		},

		_labelType: function(){
			return "rangeSliderLabel";
		},

		_leftLabel: function(){
			return this._proxy(this.labels.left, this._labelType(), arguments);
		},

		_rightLabel: function(){
			return this._proxy(this.labels.right, this._labelType(), arguments);
		},

		_leftHandle: function(){
			return this._proxy(this.leftHandle, this._handleType(), arguments);
		},

		_rightHandle: function(){
			return this._proxy(this.rightHandle, this._handleType(), arguments);
		},

		_getValue: function(position, handle){
			if (handle === this.rightHandle){	
				position = position - handle.outerWidth();
			}
			
			return position * (this.options.bounds.max - this.options.bounds.min) / (this.container.innerWidth() - handle.outerWidth(true)) + this.options.bounds.min;
		},

		_trigger: function(eventName){
			var that = this;

			setTimeout(function(){
				that.element.trigger(eventName, {
						label: that.element,
						values: that.values()
				  });
			}, 1);
		},

		_changing: function(event, ui){
			if(this._updateValues()){
				this._trigger("valuesChanging");
				this._valuesChanged = true;
			}
		},

		_changed: function(isAutomatic){
			if (this._updateValues() || this._valuesChanged){
				this._trigger("valuesChanged");

				if (isAutomatic !== true){
					this._trigger("userValuesChanged");					
				}

				this._valuesChanged = false;
			}
		},

		_updateValues: function(){
			var left = this._leftHandle("value"),
				right = this._rightHandle("value"),
				min = this._min(left, right),
				max = this._max(left, right),
				changing = (min !== this._values.min || max !== this._values.max);

			this._values.min = this._min(left, right);
			this._values.max = this._max(left, right);

			return changing;
		},

		_min: function(value1, value2){
			return Math.min(value1, value2);
		},

		_max: function(value1, value2){
			return Math.max(value1, value2);
		},

		/*
		 * Value labels
		 */
		_createLabel: function(label, handle){
			var params;

			if (label === null){
				params = this._getLabelConstructorParameters(label, handle);
				label = $("<div />")
					.appendTo(this.element)
					[this._labelType()](params);
			}else{
				params = this._getLabelRefreshParameters(label, handle);

				label[this._labelType()](params);
			}

			return label;
		},

		_getLabelConstructorParameters: function(label, handle){
			return {
				handle: handle,
				handleType: this._handleType(),
				formatter: this._getFormatter(),
				show: this.options.valueLabels,
				durationIn: this.options.durationIn,
				durationOut: this.options.durationOut,
				delayOut: this.options.delayOut
			};
		},

		_getLabelRefreshParameters: function(label, handle){
			return {
				formatter: this._getFormatter(),
				show: this.options.valueLabels,
				durationIn: this.options.durationIn,
				durationOut: this.options.durationOut,
				delayOut: this.options.delayOut
			};
		},

		_getFormatter: function(){
			if (this.options.formatter === false || this.options.formatter === null){
				return this._defaultFormatter;
			}

			return this.options.formatter;
		},

		_defaultFormatter: function(value){
			return Math.round(value);
		},

		_destroyLabel: function(label){
			if (label !== null){
				label.remove();
				label = null;
			}

			return label;
		},

		_createLabels: function(){
			this.labels.left = this._createLabel(this.labels.left, this.leftHandle);
			this.labels.right = this._createLabel(this.labels.right, this.rightHandle);

			this._leftLabel("pair", this.labels.right);
		},

		_destroyLabels: function(){
			this.labels.left = this._destroyLabel(this.labels.left);
			this.labels.right = this._destroyLabel(this.labels.right);
		},

		/*
		 * Scrolling
		 */
		_stepRatio: function(){
			return this._leftHandle("stepRatio");
		},

		_scrollRightClick: function(e){
			e.preventDefault();
			this._bar("startScroll");
			this._bindStopScroll();

			this._continueScrolling("scrollRight", 4 * this._stepRatio(), 1);
		},

		_continueScrolling: function(action, timeout, quantity, timesBeforeSpeedingUp){
			this._bar(action, quantity);
			timesBeforeSpeedingUp = timesBeforeSpeedingUp || 5;
			timesBeforeSpeedingUp--;

			var that = this,
				minTimeout = 16,
				maxQuantity = Math.max(1, 4 / this._stepRatio());

			this._scrollTimeout = setTimeout(function(){
				if (timesBeforeSpeedingUp === 0){
					if (timeout > minTimeout){
						timeout = Math.max(minTimeout, timeout / 1.5);	
					} else {
						quantity = Math.min(maxQuantity, quantity * 2);
					}
					
					timesBeforeSpeedingUp = 5;
				}

				that._continueScrolling(action, timeout, quantity, timesBeforeSpeedingUp);
			}, timeout);
		},

		_scrollLeftClick: function(e){
			e.preventDefault();

			this._bar("startScroll");
			this._bindStopScroll();

			this._continueScrolling("scrollLeft", 4 * this._stepRatio(), 1);
		},

		_bindStopScroll: function(){
			var that = this;
			this._stopScrollHandle = function(e){
				e.preventDefault();
				that._stopScroll();
			};

			$(document).bind("mouseup touchend", this._stopScrollHandle);
		},

		_stopScroll: function(){
			$(document).unbind("mouseup touchend", this._stopScrollHandle);
			this._bar("stopScroll");
			clearTimeout(this._scrollTimeout);
		},

		/*
		 * Public methods
		 */
		values: function(min, max){
			var val = this._bar("values", min, max);

			if (typeof min !== "undefined" && typeof max !== "undefined"){
				this._changed(true);
			}

			return val;
		},

		min: function(min){
			this._values.min = this.values(min, this._values.max).min;

			return this._values.min;
		},

		max: function(max){
			this._values.max = this.values(this._values.min, max).max;

			return this._values.max;
		},
		
		bounds: function(min, max){
			if ((typeof min !== "undefined") && (typeof max !== "undefined") 
				&& parseFloat(min) === min && parseFloat(max) === max && min < max){
				
				this._setBounds(min, max);
				this._changed(true);
			}
			
			return this.options.bounds;
		},

		_setBounds: function(min, max){
			this.options.bounds = {min: min, max: max};
			this._leftHandle("option", "bounds", this.options.bounds);
			this._rightHandle("option", "bounds", this.options.bounds);
			this._bar("option", "bounds", this.options.bounds);
		},

		zoomIn: function(quantity){
			this._bar("zoomIn", quantity)
		},

		zoomOut: function(quantity){
			this._bar("zoomOut", quantity);
		},

		scrollLeft: function(quantity){
			this._bar("startScroll");
			this._bar("scrollLeft", quantity);
			this._bar("stopScroll");
		},

		scrollRight: function(quantity){
			this._bar("startScroll");
			this._bar("scrollRight", quantity);
			this._bar("stopScroll");
		},
		
		/**
		 * Resize
		 */
		resize: function(){
			this._initWidth();
			this._leftHandle("update");
			this._rightHandle("update");
		},

		destroy: function(){
			this.element.removeClass("ui-rangeSlider-withArrows")
			.removeClass("ui-rangeSlider-noArrow");
			this.bar.detach();
			this.leftHandle.detach();
			this.rightHandle.detach();
			this.innerBar.detach();
			this.container.detach();
			this.arrows.left.detach();
			this.arrows.right.detach();
			this.element.removeClass("ui-rangeSlider");
			this._destroyLabels();
			delete this.options;

			$(window).unbind("resize", this._resizeProxy);

			$.Widget.prototype.destroy.apply(this, arguments);
		}
	});
})(jQuery);

/**
 * jQRangeSlider
 * A javascript slider selector that supports dates
 *
 * Copyright (C) Guillaume Gautreau 2012
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 */

(function($, undefined){
	"use strict";

	$.widget("ui.dateRangeSliderHandle", $.ui.rangeSliderHandle, {
		_steps: false,
		_boundsValues: {},

		_create: function(){
			$.ui.rangeSliderHandle.prototype._create.apply(this);
			this._createBoundsValues();
		},

		_getValueForPosition: function(position){
			
			var raw = this._getRawValueForPositionAndBounds(position, this.options.bounds.min.valueOf(), this.options.bounds.max.valueOf());

			return this._constraintValue(new Date(raw));
		},

		_setOption: function(key, value){
			if (key === "step"){
				this.options.step = value;
				this._createSteps();
				this.update();
				return;
			}

			$.ui.rangeSliderHandle.prototype._setOption.apply(this, [key, value]);

			if (key === "bounds"){
				this._createBoundsValues();
			}
		},

		_createBoundsValues: function(){
			this._boundsValues = {
					min: this.options.bounds.min.valueOf(),
					max: this.options.bounds.max.valueOf()
			};
		},

		_bounds: function(){
			return this._boundsValues;
		},

		_createSteps: function(){
			if (this.options.step === false || !this._isValidStep()){
				this._steps = false;
				return;
			}

			var minDate = new Date(this.options.bounds.min),
				maxDate = new Date(this.options.bounds.max),
				stepDate = minDate,
				i = 0;

			this._steps = [];

			while (stepDate <= maxDate){
				this._steps.push(stepDate.valueOf());

				stepDate = this._addStep(minDate, i, this.options.step);
				i++;
			}
		},

		_isValidStep: function(){
			return typeof this.options.step === "object";
		},

		_addStep: function(reference, factor, step){
			var result = new Date(reference.valueOf());

			result = this._addThing(result, "FullYear", factor, step.years);
			result = this._addThing(result, "Month", factor, step.months);
			result = this._addThing(result, "Date", factor, step.days);
			result = this._addThing(result, "Hours", factor, step.hours);
			result = this._addThing(result, "Minutes", factor, step.minutes);
			result = this._addThing(result, "Seconds", factor, step.seconds);

			return result;
		},

		_addThing: function(date, thing, factor, base){
			if (factor === 0 || (base || 0) === 0){
				return date;
			}

			date["set" + thing](
				date["get" + thing]() + factor * (base || 0)
				);

			return date;
		},

		_round: function(value){
			if (this._steps === false){
				return value;
			}

			var max = this.options.bounds.max.valueOf(),
				min = this.options.bounds.min.valueOf(),
				ratio = Math.max(0, (value - min) / (max - min)),
				index = Math.floor(this._steps.length * ratio),
				before, after;

			while (this._steps[index] > value){
				index--;
			}

			while (index + 1 < this._steps.length && this._steps[index + 1] <= value){
				index++;
			}

			if (index >= this._steps.length - 1){
				return this._steps[this._steps.length - 1];
			} else if (index == 0){
				return this._steps[0];
			}

			before = this._steps[index];
			after = this._steps[index + 1];

			if (value - before < after - value){
				return before;
			}

			return after;
		},

		update: function(){
			this._createBoundsValues();
			this._createSteps();
			$.ui.rangeSliderHandle.prototype.update.apply(this);
		},

		add: function(date, step){
			return this._addStep(new Date(date), 1, step).valueOf();
		},

		substract: function(date, step){
			return this._addStep(new Date(date), -1, step).valueOf();
		},

		stepsBetween: function(date1, date2){
			if (this.options.step === false){
				return val2 - val1;
			}

			var min = Math.min(date1, date2),
				max = Math.max(date1, date2),
				steps = 0,
				negative = false,
				negativeResult = date1 > date2;

			if (this.add(min, this.options.step) - min < 0){
				negative = true;
			}

			while (min < max){
					if (negative){
						max = this.add(max, this.options.step);
					}else{
						min = this.add(min, this.options.step);	
					}
					
					steps++;
				}

			return negativeResult ? -steps : steps;
		},

		multiplyStep: function(step, factor){
			var result = {};

			for (var name in step){
				result[name] = step[name] * factor;
			}

			return result;
		},

		stepRatio: function(){
			if (this.options.step == false){
				return 1;
			}else{
				var steps = this._steps.length;
				return this.cache.parent.width / steps;
			}
		}
	});
})(jQuery);

/**
 * jQRangeSlider
 * A javascript slider selector that supports dates
 *
 * Copyright (C) Guillaume Gautreau 2012
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 */

(function ($, undefined) {
	"use strict";
	
	$.widget("ui.dateRangeSlider", $.ui.rangeSlider, {
		options: {
			bounds: {min: new Date(2010,0,1), max: new Date(2012,0,1)},
			defaultValues: {min: new Date(2010,1,11), max: new Date(2011,1,11)}
		},

		_create: function(){
			$.ui.rangeSlider.prototype._create.apply(this);

			this.element.addClass("ui-dateRangeSlider");
		},

		destroy: function(){
			this.element.removeClass("ui-dateRangeSlider");
			$.ui.rangeSlider.prototype.destroy.apply(this);
		},

		_setOption: function(key, value){
			if ((key === "defaultValues" || key === "bounds") && typeof value !== "undefined" && value !== null && typeof value.min !== "undefined" && typeof value.max !== "undefined" && value.min instanceof Date && value.max instanceof Date){
				$.ui.rangeSlider.prototype._setOption.apply(this, [key, {min:value.min.valueOf(), max:value.max.valueOf()}]);
			}else{
				$.ui.rangeSlider.prototype._setOption.apply(this, this._toArray(arguments));
			}
		},

		_handleType: function(){
			return "dateRangeSliderHandle";
		},

		option: function(key, value){
			if (key === "bounds" || key === "defaultValues"){
				var result = $.ui.rangeSlider.prototype.option.apply(this, arguments);

				return {min:new Date(result.min), max:new Date(result.max)};
			}

			return $.ui.rangeSlider.prototype.option.apply(this, this._toArray(arguments));
		},

		_defaultFormatter: function(value){
			var month = value.getMonth() + 1,
				day = value.getDate();

			return "" + value.getFullYear() + "-" + (month < 10 ? "0" + month : month) + "-" + (day < 10 ? "0" + day : day);
		},

		_getFormatter: function(){
			var formatter = this.options.formatter;

			if (this.options.formatter === false || this.options.formatter === null){
				formatter = this._defaultFormatter;
			}

			return (function(formatter){
				return function(value){
					return formatter(new Date(value));
				}
			})(formatter);
		},

		values: function(min, max){
			var values = null;
			
			if (typeof min !== "undefined" && typeof max !== "undefined" && min instanceof Date && max instanceof Date)
			{
				values = $.ui.rangeSlider.prototype.values.apply(this, [min.valueOf(), max.valueOf()]);
			}else{
				values = $.ui.rangeSlider.prototype.values.apply(this, this._toArray(arguments));
			}

			return {min: new Date(values.min), max: new Date(values.max)};
		},

		min: function(min){
			if (typeof min !== "undefined" && min instanceof Date){
				return new Date($.ui.rangeSlider.prototype.min.apply(this, [min.valueOf()]));
			}

			return new Date($.ui.rangeSlider.prototype.min.apply(this));
		},

		max: function(max){
			if (typeof max !== "undefined" && max instanceof Date){
				return new Date($.ui.rangeSlider.prototype.max.apply(this, [max.valueOf()]));
			}

			return new Date($.ui.rangeSlider.prototype.max.apply(this));
		},
		
		bounds: function(min, max){
			var result;
			
			if (typeof min !== "undefined" && min instanceof Date
						&& typeof max !== "undefined" && max instanceof Date) {
				result = $.ui.rangeSlider.prototype.bounds.apply(this, [min.valueOf(), max.valueOf()]);
			} else {
				result = $.ui.rangeSlider.prototype.bounds.apply(this, this._toArray(arguments));
			}
			
			return {min: new Date(result.min), max: new Date(result.max)};
		},

		_toArray: function(argsObject){
			return Array.prototype.slice.call(argsObject);
		}
	});
})(jQuery);

/**
 * jQRangeSlider
 * A javascript slider selector that supports dates
 *
 * Copyright (C) Guillaume Gautreau 2012
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 */

 (function($){

 	$.widget("ui.editRangeSliderLabel", $.ui.rangeSliderLabel, {
 		options: {
 			type: "text",
 			step: false,
 			id: ""
 		},

 		_input: null,
 		_text: "",

 		_create: function(){
 			$.ui.rangeSliderLabel.prototype._create.apply(this);

 			this._createInput();
 		},

 		_setOption: function(key, value){
 			if (key === "type"){
 				this._setTypeOption(value);
 			} else if (key === "step") {
 				this._setStepOption(value);
 			}

 			$.ui.rangeSliderLabel.prototype._setOption.apply(this, [key, value]);
 		},

 		_createInput: function(){
 			this._input = $("<input type='" + this.options.type + "' />")
 				.addClass("ui-editRangeSlider-inputValue")
 				.appendTo(this._valueContainer);

 			this._setInputName();

 			this._input.bind("keyup", $.proxy(this._onKeyUp, this));
 			this._input.blur($.proxy(this._onChange, this));

 			if (this.options.type === "number"){
 				if (this.options.step !== false){
 					this._input.attr("step", this.options.step);
 				}

 				this._input.click($.proxy(this._onChange, this));
 			}

 			this._input.val(this._text);
 		},

 		_setInputName: function(){
 			var name = this.options.isLeft ? "left" : "right";

 			this._input.attr("name", this.options.id + name);
 		},

 		_onSwitch: function(event, isLeft){
 			$.ui.rangeSliderLabel.prototype._onSwitch.apply(this, [event, isLeft]);

 			this._setInputName();
 		},

 		_destroyInput: function(){
 			this._input.detach();
 			this._input = null;
 		},

 		_onKeyUp: function(e){
 			if (e.which == 13){
				this._onChange(e);
				return false;
			}
 		},

 		_onChange: function(e){
 			var value = this._returnCheckedValue(this._input.val());

 			if (value !== false){
 				this._triggerValue(value);
 			}
 		},

 		_triggerValue: function(value){
 			var isLeft = this.options.handle[this.options.handleType]("option", "isLeft");

 			this.element.trigger("valueChange", [{
 					isLeft: isLeft,
 					value: value
 				}]);
 		},

 		_returnCheckedValue: function(val){
			var floatValue = parseFloat(val);

			if (isNaN(floatValue) || floatValue.toString() != val){
				return false;
			}

			return floatValue;
		},

 		_setTypeOption: function(value){
 			if ((value === "text" || value === "number") && this.options.type != value){
 				this._destroyInput();
 				this.options.type = value;
 				this._createInput();
 			}
 		},

 		_setStepOption: function(value){
 			this.options.step = value;

 			if (this.options.type === "number"){
 				this._input.attr("step", value !== false ? value : "any");
 			}
 		},

 		_displayText: function(text){
 			this._input.val(text);
 			this._text = text;
 		}

 	});


 })(jQuery);
 
 /**
 * jQRangeSlider
 * A javascript slider selector that supports dates
 *
 * Copyright (C) Guillaume Gautreau 2012
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 */

 (function ($, undefined) {
	"use strict";
	
	$.widget("ui.editRangeSlider", $.ui.rangeSlider, {
		options:{
			type: "text",
			round: 1
		},

		_create: function(){
			$.ui.rangeSlider.prototype._create.apply(this);

			this.element.addClass("ui-editRangeSlider");
		},

		destroy: function(){
			this.element.removeClass("ui-editRangeSlider");

			$.ui.rangeSlider.prototype.destroy.apply(this);
		},

		_setOption: function(key, value){
			if (key === "type" || key === "step"){
				this._setLabelOption(key, value);
			}	

			if (key === "type"){
				this.options[key] = this.labels.left === null ? value : this._leftLabel("option", key);
			}

			$.ui.rangeSlider.prototype._setOption.apply(this, [key, value]);
		},

		_setLabelOption: function(key, value){
			if (this.labels.left !== null){
				this._leftLabel("option", key, value);
				this._rightLabel("option", key, value);
			}
		},

		_labelType: function(){
			return "editRangeSliderLabel";
		},

		_createLabel: function(label, handle){
			var result = $.ui.rangeSlider.prototype._createLabel.apply(this, [label, handle]);
			
			if (label === null){
				result.bind("valueChange", $.proxy(this._onValueChange, this));
			}

			return result;
		},

		_addPropertiesToParameter: function(parameters){
			parameters.type = this.options.type;
			parameters.step = this.options.step;
			parameters.id = this.element.attr("id");

			return parameters;
		},

		_getLabelConstructorParameters: function(label, handle){
			var parameters = $.ui.rangeSlider.prototype._getLabelConstructorParameters.apply(this, [label, handle]);

			return this._addPropertiesToParameter(parameters);
		},

		_getLabelRefreshParameters: function(label, handle){
			var parameters = $.ui.rangeSlider.prototype._getLabelRefreshParameters.apply(this, [label, handle]);

			return this._addPropertiesToParameter(parameters);
		},

		_onValueChange: function(event, data){
			if (data.isLeft){
				this.min(data.value);
			}else{
				this.max(data.value);
			}
		}
	});

})(jQuery);
 