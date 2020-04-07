/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 7);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Accordion = function () {
	function Accordion($element) {
		var _this = this;

		_classCallCheck(this, Accordion);

		this.$accordion = $element;
		this.$accordionTitle = this.$accordion.children('.accordion__title');
		this.$accordionContent = this.$accordion.children('.accordion__content');

		//events
		this.$accordionTitle.on('click', function (e) {
			return _this.onAccordionClick(e);
		});
	}

	_createClass(Accordion, [{
		key: 'onAccordionClick',
		value: function onAccordionClick(e) {
			var _this2 = this;

			e.preventDefault();

			this.$accordionContent.slideToggle(300, 'swing', function () {
				_this2.$accordion.toggleClass('accordion--opened');
			});
		}
	}]);

	return Accordion;
}();

exports.default = Accordion;

/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var DocSearch = function () {
	function DocSearch($element) {
		var _this = this;

		_classCallCheck(this, DocSearch);

		this.$searchInput = $element.find('input');
		this.$searchResults = $element.find('.doc-search__results');
		this.nonce = this.$searchInput.attr('data-nonce');
		this.postType = this.$searchInput.attr('data-post-type');

		//events
		this.$searchInput.on('keyup', function (e) {
			return _this.onKeyUp(e);
		});
	}

	_createClass(DocSearch, [{
		key: 'onKeyUp',
		value: function onKeyUp(e) {
			var _this2 = this;

			e.preventDefault();

			var value = this.$searchInput.val();
			clearTimeout(this.timeout);

			if (value.length <= 3) {
				this.$searchResults.hide().html("");
			} else {
				this.$searchResults.show().html('<p class="mb-0">Searching for articles: <strong>' + value + '</strong></p>');
				this.timeout = setTimeout(function () {
					return _this2.makeAjaxCall();
				}, 500);
			}
		}
	}, {
		key: 'makeAjaxCall',
		value: function makeAjaxCall() {
			var _this3 = this;

			jQuery.ajax({
				type: "POST",
				data: { action: "modula_search_articles", nonce: this.nonce, post_type: this.postType, s: this.$searchInput.val() },
				url: modula.ajaxurl,
				success: function success(html) {
					_this3.$searchResults.show().html(html);
				}
			});
		}
	}]);

	return DocSearch;
}();

exports.default = DocSearch;

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Footer = function () {
	function Footer($element) {
		_classCallCheck(this, Footer);

		this.$footer = $element;

		this.initOdometer();
	}

	_createClass(Footer, [{
		key: 'initOdometer',
		value: function initOdometer() {
			var _this = this;

			if (typeof Waypoint === "undefined") {
				return;
			}

			new Waypoint({
				element: this.$footer,
				offset: '70%',
				handler: function handler(direction) {
					_this.$footer.find('.odometer').html(1093111);
				}
			});
		}
	}]);

	return Footer;
}();

exports.default = Footer;

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Header = function () {
	function Header($element) {
		_classCallCheck(this, Header);

		this.$header = $element;
		this.$mainMenu = this.$header.find('.main-menu');
		this.$menuIcon = this.$header.find('.menu-icon');
		this.$mainMenu.find('.menu-item-has-children').append('<div class="menu-arrow"></div>');
		this.$menuArrow = this.$mainMenu.find('.menu-arrow');

		this.initSticky();
		this.initMenu();
	}

	_createClass(Header, [{
		key: 'initSticky',
		value: function initSticky() {
			var _this = this;

			if (jQuery('body').hasClass('page-template-checkout')) {
				return;
			}

			if (jQuery('body').hasClass('page-template-pricing')) {
				return;
			}

			if (jQuery('body').hasClass('page-template-pricing-2')) {
				return;
			}

			window.addEventListener('scroll', function () {
				return _this.makeSticky();
			});
		}
	}, {
		key: 'makeSticky',
		value: function makeSticky() {

			if (window.pageYOffset > 0) {
				this.$header.addClass('header--sticky');
			} else {
				this.$header.removeClass('header--sticky');
			}
		}
	}, {
		key: 'initMenu',
		value: function initMenu() {
			var _this2 = this;

			this.$menuArrow.on('click', function (e) {
				jQuery(e.target).toggleClass('menu-arrow--open');
				jQuery(e.target).siblings('.sub-menu').toggleClass('sub-menu--open');
			});

			this.$menuIcon.on('click', function () {
				_this2.$menuIcon.toggleClass('menu-icon--open');
				_this2.$mainMenu.toggleClass('main-menu--open');
			});
		}
	}]);

	return Header;
}();

exports.default = Header;

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Modal = function () {
	function Modal($element, $trigger) {
		var _this = this;

		_classCallCheck(this, Modal);

		this.$modal = $element;
		this.$trigger = $trigger;

		//events
		this.$trigger.on('click', function (e) {
			return _this.openModal(e);
		});
		this.$modal.find('.modal__overlay, .modal__close').on('click', function (e) {
			return _this.closeModal(e);
		});
	}

	_createClass(Modal, [{
		key: 'openModal',
		value: function openModal(e) {
			e.preventDefault();
			this.$modal.addClass('modal--open');
		}
	}, {
		key: 'closeModal',
		value: function closeModal(e) {
			e.preventDefault();
			this.$modal.removeClass('modal--open');
			document.dispatchEvent(new Event('modal-closed'));
		}
	}]);

	return Modal;
}();

