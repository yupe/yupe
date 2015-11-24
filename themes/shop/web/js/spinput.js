(function () {
	'use strict';

	var LEFT_MOUSE_BUTTON = 1,
		VK_UP = 38,
		VK_DOWN = 40;

	function Spinput(container) {
		this.container = $(container);
		this.doc = $(document);
		this.input = $('input', container);

		this.onMinusMousedown_ = this.onMinusMousedown_.bind(this);
		this.onPlusMousedown_ = this.onPlusMousedown_.bind(this);
		this.onMouseUp_ = this.onMouseUp_.bind(this);
		this.doRoll_ = this.doRoll_.bind(this);
		this.onInputKeydown_ = this.onInputKeydown_.bind(this);
		this.onInputChange_ = this.onInputChange_.bind(this);
		this.onKeyUp_ = this.onKeyUp_.bind(this);

		this.init_();
		this.attach_();
	}

	Spinput.jQuery = {
		facade: function () {
			this.each(function () {
				new Spinput(this);
			});
		}
	};

	Spinput.prototype.init_ = function () {
		var maxValue = this.getMaxValue_(),
			minValue = this.getMinValue_(),
			maxValueLength = maxValue.toString().length,
			minValueLength = minValue.toString().length,
			maxLength = Math.max(minValueLength, maxValueLength);

		this.input.attr('maxlength', maxLength);
		this.setValue(this.getValue());
	};

	Spinput.prototype.attach_ = function () {
		this.container
			.on('mousedown', '.js-spinput__minus', this.onMinusMousedown_)
			.on('mousedown', '.js-spinput__plus', this.onPlusMousedown_);

		this.input
			.on('keydown', this.onInputKeydown_)
			.on('change', this.onInputChange_);
	};

	Spinput.prototype.setValue = function (value, triggerEvent) {
		var validValue = this.getClosestValidValue_(value);

		this.lastValidValue_ = validValue;

		if (typeof triggerEvent === 'undefined') {
			triggerEvent = true;
		}

		if (triggerEvent) {
			this.input.val(validValue).trigger('change');
		} else {
			this.input.val(validValue);
		}
	};

	Spinput.prototype.getValue = function () {
		var value = Number(this.input.val());

		if (isNaN(value)) {
			value = 0;
		}

		return value;
	};

	Spinput.prototype.onMinusMousedown_ = function (event) {
		if (event.which !== LEFT_MOUSE_BUTTON) {
			return;
		}

		event.preventDefault();
		this.doc.on('mouseup', this.onMouseUp_);

		this.setValue(this.getValue() - 1);
		this.roll_(-1);
	};

	Spinput.prototype.onPlusMousedown_ = function (event) {
		if (event.which !== LEFT_MOUSE_BUTTON) {
			return;
		}

		event.preventDefault();
		this.doc.on('mouseup', this.onMouseUp_);

		this.setValue(this.getValue() + 1);
		this.roll_(1);
	};

	Spinput.prototype.onMouseUp_ = function (event) {
		if (event.which !== LEFT_MOUSE_BUTTON) {
			return;
		}

		event.preventDefault();
		this.cancelRoll_();
	};

	Spinput.prototype.onKeyUp_ = function (event) {
		event.preventDefault();
		this.cancelRoll_();
	};

	Spinput.prototype.isKeycodeAllowed_ = function (code) {
		var allowKeyCodes = [
			[9],       // tab
			[48, 57],  // digits
			[8],       // backspace
			[37, 40],  // arrows
			[46],      // delete
			[96, 105], // num digits
			[189],     // minus
			[109]      // num-minus
		];

		for (var i = allowKeyCodes.length; i--;) {
			var range = allowKeyCodes[i];

			if (range.length === 1) {
				if (range[0] === code) {
					return true;
				}
			} else {
				if (range[0] <= code && code <= range[1]) {
					return true;
				}
			}
		}

		return false;
	};


	Spinput.prototype.getClosestValidValue_ = function (value) {
		var minValue = this.getMinValue_(),
			maxValue = this.getMaxValue_();

		if (/^\s*$/.test(value)) {
			return this.lastValidValue_;
		}

		if (isNaN(value = Number(value))) {
			return this.lastValidValue_;
		}

		if (value > maxValue) {
			value = maxValue;
		}

		if (value < minValue) {
			value = minValue;
		}

		return value;
	};

	Spinput.prototype.onInputKeydown_ = function (event) {
		var code = event.keyCode;

		if (!this.isKeycodeAllowed_(code)) {
			event.preventDefault();
		}

		if (code === VK_UP) {
			this.setValue(this.getValue() + 1);
		}

		if (code === VK_DOWN) {
			this.setValue(this.getValue() - 1);
		}
	};

	Spinput.prototype.onInputChange_ = function () {
		this.setValue(this.input.val(), false);
	};

	Spinput.prototype.getMinValue_ = function () {
		var min = Number(this.container.data('minValue'));

		if (isNaN(min)) {
			min = -999;
		}

		return min;
	};

	Spinput.prototype.getMaxValue_ = function () {
		var max = Number(this.container.data('maxValue'));

		if (isNaN(max)) {
			max = 999;
		}

		return max;
	};

	Spinput.prototype.roll_ = function (delta) {
		this.rollDelta_ = delta;
		clearTimeout(this.rollTimeout_);
		this.rollTimeout_ = setTimeout(this.doRoll_, 300);
	};

	Spinput.prototype.cancelRoll_ = function () {
		this.rollDelta_ = 0;
		clearTimeout(this.rollTimeout_);
	};

	Spinput.prototype.doRoll_ = function () {
		var F = this.doRoll_;

		if (!this.rollDelta_) {
			return;
		}

		this.setValue(this.getValue() + this.rollDelta_);

		this.rollTimeout_ = setTimeout(function () {
			requestAnimationFrame(F);
		}, 56);
	};

	$.fn.spinput = Spinput.jQuery.facade;
}());
