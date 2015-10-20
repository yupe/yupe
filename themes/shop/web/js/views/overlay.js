(function () {
    'use strict';

    function ShowElementAsOverlay(options) {
        options = options || {};
        options.addClass = options.addClass || [];
        options.removeClass = options.removeClass || [];
        options.overlayClass = options.overlayClass || [];

        this.container = options.container || document.body;
        return this.init(options);
    }

    ShowElementAsOverlay.prototype.init = function (options) {
        var _this = this;

        this.overlayContainer = document.createElement('div');
        this.overlayedElement = null;

        options.overlayClass.forEach(function (name) {
            _this.overlayContainer.classList.add(name);
        });

        return function showElementAsOverlay(el) {
            if (el === _this.overlayedElement) {
                return;
            } else {
                _this.overlayedElement = el;
            }

            while (_this.overlayContainer.firstChild) {
                _this.overlayContainer.removeChild(_this.overlayContainer.firstChild);
            }

            if (el) {
                var nodeCopy = el.cloneNode(true),
                    bodyRect = 0,
                    nodeRect = el.getBoundingClientRect();

                if (options.position === 'absolute') {
                    bodyRect = document.body.getBoundingClientRect();
                }

                if (options.removeClass) {
                    options.removeClass.forEach(function (name) {
                        nodeCopy.classList.remove(name);
                    });
                }

                if (options.addClass) {
                    options.addClass.forEach(function (name) {
                        nodeCopy.classList.add(name);
                    });
                }

                _this.overlayContainer.style.position = options.position;
                _this.overlayContainer.style.zIndex = 1000;
                _this.overlayContainer.style.top = nodeRect.top - bodyRect.top + 'px';
                _this.overlayContainer.style.left = nodeRect.left - bodyRect.left + 'px';
                _this.overlayContainer.appendChild(nodeCopy);
                _this.container.appendChild(_this.overlayContainer);

                return _this.overlayContainer;
            } else {
                _this.overlayContainer.parentElement && _this.overlayContainer.parentElement.removeChild(_this.overlayContainer);

                return null;
            }
        };
    };

    ShowElementAsOverlay.jQuery = {
        facade: function (options) {
            options = options || {};
            options.position = options.position || 'absolute';

            if (this.length > 1) {
                options.container = this.first()[0];
                console.info('ShowElementAsOverlay function can’t into collections. Only first element is used.');
            } else {
                options.container = this[0] || document.body;
            }

            return (new ShowElementAsOverlay(options));
        }
    };

    $.fn.showElementAsOverlay = ShowElementAsOverlay.jQuery.facade;


    var $root = $('.js-overlay-items'),
        showOverlay;

    showOverlay = $root.showElementAsOverlay({
        addClass: [],
        overlayClass: [
            'js-overlay-copy'
        ]
    });

    $root.on('mouseenter', '.js-overlay-item', function () {
        showOverlay($(this).children().first()[0]);
    }).on('mouseleave', '.js-overlay-copy', function () {
        showOverlay(null);
    });
})();