exports.default = Modal;

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var TopBar = function () {
	function TopBar($element) {
		_classCallCheck(this, TopBar);

		this.$sidebar = $element;

		if (typeof Waypoint === "undefined") {
			return;
		}

		if (jQuery('.post-sidebar').length == 0) {
			return;
		}

		if (jQuery('body').hasClass('page-template-extension')) {
			return;
		}

		this.initSticky();
	}

	_createClass(TopBar, [{
		key: 'initSticky',
		value: function initSticky() {
			var _this = this;

			// make the post navigation stick
			new Waypoint({
				element: jQuery('.post-content'),
				offset: '200px',
				handler: function handler(direction) {
					if ('down' === direction) {
						_this.$sidebar.addClass('stick');
					}
					if ('up' === direction) {
						_this.$sidebar.removeClass('stick');
					}
				}
			});

			// hide the post sidebar when reaching the bottom of the post
			new Waypoint({
				element: jQuery('.main-section'),
				offset: 'bottom-in-view',
				handler: function handler(direction) {
					if ('down' === direction) {
						_this.$sidebar.css({ 'top': jQuery('.post-content').height() - _this.$sidebar.height() });
						_this.$sidebar.removeClass('stick');
					}
					if ('up' === direction) {
						_this.$sidebar.css({ 'top': '' });
						_this.$sidebar.addClass('stick');
					}
				}
			});

			// hide/show the post navigation when hovering over alignwide and alignfull elements
			jQuery('.post-content .alignwide, .post-content .alignfull').on('mouseenter', function () {
				_this.$sidebar.addClass('invisible');
			});

			jQuery('.post-content .alignwide, .post-content .alignfull').on('mouseleave', function () {
				_this.$sidebar.removeClass('invisible');
			});
		}
	}]);

	return TopBar;
}();

exports.default = TopBar;

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var TopBar = function () {
	function TopBar($element) {
		var _this = this;

		_classCallCheck(this, TopBar);

		this.$topbar = $element;

		//events
		this.$topbar.find('.topbar-section__close').on('click', function (e) {
			return _this.onCloseClick(e);
		});
	}

	_createClass(TopBar, [{
		key: 'onCloseClick',
		value: function onCloseClick(e) {
			e.preventDefault();
			this.$topbar.addClass('topbar-section--closed');

			var exdate = new Date();
			exdate.setDate(exdate.getDate() + 10);
			document.cookie = "st_top_bar_section_closed=true; expires=" + exdate.toUTCString();
		}
	}]);

	return TopBar;
}();

exports.default = TopBar;

/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _Header = __webpack_require__(3);

var _Header2 = _interopRequireDefault(_Header);

var _TopBar = __webpack_require__(6);

var _TopBar2 = _interopRequireDefault(_TopBar);

var _Sidebar = __webpack_require__(5);

var _Sidebar2 = _interopRequireDefault(_Sidebar);

var _Footer = __webpack_require__(2);

var _Footer2 = _interopRequireDefault(_Footer);

var _Accordion = __webpack_require__(0);

var _Accordion2 = _interopRequireDefault(_Accordion);

var _DocSearch = __webpack_require__(1);

var _DocSearch2 = _interopRequireDefault(_DocSearch);

var _Modal = __webpack_require__(4);

var _Modal2 = _interopRequireDefault(_Modal);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var ST = function () {
	function ST() {
		_classCallCheck(this, ST);

		this.initHeader();
		this.initTopBar();
		this.initScrollAnimation();
		this.initAccordions();
		this.initDocSearch();
		this.initModals();
		this.initSidebar();
		this.initFooter();
		this.initAccountPage();
	}

	_createClass(ST, [{
		key: 'initHeader',
		value: function initHeader() {
			new _Header2.default(jQuery('.header'));
		}
	}, {
		key: 'initTopBar',
		value: function initTopBar() {
			new _TopBar2.default(jQuery('.topbar-section'));
		}
	}, {
		key: 'initSidebar',
		value: function initSidebar() {
			//new Sidebar( jQuery('.post-sidebar') );
		}
	}, {
		key: 'initFooter',
		value: function initFooter() {
			//new Footer( jQuery('.footer-section') );
		}
	}, {
		key: 'initAccountPage',
		value: function initAccountPage() {
			if (!jQuery('body').hasClass('page-template-account')) {
				return;
			}

			jQuery('.edd-manage-license-back').attr('href', '/account');
		}
	}, {
		key: 'initScrollAnimation',
		value: function initScrollAnimation() {

			jQuery('a[href*="#"]:not([href="#"])').on('click', function (e) {
				var target = void 0;
				if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
					target = jQuery(this.hash);
					target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
					if (target.length) {
						e.preventDefault();
						jQuery('html, body').animate({ scrollTop: target.offset().top }, 1000, 'swing');
					}
				}
			});
		}
	}, {
		key: 'initAccordions',
		value: function initAccordions() {
			var $elements = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : jQuery(".accordion");

			$elements.each(function (index) {
				new _Accordion2.default(jQuery(this));
			});
		}
	}, {
		key: 'initDocSearch',
		value: function initDocSearch() {
			var $elements = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : jQuery(".doc-search");

			$elements.each(function () {
				new _DocSearch2.default(jQuery(this));
			});
		}
	}, {
		key: 'initModals',
		value: function initModals() {
			new _Modal2.default(jQuery('.modal--login'), jQuery('.login-link'));
		}
	}]);

	return ST;
}();

new ST();

/***/ })
/******/ ]);