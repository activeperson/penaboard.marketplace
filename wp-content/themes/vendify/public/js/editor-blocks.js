/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
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
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 78);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

module.exports = _defineProperty;

/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
  Copyright (c) 2016 Jed Watson.
  Licensed under the MIT License (MIT), see
  http://jedwatson.github.io/classnames
*/
/* global define */

(function () {
	'use strict';

	var hasOwn = {}.hasOwnProperty;

	function classNames () {
		var classes = [];

		for (var i = 0; i < arguments.length; i++) {
			var arg = arguments[i];
			if (!arg) continue;

			var argType = typeof arg;

			if (argType === 'string' || argType === 'number') {
				classes.push(arg);
			} else if (Array.isArray(arg)) {
				classes.push(classNames.apply(null, arg));
			} else if (argType === 'object') {
				for (var key in arg) {
					if (hasOwn.call(arg, key) && arg[key]) {
						classes.push(key);
					}
				}
			}
		}

		return classes.join(' ');
	}

	if ( true && module.exports) {
		module.exports = classNames;
	} else if (true) {
		// register as 'classnames', consistent with npm package name
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
			return classNames;
		}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}());


/***/ }),
/* 2 */
/***/ (function(module, exports) {

module.exports = lodash;

/***/ }),
/* 3 */,
/* 4 */
/***/ (function(module, exports) {

function _assertThisInitialized(self) {
  if (self === void 0) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }

  return self;
}

module.exports = _assertThisInitialized;

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

var defineProperty = __webpack_require__(0);

function _objectSpread(target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i] != null ? arguments[i] : {};
    var ownKeys = Object.keys(source);

    if (typeof Object.getOwnPropertySymbols === 'function') {
      ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) {
        return Object.getOwnPropertyDescriptor(source, sym).enumerable;
      }));
    }

    ownKeys.forEach(function (key) {
      defineProperty(target, key, source[key]);
    });
  }

  return target;
}

module.exports = _objectSpread;

/***/ }),
/* 6 */
/***/ (function(module, exports) {

function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}

module.exports = _classCallCheck;

/***/ }),
/* 7 */
/***/ (function(module, exports) {

function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
  }
}

function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  return Constructor;
}

module.exports = _createClass;

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

var _typeof = __webpack_require__(64);

var assertThisInitialized = __webpack_require__(4);

function _possibleConstructorReturn(self, call) {
  if (call && (_typeof(call) === "object" || typeof call === "function")) {
    return call;
  }

  return assertThisInitialized(self);
}

module.exports = _possibleConstructorReturn;

/***/ }),
/* 9 */
/***/ (function(module, exports) {

function _getPrototypeOf(o) {
  module.exports = _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
    return o.__proto__ || Object.getPrototypeOf(o);
  };
  return _getPrototypeOf(o);
}

module.exports = _getPrototypeOf;

/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

var setPrototypeOf = __webpack_require__(65);

function _inherits(subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function");
  }

  subClass.prototype = Object.create(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      writable: true,
      configurable: true
    }
  });
  if (superClass) setPrototypeOf(subClass, superClass);
}

module.exports = _inherits;

/***/ }),
/* 11 */,
/* 12 */,
/* 13 */,
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

var arrayWithoutHoles = __webpack_require__(66);

var iterableToArray = __webpack_require__(67);

var nonIterableSpread = __webpack_require__(68);

function _toConsumableArray(arr) {
  return arrayWithoutHoles(arr) || iterableToArray(arr) || nonIterableSpread();
}

module.exports = _toConsumableArray;

/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

var arrayWithHoles = __webpack_require__(61);

var iterableToArrayLimit = __webpack_require__(62);

var nonIterableRest = __webpack_require__(63);

function _slicedToArray(arr, i) {
  return arrayWithHoles(arr) || iterableToArrayLimit(arr, i) || nonIterableRest();
}

module.exports = _slicedToArray;

/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

if (false) { var throwOnDirectAccess, isValidElement, REACT_ELEMENT_TYPE; } else {
  // By explicitly using `prop-types` you are opting into new production behavior.
  // http://fb.me/prop-types-in-prod
  module.exports = __webpack_require__(74)();
}


/***/ }),
/* 17 */,
/* 18 */,
/* 19 */,
/* 20 */,
/* 21 */,
/* 22 */,
/* 23 */,
/* 24 */,
/* 25 */
/***/ (function(module, exports) {

function _extends() {
  module.exports = _extends = Object.assign || function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];

      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }

    return target;
  };

  return _extends.apply(this, arguments);
}

module.exports = _extends;

/***/ }),
/* 26 */,
/* 27 */,
/* 28 */,
/* 29 */,
/* 30 */,
/* 31 */,
/* 32 */,
/* 33 */,
/* 34 */,
/* 35 */,
/* 36 */,
/* 37 */,
/* 38 */,
/* 39 */,
/* 40 */,
/* 41 */,
/* 42 */,
/* 43 */,
/* 44 */,
/* 45 */,
/* 46 */,
/* 47 */,
/* 48 */,
/* 49 */,
/* 50 */,
/* 51 */,
/* 52 */,
/* 53 */,
/* 54 */,
/* 55 */,
/* 56 */,
/* 57 */,
/* 58 */,
/* 59 */,
/* 60 */,
/* 61 */
/***/ (function(module, exports) {

function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}

module.exports = _arrayWithHoles;

/***/ }),
/* 62 */
/***/ (function(module, exports) {

function _iterableToArrayLimit(arr, i) {
  var _arr = [];
  var _n = true;
  var _d = false;
  var _e = undefined;

  try {
    for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
      _arr.push(_s.value);

      if (i && _arr.length === i) break;
    }
  } catch (err) {
    _d = true;
    _e = err;
  } finally {
    try {
      if (!_n && _i["return"] != null) _i["return"]();
    } finally {
      if (_d) throw _e;
    }
  }

  return _arr;
}

module.exports = _iterableToArrayLimit;

/***/ }),
/* 63 */
/***/ (function(module, exports) {

function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance");
}

module.exports = _nonIterableRest;

/***/ }),
/* 64 */
/***/ (function(module, exports) {

function _typeof2(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof2 = function _typeof2(obj) { return typeof obj; }; } else { _typeof2 = function _typeof2(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof2(obj); }

function _typeof(obj) {
  if (typeof Symbol === "function" && _typeof2(Symbol.iterator) === "symbol") {
    module.exports = _typeof = function _typeof(obj) {
      return _typeof2(obj);
    };
  } else {
    module.exports = _typeof = function _typeof(obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : _typeof2(obj);
    };
  }

  return _typeof(obj);
}

module.exports = _typeof;

/***/ }),
/* 65 */
/***/ (function(module, exports) {

function _setPrototypeOf(o, p) {
  module.exports = _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
    o.__proto__ = p;
    return o;
  };

  return _setPrototypeOf(o, p);
}

module.exports = _setPrototypeOf;

/***/ }),
/* 66 */
/***/ (function(module, exports) {

function _arrayWithoutHoles(arr) {
  if (Array.isArray(arr)) {
    for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) {
      arr2[i] = arr[i];
    }

    return arr2;
  }
}

module.exports = _arrayWithoutHoles;

/***/ }),
/* 67 */
/***/ (function(module, exports) {

function _iterableToArray(iter) {
  if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter);
}

module.exports = _iterableToArray;

/***/ }),
/* 68 */
/***/ (function(module, exports) {

function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance");
}

module.exports = _nonIterableSpread;

/***/ }),
/* 69 */
/***/ (function(module, exports) {

/**
 * WordPress dependencies.
 *
 * @var vendifyEditorSettings
 */
var __ = wp.i18n.__;
var ServerSideRender = wp.components.ServerSideRender;
var registerBlockType = wp.blocks.registerBlockType;
var blockName = 'vendify/vendor-registration';

if (vendifyEditorSettings.hasVendorIntegration === "1") {
  /**
   * Register "Vendor Registration" block.
   *
   * @since 1.0.0
   *
   * @param  {string}   name     Block name.
   * @param  {Object}   settings Block settings.
   * @return {?WPBlock}          The block, if it has been successfully
   *                             registered; otherwise `undefined`.
   */
  registerBlockType(blockName, {
    title: __('Vendor Registration Form'),
    description: __('Add a form for guests to register to become a vendor.'),
    icon: 'feedback',
    category: 'vendify',
    keywords: [__('vendor'), __('register')],
    attributes: {},

    /**
     * Edit mode.
     *
     * @param {Object} props Block properties.
     * @return {string} Block HTML.
     */
    edit: function edit(props) {
      return React.createElement("div", {
        className: "block-with-disabled-style"
      }, React.createElement(ServerSideRender, {
        block: blockName,
        attributes: props.attributes
      }));
    },

    /**
     * Save mode.
     *
     * @return {null} Nothing.
     */
    save: function save() {
      return null;
    }
  });
}

/***/ }),
/* 70 */
/***/ (function(module, exports) {

/**
 * WordPress dependencies.
 *
 * @var vendifyEditorSettings
 */
var __ = wp.i18n.__;
var registerBlockType = wp.blocks.registerBlockType;
var _wp$components = wp.components,
    ServerSideRender = _wp$components.ServerSideRender,
    Placeholder = _wp$components.Placeholder;

if (vendifyEditorSettings.hasVendorIntegration === "1") {
  /**
   * Register "Vendor Registration" block.
   *
   * @since 1.0.0
   *
   * @param  {string}   name     Block name.
   * @param  {Object}   settings Block settings.
   * @return {?WPBlock}          The block, if it has been successfully
   *                             registered; otherwise `undefined`.
   */
  registerBlockType('vendify/vendor-dashboard', {
    title: __('Vendor Dashboard'),
    description: __('Add the Vendor dashboard. This block works only with the selected Vendor Dashboard page.'),
    icon: 'feedback',
    category: 'vendify',
    keywords: [__('vendor'), __('dashboard')],
    supports: {
      multiple: false,
      reusable: false,
      inserter: vendifyEditorSettings.isVendorDashboard === "1" || false
    },
    attributes: {},

    /**
     * Edit mode.
     *
     * @param {Object} props Block properties.
     * @return {string} Block HTML.
     */
    edit: function edit(props) {
      return React.createElement(Placeholder, {
        label: __('Vendor Dashboard'),
        icon: "feedback"
      }, React.createElement("p", null, __('This block will output the Vendor Dashboard, which is too large to fit here, the editor side.')));
    },

    /**
     * Save mode.
     *
     * @return {null} Nothing.
     */
    save: function save() {
      return null;
    }
  });
}

/***/ }),
/* 71 */
/***/ (function(module, exports) {

/**
 * WordPress dependencies.
 *
 * @var vendifyEditorSettings
 */
var __ = wp.i18n.__;
var ServerSideRender = wp.components.ServerSideRender;
var registerBlockType = wp.blocks.registerBlockType;
var Fragment = wp.element.Fragment;
var InspectorControls = wp.blockEditor.InspectorControls;
var _wp$components = wp.components,
    PanelBody = _wp$components.PanelBody,
    TextControl = _wp$components.TextControl,
    SelectControl = _wp$components.SelectControl,
    RangeControl = _wp$components.RangeControl;
var blockName = 'vendify/featured-vendors';

if (vendifyEditorSettings.hasVendorIntegration === "1") {
  /**
   * Register "Features Vendors" block.
   *
   * @since 1.0.0
   *
   * @param  {string}   name     Block name.
   * @param  {Object}   settings Block settings.
   * @return {?WPBlock}          The block, if it has been successfully
   *                             registered; otherwise `undefined`.
   */
  registerBlockType(blockName, {
    title: __('Featured Vendors'),
    description: __('Display the latest featured vendors.'),
    icon: 'groups',
    category: 'layout',
    keywords: [__('vendor'), __('featured')],
    attributes: {
      link: {
        type: 'string'
      },
      linkText: {
        type: 'string'
      },
      visitButtonStyle: {
        type: 'string'
      },
      rows: {
        type: 'Number'
      }
    },

    /**
     * Edit mode.
     *
     * @param {Object} props Block properties.
     * @return {string} Edit block mode.
     */
    edit: function edit(props) {
      var attributes = props.attributes,
          setAttributes = props.setAttributes;
      var link = attributes.link,
          linkText = attributes.linkText,
          visitButtonStyle = attributes.visitButtonStyle,
          rows = attributes.rows;
      return React.createElement(Fragment, null, React.createElement(InspectorControls, null, React.createElement(PanelBody, {
        title: __('"View more" Button')
      }, React.createElement(SelectControl, {
        label: __('Button Style'),
        value: visitButtonStyle,
        options: [{
          value: 'link',
          label: __('Classic')
        }, {
          value: 'btn-secondary',
          label: __('Button')
        }, {
          value: 'btn-outline-secondary',
          label: __('Outline Button')
        }],
        onChange: function onChange(newValue) {
          return setAttributes({
            visitButtonStyle: newValue
          });
        }
      }), React.createElement(TextControl, {
        label: __('"View More" URL'),
        value: link || '',
        onChange: function onChange(link) {
          setAttributes({
            link: link
          });
        }
      }), React.createElement(TextControl, {
        label: __('"View More" Text'),
        value: linkText || '',
        onChange: function onChange(linkText) {
          setAttributes({
            linkText: linkText
          });
        }
      })), React.createElement(PanelBody, {
        title: __('Layout')
      }, React.createElement(RangeControl, {
        label: __('Rows'),
        value: rows || 1,
        min: 1,
        max: 5,
        onChange: function onChange(rows) {
          setAttributes({
            rows: rows
          });
        }
      }))), React.createElement(ServerSideRender, {
        block: blockName,
        attributes: attributes
      }));
    },

    /**
     * Save mode.
     *
     * @return {null} Nothing.
     */
    save: function save() {
      return null;
    }
  });
}

/***/ }),
/* 72 */
/***/ (function(module, exports) {

/**
 * WordPress dependencies.
 */
var __ = wp.i18n.__;
var registerBlockType = wp.blocks.registerBlockType;
var InspectorControls = wp.blockEditor.InspectorControls;
var _wp$components = wp.components,
    Disabled = _wp$components.Disabled,
    PanelBody = _wp$components.PanelBody,
    TextControl = _wp$components.TextControl;
var ServerSideRender = wp.editor.ServerSideRender;
var Fragment = wp.element.Fragment;
/**
 * Register "Hero Search" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */

registerBlockType('vendify/hero-search', {
  title: __('Search Form'),
  description: __('Search for products or vendors.'),
  icon: 'search',
  category: 'vendify',
  keywords: [__('hero'), __('search')],
  attributes: {
    keywordPlaceholder: {
      type: 'string',
      default: 'Keyword...'
    },
    // locationPlaceholder: {
    // 	type: 'string',
    // 	default: 'Location...',
    // },
    searchValue: {
      type: 'string',
      default: 'Find'
    }
  },

  /**
   * Edit mode.
   */
  edit: function edit(_ref) {
    var attributes = _ref.attributes,
        setAttributes = _ref.setAttributes;
    return React.createElement(Fragment, null, React.createElement(InspectorControls, null, React.createElement(PanelBody, null, React.createElement(TextControl, {
      label: __('Keywords Placeholder'),
      value: attributes.keywordPlaceholder || '',
      onChange: function onChange(keywordPlaceholder) {
        setAttributes({
          keywordPlaceholder: keywordPlaceholder
        });
      }
    }), React.createElement(TextControl, {
      label: __('Vendor Location Placeholder'),
      value: attributes.locationPlaceholder || '',
      onChange: function onChange(locationPlaceholder) {
        setAttributes({
          locationPlaceholder: locationPlaceholder
        });
      }
    }), React.createElement(TextControl, {
      label: __('Submit Button'),
      value: attributes.searchValue || '',
      onChange: function onChange(searchValue) {
        setAttributes({
          searchValue: searchValue
        });
      }
    }))), React.createElement(Disabled, null, React.createElement(ServerSideRender, {
      block: "vendify/hero-search",
      attributes: attributes
    })));
  },

  /**
   * Save mode.
   *
   * Output handled on the server.
   *
   * @return null
   */
  save: function save() {
    return null;
  }
});

/***/ }),
/* 73 */
/***/ (function(module, exports) {

/**
 * WordPress dependencies.
 */
var __ = wp.i18n.__;
var ServerSideRender = wp.components.ServerSideRender;
var registerBlockType = wp.blocks.registerBlockType;
var Fragment = wp.element.Fragment;
var InspectorControls = wp.blockEditor.InspectorControls;
var _wp$components = wp.components,
    PanelBody = _wp$components.PanelBody,
    TextControl = _wp$components.TextControl,
    RangeControl = _wp$components.RangeControl,
    SelectControl = _wp$components.SelectControl;
var blockName = 'vendify/blog-posts';
/**
 * Register "Blog Posts" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */

registerBlockType(blockName, {
  title: __('Blog Posts'),
  description: __('Add a grid of recent blog posts.'),
  icon: 'admin-post',
  category: 'vendify',
  keywords: [__('blog'), __('post'), __('latest')],
  attributes: {
    link: {
      type: 'string'
    },
    linkText: {
      type: 'string'
    },
    cardStyle: {
      type: 'string'
    },
    visitButtonStyle: {
      type: 'string'
    },
    number: {
      type: 'number',
      default: 3
    }
  },

  /**
   * Edit mode.
   *
   * @param {Object} props Block properties.
   * @return {string} Edit block mode.
   */
  edit: function edit(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    var link = attributes.link,
        linkText = attributes.linkText,
        number = attributes.number,
        visitButtonStyle = attributes.visitButtonStyle,
        cardStyle = attributes.cardStyle;
    return React.createElement(Fragment, null, React.createElement(InspectorControls, null, React.createElement(PanelBody, {
      title: __('Grid Options')
    }, React.createElement(SelectControl, {
      label: __('Card Style'),
      value: cardStyle,
      options: [{
        value: 'classic',
        label: __('Classic')
      }, {
        value: 'card',
        label: __('Card')
      }, {
        value: 'dark',
        label: __('Dark')
      }],
      onChange: function onChange(newValue) {
        return setAttributes({
          cardStyle: newValue
        });
      }
    }), React.createElement(RangeControl, {
      label: __('Number of Posts'),
      value: number,
      onChange: function onChange(number) {
        return setAttributes({
          number: number
        });
      },
      min: 3,
      max: 99,
      step: 3
    })), React.createElement(PanelBody, {
      title: __('"View more" Button')
    }, React.createElement(SelectControl, {
      label: __('Button Style'),
      value: visitButtonStyle,
      options: [{
        value: 'link',
        label: __('Classic')
      }, {
        value: 'btn-primary',
        label: __('Button')
      }, {
        value: 'btn-outline-primary',
        label: __('Outline Button')
      }],
      onChange: function onChange(newValue) {
        return setAttributes({
          visitButtonStyle: newValue
        });
      }
    }), React.createElement(TextControl, {
      label: __('"View More" URL'),
      value: attributes.link || '',
      onChange: function onChange(link) {
        setAttributes({
          link: link
        });
      }
    }), React.createElement(TextControl, {
      label: __('"View More" Text'),
      value: attributes.linkText || '',
      onChange: function onChange(linkText) {
        setAttributes({
          linkText: linkText
        });
      }
    }))), React.createElement(ServerSideRender, {
      block: blockName,
      attributes: attributes
    }));
  },

  /**
   * Save mode.
   *
   * @return {null} Nothing.
   */
  save: function save() {
    return null;
  }
});

/***/ }),
/* 74 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */



var emptyFunction = __webpack_require__(75);
var invariant = __webpack_require__(76);
var ReactPropTypesSecret = __webpack_require__(77);

module.exports = function() {
  function shim(props, propName, componentName, location, propFullName, secret) {
    if (secret === ReactPropTypesSecret) {
      // It is still safe when called from React.
      return;
    }
    invariant(
      false,
      'Calling PropTypes validators directly is not supported by the `prop-types` package. ' +
      'Use PropTypes.checkPropTypes() to call them. ' +
      'Read more at http://fb.me/use-check-prop-types'
    );
  };
  shim.isRequired = shim;
  function getShim() {
    return shim;
  };
  // Important!
  // Keep this list in sync with production version in `./factoryWithTypeCheckers.js`.
  var ReactPropTypes = {
    array: shim,
    bool: shim,
    func: shim,
    number: shim,
    object: shim,
    string: shim,
    symbol: shim,

    any: shim,
    arrayOf: getShim,
    element: shim,
    instanceOf: getShim,
    node: shim,
    objectOf: getShim,
    oneOf: getShim,
    oneOfType: getShim,
    shape: getShim,
    exact: getShim
  };

  ReactPropTypes.checkPropTypes = emptyFunction;
  ReactPropTypes.PropTypes = ReactPropTypes;

  return ReactPropTypes;
};


/***/ }),
/* 75 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 *
 * 
 */

function makeEmptyFunction(arg) {
  return function () {
    return arg;
  };
}

/**
 * This function accepts and discards inputs; it has no side effects. This is
 * primarily useful idiomatically for overridable function endpoints which
 * always need to be callable, since JS lacks a null-call idiom ala Cocoa.
 */
var emptyFunction = function emptyFunction() {};

emptyFunction.thatReturns = makeEmptyFunction;
emptyFunction.thatReturnsFalse = makeEmptyFunction(false);
emptyFunction.thatReturnsTrue = makeEmptyFunction(true);
emptyFunction.thatReturnsNull = makeEmptyFunction(null);
emptyFunction.thatReturnsThis = function () {
  return this;
};
emptyFunction.thatReturnsArgument = function (arg) {
  return arg;
};

module.exports = emptyFunction;

/***/ }),
/* 76 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 *
 */



/**
 * Use invariant() to assert state which your program assumes to be true.
 *
 * Provide sprintf-style format (only %s is supported) and arguments
 * to provide information about what broke and what you were
 * expecting.
 *
 * The invariant message will be stripped in production, but the invariant
 * will remain to ensure logic does not differ in production.
 */

var validateFormat = function validateFormat(format) {};

if (false) {}

function invariant(condition, format, a, b, c, d, e, f) {
  validateFormat(format);

  if (!condition) {
    var error;
    if (format === undefined) {
      error = new Error('Minified exception occurred; use the non-minified dev environment ' + 'for the full error message and additional helpful warnings.');
    } else {
      var args = [a, b, c, d, e, f];
      var argIndex = 0;
      error = new Error(format.replace(/%s/g, function () {
        return args[argIndex++];
      }));
      error.name = 'Invariant Violation';
    }

    error.framesToPop = 1; // we don't care about invariant's own frame
    throw error;
  }
}

module.exports = invariant;

/***/ }),
/* 77 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */



var ReactPropTypesSecret = 'SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED';

module.exports = ReactPropTypesSecret;


/***/ }),
/* 78 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);

// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/defineProperty.js
var defineProperty = __webpack_require__(0);
var defineProperty_default = /*#__PURE__*/__webpack_require__.n(defineProperty);

// EXTERNAL MODULE: ./node_modules/classnames/index.js
var classnames = __webpack_require__(1);
var classnames_default = /*#__PURE__*/__webpack_require__.n(classnames);

// CONCATENATED MODULE: ./resources/blocks/library/section/index.js


/**
 * External dependencies.
 */

/**
 * WordPress dependencies.
 */

var __ = wp.i18n.__;
var registerBlockType = wp.blocks.registerBlockType;
var _wp$blockEditor = wp.blockEditor,
    InspectorControls = _wp$blockEditor.InspectorControls,
    withColors = _wp$blockEditor.withColors;
var _wp$editor = wp.editor,
    InnerBlocks = _wp$editor.InnerBlocks,
    PanelColorSettings = _wp$editor.PanelColorSettings,
    getColorClassName = _wp$editor.getColorClassName;
var _wp$components = wp.components,
    PanelBody = _wp$components.PanelBody,
    SelectControl = _wp$components.SelectControl;
var Fragment = wp.element.Fragment;
var compose = wp.compose.compose;
/**
 * Register "Section" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */

registerBlockType('vendify/section', {
  title: __('Section'),
  description: __('Divide your page in to sections.'),
  icon: 'align-center',
  category: 'vendify',
  keywords: [__('section')],
  attributes: {
    backgroundColor: {
      type: 'string',
      default: 'light'
    },
    borderColor: {
      type: 'string',
      default: 'neutral'
    },
    customBackgroundColor: {
      type: 'string'
    },
    customBorderColor: {
      type: 'string'
    },
    borderOptions: {
      type: 'string',
      default: 'both'
    }
  },

  /**
   * Ensure the block is always in full align mode.
   *
   * @return {Object} Wrapper properties.
   */
  getEditWrapperProps: function getEditWrapperProps() {
    return {
      'data-align': 'full'
    };
  },

  /**
   * Edit mode.
   *
   * @param {Object} props Block properties.
   */
  edit: compose(withColors('backgroundColor', 'borderColor'))(function (props) {
    var _classnames;

    var className = props.className,
        setBackgroundColor = props.setBackgroundColor,
        setBorderColor = props.setBorderColor,
        backgroundColor = props.backgroundColor,
        borderColor = props.borderColor,
        attributes = props.attributes,
        setAttributes = props.setAttributes;
    var borderOptions = attributes.borderOptions;
    var controls = React.createElement(InspectorControls, null, React.createElement(PanelColorSettings, {
      title: __('Color Settings'),
      colorSettings: [{
        value: backgroundColor.color,
        onChange: setBackgroundColor,
        label: __('Background Color')
      }, {
        value: borderColor.color,
        onChange: setBorderColor,
        label: __('Border Color')
      }]
    }), React.createElement(SelectControl, {
      label: __('Border'),
      value: borderOptions,
      options: [{
        value: 'both',
        label: __('Top and Bottom')
      }, {
        value: 'top',
        label: __('Top only')
      }, {
        value: 'bottom',
        label: __('Bottom only')
      }],
      onChange: function onChange(newValue) {
        return setAttributes({
          borderOptions: newValue
        });
      }
    }));
    var backgroundClass = getColorClassName('background-color', backgroundColor);
    var borderClass = getColorClassName('border-color', borderColor);
    var sectionClasses = classnames_default()(className, (_classnames = {
      'has-background-color': backgroundColor.color
    }, defineProperty_default()(_classnames, backgroundColor.class, backgroundColor.class), defineProperty_default()(_classnames, 'has-border-color', borderColor.color), defineProperty_default()(_classnames, borderColor.class, borderColor.class), defineProperty_default()(_classnames, 'no-bottom', 'top' === borderOptions), defineProperty_default()(_classnames, 'no-top', 'bottom' === borderOptions), _classnames));
    var sectionStyles = {
      backgroundColor: backgroundColor.color,
      borderColor: borderColor.color
    };
    return React.createElement(Fragment, null, controls, React.createElement("div", {
      className: sectionClasses,
      style: sectionStyles
    }, React.createElement(InnerBlocks, {
      templateInsertUpdatesSelection: false
    })));
  }),

  /**
   * Save mode.
   *
   * @param {Object} props Block properties.
   * @return {string}
   */
  save: function save(_ref) {
    var _classnames2;

    var attributes = _ref.attributes;
    var className = attributes.className,
        backgroundColor = attributes.backgroundColor,
        borderColor = attributes.borderColor,
        borderOptions = attributes.borderOptions,
        customBackgroundColor = attributes.customBackgroundColor,
        customBorderColor = attributes.customBorderColor;
    var backgroundClass = getColorClassName('background-color', backgroundColor);
    var borderClass = getColorClassName('border-color', borderColor);
    var sectionClasses = classnames_default()(className, 'alignfull', (_classnames2 = {
      'has-border-color': borderColor || customBorderColor
    }, defineProperty_default()(_classnames2, borderClass, borderClass), defineProperty_default()(_classnames2, 'has-background', backgroundColor || customBackgroundColor), defineProperty_default()(_classnames2, backgroundClass, backgroundClass), defineProperty_default()(_classnames2, 'no-bottom', 'top' === borderOptions), defineProperty_default()(_classnames2, 'no-top', 'bottom' === borderOptions), _classnames2));
    var sectionStyles = {
      backgroundColor: backgroundClass ? undefined : customBackgroundColor,
      borderColor: borderClass ? undefined : customBorderColor
    };
    return React.createElement("div", {
      className: sectionClasses,
      style: sectionStyles
    }, React.createElement("div", {
      className: "container"
    }, React.createElement(InnerBlocks.Content, null)));
  }
});
// EXTERNAL MODULE: external "lodash"
var external_lodash_ = __webpack_require__(2);

// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/objectSpread.js
var objectSpread = __webpack_require__(5);
var objectSpread_default = /*#__PURE__*/__webpack_require__.n(objectSpread);

// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/slicedToArray.js
var slicedToArray = __webpack_require__(15);
var slicedToArray_default = /*#__PURE__*/__webpack_require__.n(slicedToArray);

// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/classCallCheck.js
var classCallCheck = __webpack_require__(6);
var classCallCheck_default = /*#__PURE__*/__webpack_require__.n(classCallCheck);

// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/createClass.js
var createClass = __webpack_require__(7);
var createClass_default = /*#__PURE__*/__webpack_require__.n(createClass);

// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js
var possibleConstructorReturn = __webpack_require__(8);
var possibleConstructorReturn_default = /*#__PURE__*/__webpack_require__.n(possibleConstructorReturn);

// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/getPrototypeOf.js
var getPrototypeOf = __webpack_require__(9);
var getPrototypeOf_default = /*#__PURE__*/__webpack_require__.n(getPrototypeOf);

// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/inherits.js
var inherits = __webpack_require__(10);
var inherits_default = /*#__PURE__*/__webpack_require__.n(inherits);

// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/assertThisInitialized.js
var assertThisInitialized = __webpack_require__(4);
var assertThisInitialized_default = /*#__PURE__*/__webpack_require__.n(assertThisInitialized);

// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/toConsumableArray.js
var toConsumableArray = __webpack_require__(14);
var toConsumableArray_default = /*#__PURE__*/__webpack_require__.n(toConsumableArray);

// CONCATENATED MODULE: ./resources/blocks/utils/index.js



/**
 * Update an object's key that exists in an array of objects.
 *
 * @since 1.0.0
 *
 * @param {object}
 * @param {number}
 * @param {object}
 */
var utils_updateDeep = function updateDeep(object, index, update) {
  return [].concat(toConsumableArray_default()(object.slice(0, index)), [objectSpread_default()({}, object[index], update)], toConsumableArray_default()(object.slice(index + 1)));
};
/**
 * Create a class based on dim ratio.
 *
 * @param {number} ratio Dim ratio.
 * @return {string} Class HTML list.
 */

var dimRatioToClass = function dimRatioToClass(ratio) {
  return "has-background-dim has-background-dim-".concat(ratio);
};
/**
 * Create a class based on background image.
 *
 * @param {string} url Image URL.
 * @return {Object} Image styles.
 */

var backgroundImageStyles = function backgroundImageStyles(url) {
  return url ? {
    backgroundImage: "url(".concat(url, ")")
  } : undefined;
};
// CONCATENATED MODULE: ./resources/blocks/library/features/edit.js










/**
 * External dependencies.
 */


/**
 * WordPress dependencies.
 */

var _wp$i18n = wp.i18n,
    edit_ = _wp$i18n.__,
    sprintf = _wp$i18n.sprintf;
var getBlobByURL = wp.blob.getBlobByURL;
var _wp$element = wp.element,
    Component = _wp$element.Component,
    edit_Fragment = _wp$element.Fragment;
var edit_wp$blockEditor = wp.blockEditor,
    RichText = edit_wp$blockEditor.RichText,
    MediaUpload = edit_wp$blockEditor.MediaUpload,
    edit_InspectorControls = edit_wp$blockEditor.InspectorControls,
    BlockControls = edit_wp$blockEditor.BlockControls,
    BlockAlignmentToolbar = edit_wp$blockEditor.BlockAlignmentToolbar;
var editorMediaUpload = wp.editor.editorMediaUpload;
var edit_wp$components = wp.components,
    withNotices = edit_wp$components.withNotices,
    edit_PanelBody = edit_wp$components.PanelBody,
    RangeControl = edit_wp$components.RangeControl,
    edit_SelectControl = edit_wp$components.SelectControl,
    IconButton = edit_wp$components.IconButton;
/**
 * Internal dependencies.
 */



var iconAlignmentOptions = [{
  value: 'left',
  label: edit_('Left')
}, {
  value: 'top',
  label: edit_('Top')
}, {
  value: 'right',
  label: edit_('Right')
}];
/**
 * Edit a list of features.
 */

var edit_FeaturesEdit =
/*#__PURE__*/
function (_Component) {
  inherits_default()(FeaturesEdit, _Component);

  function FeaturesEdit() {
    var _this;

    classCallCheck_default()(this, FeaturesEdit);

    _this = possibleConstructorReturn_default()(this, getPrototypeOf_default()(FeaturesEdit).apply(this, arguments));
    _this.updateFeature = _this.updateFeature.bind(assertThisInitialized_default()(assertThisInitialized_default()(_this)));
    _this.onSelectImage = _this.onSelectImage.bind(assertThisInitialized_default()(assertThisInitialized_default()(_this)));
    return _this;
  }
  /**
   * Get the image's IDs from the URL so they can be preselected when editing.
   */


  createClass_default()(FeaturesEdit, [{
    key: "componentDidMount",
    value: function componentDidMount() {
      var _this2 = this;

      var attributes = this.props.attributes;
      var features = attributes.features,
          columns = attributes.columns;
      Object(external_lodash_["times"])(columns, function (index) {
        var _features$index = features[index],
            id = _features$index.id,
            _features$index$url = _features$index.url,
            url = _features$index$url === void 0 ? '' : _features$index$url;

        if (!id && url.indexOf('blob:') === 0) {
          var file = getBlobByURL(url);

          if (file) {
            editorMediaUpload({
              filesList: [file],
              onFileChange: function onFileChange(_ref) {
                var _ref2 = slicedToArray_default()(_ref, 1),
                    image = _ref2[0];

                _this2.updateFeature(index, Object(external_lodash_["pick"])(image, ['id', 'url']));
              },
              allowedType: 'image'
            });
          }
        }
      });
    }
    /**
     * Helper to update an individual feature's image.
     *
     * @param {number} index Feature index to update.
     * @param {Object} media WordPress media object.
     */

  }, {
    key: "onSelectImage",
    value: function onSelectImage(index, media) {
      var _this3 = this;

      if (!media) {
        return;
      }

      var vars = Object(external_lodash_["pick"])(media, ['id', 'url']);
      Object(external_lodash_["forEach"])(vars, function (value, key) {
        _this3.updateFeature(index, defineProperty_default()({}, key, value));
      });
    }
    /**
     * Helper to update an individual feature.
     *
     * @param {number} index Feature index to update.
     * @param {Object} update Object properties to update.
     */

  }, {
    key: "updateFeature",
    value: function updateFeature(index, update) {
      var _this$props = this.props,
          attributes = _this$props.attributes,
          setAttributes = _this$props.setAttributes;
      setAttributes({
        features: utils_updateDeep(attributes.features, index, update)
      });
    }
    /**
     * Render Block.
     *
     * @return {string} Block editing.
     */

  }, {
    key: "render",
    value: function render() {
      var _classnames,
          _this4 = this;

      var _this$props2 = this.props,
          attributes = _this$props2.attributes,
          setAttributes = _this$props2.setAttributes,
          className = _this$props2.className,
          noticeUI = _this$props2.noticeUI,
          isSelected = _this$props2.isSelected;
      var features = attributes.features,
          columns = attributes.columns,
          iconAlign = attributes.iconAlign,
          align = attributes.align;
      var classNames = classnames_default()('feature-block', 'alignfull', (_classnames = {}, defineProperty_default()(_classnames, className, true), defineProperty_default()(_classnames, "feature-block--".concat(iconAlign, "-aligned"), true), defineProperty_default()(_classnames, "columns-".concat(columns), true), _classnames));
      var isTop = 'top' === iconAlign;
      return React.createElement(edit_Fragment, null, noticeUI, React.createElement(BlockControls, null, React.createElement(BlockAlignmentToolbar, {
        value: align,
        onChange: function onChange(value) {
          return setAttributes({
            align: value
          });
        },
        controls: validAlignments
      })), React.createElement(edit_InspectorControls, null, React.createElement(edit_PanelBody, null, React.createElement(RangeControl, {
        label: edit_('Number of Features'),
        value: columns,
        onChange: function onChange(value) {
          return setAttributes({
            columns: value
          });
        },
        min: 1,
        max: 3
      }), React.createElement(edit_SelectControl, {
        label: edit_('Icon Alignment'),
        value: iconAlign,
        options: Object(external_lodash_["map"])(iconAlignmentOptions, function (data) {
          return objectSpread_default()({}, data);
        }),
        onChange: function onChange(value) {
          return setAttributes({
            iconAlign: value
          });
        }
      }))), React.createElement("div", {
        className: classNames
      }, React.createElement("div", {
        className: "feature-block__cols"
      }, Object(external_lodash_["times"])(columns, function (index) {
        var _ref3 = Object(external_lodash_["get"])(features, [index]) || {},
            title = _ref3.title,
            description = _ref3.description,
            id = _ref3.id,
            url = _ref3.url;

        return React.createElement("div", {
          className: "feature-block__col ".concat(!isTop ? 'media' : null),
          key: index
        }, React.createElement(MediaUpload, {
          gallery: false,
          multiple: false,
          onSelect: function onSelect(media) {
            return _this4.onSelectImage(index, media);
          },
          type: "image",
          value: id,
          render: function render(_ref4) {
            var open = _ref4.open;
            return React.createElement("div", {
              className: "feature-block__col-image"
            }, isSelected && React.createElement(IconButton, {
              className: "edit-image",
              icon: "format-image",
              onClick: open
            }), url && React.createElement("img", {
              src: url,
              alt: ""
            }));
          }
        }), React.createElement("div", {
          className: "media-body"
        }, React.createElement("h3", {
          className: "feature-block__col-title"
        }, React.createElement(RichText, {
          value: title,
          multitline: false,
          onChange: function onChange(value) {
            return _this4.updateFeature(index, {
              title: value
            });
          },
          placeholder: "Feature ".concat(index + 1)
        })), React.createElement("div", {
          className: "feature-block__col-description"
        }, React.createElement(RichText, {
          tagName: "p",
          value: description,
          multitline: true,
          onChange: function onChange(value) {
            return _this4.updateFeature(index, {
              description: value
            });
          },
          placeholder: sprintf(edit_('Feature %s description...'), index + 1)
        }))));
      }))));
    }
  }]);

  return FeaturesEdit;
}(Component);

/* harmony default export */ var features_edit = (withNotices(edit_FeaturesEdit));
// CONCATENATED MODULE: ./resources/blocks/library/features/index.js


/**
 * External dependencies.
 */


/**
 * WordPress dependencies.
 */

var features_ = wp.i18n.__;
var features_registerBlockType = wp.blocks.registerBlockType;
var features_RichText = wp.blockEditor.RichText;
/**
 * Internal dependencies.
 */


var validAlignments = ['wide', 'full'];
/**
 * Register "Features" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */

features_registerBlockType('vendify/features', {
  title: features_('Features'),
  description: features_('Tell the world what your site is all about.'),
  icon: 'columns',
  category: 'vendify',
  keywords: [features_('features')],
  supports: ['align'],
  attributes: {
    features: {
      type: 'array',
      source: 'query',
      selector: '.feature-block__col',
      query: {
        title: {
          source: 'children',
          selector: '.feature-block__col-title'
        },
        description: {
          source: 'children',
          selector: '.feature-block__col-description'
        },
        url: {
          type: 'string',
          source: 'attribute',
          selector: '.feature-block__col-image img',
          attribute: 'src'
        },
        id: {
          type: 'number'
        }
      },
      default: [[], [], []]
    },
    columns: {
      type: 'number',
      default: 3
    },
    iconAlign: {
      type: 'string',
      default: 'top'
    }
  },

  /**
   * Ensure block alignment is reflected.
   *
   * @param {Object} attrributes Block attributes.
   * @return {Object} Wrapper properties.
   */
  getEditWrapperProps: function getEditWrapperProps(attributes) {
    var align = attributes.align;

    if (-1 !== validAlignments.indexOf(align)) {
      return {
        'data-align': align
      };
    }
  },

  /**
   * Edit mode.
   */
  edit: features_edit,

  /**
   * Save mode.
   *
   * @param {Object} attributes Block attributes.
   * @return {string}
   */
  save: function save(_ref) {
    var _classnames;

    var attributes = _ref.attributes;
    var features = attributes.features,
        columns = attributes.columns,
        iconAlign = attributes.iconAlign;
    var classNames = classnames_default()('feature-block', (_classnames = {}, defineProperty_default()(_classnames, "feature-block--".concat(iconAlign, "-aligned"), true), defineProperty_default()(_classnames, "columns-".concat(columns), true), _classnames));
    var isTop = 'top' === iconAlign;
    return React.createElement("div", {
      className: classNames
    }, React.createElement("div", {
      className: "feature-block__cols js-dynamic-slider"
    }, Object(external_lodash_["times"])(columns, function (index) {
      var _get = Object(external_lodash_["get"])(features, [index]),
          title = _get.title,
          description = _get.description,
          url = _get.url;

      return React.createElement("div", {
        className: "feature-block__col ".concat(!isTop ? 'media' : ''),
        key: index
      }, url && React.createElement("div", {
        className: "feature-block__col-image"
      }, React.createElement("img", {
        src: url,
        alt: ""
      })), React.createElement("div", {
        className: "media-body"
      }, title && title.length > 0 && React.createElement(features_RichText.Content, {
        tagName: "h3",
        className: "feature-block__col-title",
        value: title
      }), description && description.length > 0 && React.createElement(features_RichText.Content, {
        tagName: "p",
        className: "feature-block__col-description",
        value: description
      })));
    })));
  }
});
// EXTERNAL MODULE: ./node_modules/@babel/runtime/helpers/extends.js
var helpers_extends = __webpack_require__(25);
var extends_default = /*#__PURE__*/__webpack_require__.n(helpers_extends);

// CONCATENATED MODULE: ./resources/blocks/library/collections/edit.js










/**
 * External dependencies.
 */


/**
 * WordPress dependencies.
 */

var collections_edit_ = wp.i18n.__;
var edit_getBlobByURL = wp.blob.getBlobByURL;
var edit_wp$element = wp.element,
    edit_Component = edit_wp$element.Component,
    collections_edit_Fragment = edit_wp$element.Fragment;
var edit_compose = wp.compose.compose;
var collections_edit_wp$blockEditor = wp.blockEditor,
    edit_RichText = collections_edit_wp$blockEditor.RichText,
    edit_BlockControls = collections_edit_wp$blockEditor.BlockControls,
    edit_BlockAlignmentToolbar = collections_edit_wp$blockEditor.BlockAlignmentToolbar,
    collections_edit_InspectorControls = collections_edit_wp$blockEditor.InspectorControls,
    edit_withColors = collections_edit_wp$blockEditor.withColors;
var edit_wp$editor = wp.editor,
    edit_MediaUpload = edit_wp$editor.MediaUpload,
    edit_editorMediaUpload = edit_wp$editor.editorMediaUpload,
    URLInput = edit_wp$editor.URLInput,
    edit_PanelColorSettings = edit_wp$editor.PanelColorSettings,
    ContrastChecker = edit_wp$editor.ContrastChecker;
var collections_edit_wp$components = wp.components,
    withFallbackStyles = collections_edit_wp$components.withFallbackStyles,
    edit_withNotices = collections_edit_wp$components.withNotices,
    collections_edit_PanelBody = collections_edit_wp$components.PanelBody,
    edit_RangeControl = collections_edit_wp$components.RangeControl,
    ToggleControl = collections_edit_wp$components.ToggleControl,
    edit_IconButton = collections_edit_wp$components.IconButton;
var applyFallbackStyles = withFallbackStyles(function (node, ownProps) {
  var _ownProps$attributes = ownProps.attributes,
      textColor = _ownProps$attributes.textColor,
      backgroundColor = _ownProps$attributes.backgroundColor;
  var editableNode = node.querySelector('[contenteditable="true"]'); //verify if editableNode is available, before using getComputedStyle.

  var computedStyles = editableNode ? getComputedStyle(editableNode) : null;
  return {
    fallbackBackgroundColor: backgroundColor || !computedStyles ? undefined : computedStyles.backgroundColor,
    fallbackTextColor: textColor || !computedStyles ? undefined : computedStyles.color
  };
});
/**
 * Internal dependencies.
 */



/**
 * Edit a list of collections.
 */

var edit_CollectionsEdit =
/*#__PURE__*/
function (_Component) {
  inherits_default()(CollectionsEdit, _Component);

  function CollectionsEdit() {
    var _this;

    classCallCheck_default()(this, CollectionsEdit);

    _this = possibleConstructorReturn_default()(this, getPrototypeOf_default()(CollectionsEdit).apply(this, arguments));
    _this.updateCollection = _this.updateCollection.bind(assertThisInitialized_default()(assertThisInitialized_default()(_this)));
    _this.onSelectImage = _this.onSelectImage.bind(assertThisInitialized_default()(assertThisInitialized_default()(_this)));
    return _this;
  }
  /**
   * Get the image's IDs from the URL so they can be preselected when editing.
   */


  createClass_default()(CollectionsEdit, [{
    key: "componentDidMount",
    value: function componentDidMount() {
      var _this2 = this;

      var attributes = this.props.attributes;
      var collections = attributes.collections,
          cards = attributes.cards;
      Object(external_lodash_["times"])(cards, function (index) {
        var _collections$index = collections[index],
            id = _collections$index.id,
            _collections$index$ur = _collections$index.url,
            url = _collections$index$ur === void 0 ? '' : _collections$index$ur;

        if (!id && url.indexOf('blob:') === 0) {
          var file = edit_getBlobByURL(url);

          if (file) {
            edit_editorMediaUpload({
              filesList: [file],
              onFileChange: function onFileChange(_ref) {
                var _ref2 = slicedToArray_default()(_ref, 1),
                    image = _ref2[0];

                _this2.updateCollection(index, Object(external_lodash_["pick"])(image, ['id', 'url']));
              },
              allowedType: 'image'
            });
          }
        }
      });
    }
    /**
     * Helper to update an individual feature's image.
     *
     * @param {number} index Feature index to update.
     * @param {Object} media WordPress media object.
     */

  }, {
    key: "onSelectImage",
    value: function onSelectImage(index, media) {
      var _this3 = this;

      if (!media) {
        return;
      }

      var vars = Object(external_lodash_["pick"])(media, ['id', 'url']);
      Object(external_lodash_["forEach"])(vars, function (value, key) {
        _this3.updateCollection(index, defineProperty_default()({}, key, value));
      });
    }
    /**
     * Helper to update an individual collection.
     *
     * @param {number} index Collection index to update.
     * @param {Object} update Object properties to update.
     */

  }, {
    key: "updateCollection",
    value: function updateCollection(index, update) {
      var _this$props = this.props,
          attributes = _this$props.attributes,
          setAttributes = _this$props.setAttributes;
      setAttributes({
        collections: utils_updateDeep(attributes.collections, index, update)
      });
    }
    /**
     * Render Block.
     *
     * @return {string} Block editing.
     */

  }, {
    key: "render",
    value: function render() {
      var _classnames,
          _classnames3,
          _classnames4,
          _this4 = this;

      var props = this.props;
      var attributes = props.attributes,
          setAttributes = props.setAttributes,
          className = props.className,
          noticeUI = props.noticeUI,
          isSelected = props.isSelected,
          setBackgroundColor = props.setBackgroundColor,
          setTextColor = props.setTextColor,
          setBadgeTextColor = props.setBadgeTextColor,
          setBadgeBackgroundColor = props.setBadgeBackgroundColor,
          fallbackBackgroundColor = props.fallbackBackgroundColor,
          fallbackTextColor = props.fallbackTextColor;
      var backgroundColorProp = props.backgroundColor;
      var textColorProp = props.textColor;
      var badgeTextColorProp = props.badgeTextColor;
      var badgeBackgroundColorProp = props.badgeBackgroundColor;
      var collections = attributes.collections,
          align = attributes.align,
          hasParallax = attributes.hasParallax,
          hasTextBgBlur = attributes.hasTextBgBlur,
          dimRatio = attributes.dimRatio,
          _attributes$cards = attributes.cards,
          cards = _attributes$cards === void 0 ? 3 : _attributes$cards,
          backgroundColor = attributes.backgroundColor,
          textColor = attributes.textColor,
          badgeTextColor = attributes.badgeTextColor,
          badgeBackgroundColor = attributes.badgeBackgroundColor;
      var controls = React.createElement(collections_edit_Fragment, null, React.createElement(edit_BlockControls, null, React.createElement(edit_BlockAlignmentToolbar, {
        value: align,
        onChange: function onChange(value) {
          return setAttributes({
            align: value
          });
        },
        controls: collections_validAlignments
      })), React.createElement(collections_edit_InspectorControls, null, React.createElement(collections_edit_PanelBody, null, React.createElement(ToggleControl, {
        label: collections_edit_('Show Extra Collections'),
        checked: 5 === cards,
        onChange: function onChange() {
          return setAttributes({
            cards: 5 === cards ? 3 : 5
          });
        }
      })), React.createElement(collections_edit_PanelBody, {
        title: collections_edit_('Background Image Settings')
      }, React.createElement(ToggleControl, {
        label: collections_edit_('Fixed Background'),
        checked: hasParallax,
        onChange: function onChange(hasParallax) {
          return setAttributes({
            hasParallax: hasParallax
          });
        }
      }), React.createElement(ToggleControl, {
        label: collections_edit_('Text Background'),
        checked: hasTextBgBlur,
        onChange: function onChange(hasTextBgBlur) {
          return setAttributes({
            hasTextBgBlur: hasTextBgBlur
          });
        }
      }), React.createElement(edit_RangeControl, {
        label: collections_edit_('Dark Overlay'),
        value: dimRatio,
        onChange: function onChange(dimRatio) {
          return setAttributes({
            dimRatio: dimRatio
          });
        },
        min: 0,
        max: 90,
        step: 5
      })), React.createElement(edit_PanelColorSettings, {
        title: collections_edit_('Color Settings'),
        colorSettings: [{
          value: backgroundColorProp.color,
          onChange: setBackgroundColor,
          label: collections_edit_('Background Color')
        }, {
          value: textColorProp.color,
          onChange: setTextColor,
          label: collections_edit_('Text Color')
        }, {
          value: badgeBackgroundColorProp.color,
          onChange: setBadgeBackgroundColor,
          label: collections_edit_('Badge Color')
        }, {
          value: badgeTextColorProp.color,
          onChange: setBadgeTextColor,
          label: collections_edit_('Badge Text Color')
        }]
      }, textColorProp.hasOwnProperty('color') && backgroundColorProp.hasOwnProperty('color') && React.createElement(ContrastChecker, extends_default()({
        textColor: textColorProp.color,
        backgroundColor: backgroundColorProp.color,
        badgeTextColor: badgeTextColorProp.color,
        badgeBackgroundColor: badgeBackgroundColorProp.color,
        fallbackTextColor: fallbackTextColor,
        fallbackBackgroundColor: fallbackBackgroundColor
      }, {
        isLargeText: false
      })))));
      var classNames = classnames_default()('collections', (_classnames = {}, defineProperty_default()(_classnames, className, true), defineProperty_default()(_classnames, "align".concat(align), align), defineProperty_default()(_classnames, "cards-".concat(cards), true), defineProperty_default()(_classnames, 'has-text-bg', !!hasTextBgBlur), _classnames));
      var textClassNames = classnames_default()(defineProperty_default()({}, "has-text-color has-".concat(textColor, "-color"), !!textColor));
      var textStyle = {
        color: textColorProp.color
      };
      var badgeClassNames = classnames_default()('collection-card__badge', (_classnames3 = {}, defineProperty_default()(_classnames3, "badge badge-".concat(badgeBackgroundColor), !!badgeBackgroundColor), defineProperty_default()(_classnames3, "has-text-color has-".concat(badgeTextColor, "-color"), !!badgeTextColor), _classnames3));
      var buttonClassNames = classnames_default()('collection-card__visit', (_classnames4 = {}, defineProperty_default()(_classnames4, "btn btn-".concat(badgeBackgroundColor), !!badgeBackgroundColor), defineProperty_default()(_classnames4, "has-text-color has-".concat(badgeTextColor, "-color"), !!badgeTextColor), _classnames4));
      var badgeStyle = {
        color: badgeTextColorProp.color,
        backgroundColor: badgeBackgroundColorProp.color
      };
      return React.createElement(collections_edit_Fragment, null, noticeUI, controls, React.createElement("div", {
        className: classNames
      }, Object(external_lodash_["times"])(cards, function (index) {
        // Every collection shares child attributes.
        var _ref3 = Object(external_lodash_["get"])(collections, [index]) || {},
            supTitle = _ref3.supTitle,
            title = _ref3.title,
            description = _ref3.description,
            badge = _ref3.badge,
            link = _ref3.link,
            url = _ref3.url,
            id = _ref3.id;

        var imageStyle = backgroundImageStyles(url);

        if (backgroundColorProp.color && imageStyle) {
          imageStyle.backgroundColor = backgroundColorProp.color;
        }

        var imageClassName = classnames_default()('collection-card__image', dimRatioToClass(dimRatio), defineProperty_default()({
          'has-background-dim': dimRatio !== 0,
          'has-parallax': hasParallax
        }, "has-background has-".concat(backgroundColor, "-background-color"), !!backgroundColor));
        return React.createElement(collections_edit_Fragment, {
          key: index
        }, React.createElement("div", {
          className: "collection-card-wrap"
        }, React.createElement("div", {
          className: "collection-card"
        }, React.createElement("div", {
          className: "collection-card__content"
        }, (badge || isSelected) && React.createElement("div", {
          className: badgeClassNames
        }, React.createElement(edit_RichText, {
          value: badge,
          style: badgeStyle,
          multitline: false,
          onChange: function onChange(badge) {
            return _this4.updateCollection(index, {
              badge: badge
            });
          },
          placeholder: 'Sale'
        })), React.createElement("div", {
          className: "collection-card__content-inner"
        }, (supTitle || isSelected) && React.createElement(edit_RichText, {
          className: textClassNames + " collection-card__category",
          style: textStyle,
          value: supTitle,
          multitline: false,
          onChange: function onChange(supTitle) {
            return _this4.updateCollection(index, {
              supTitle: supTitle
            });
          },
          placeholder: 'Collection supTitle'
        }), (title || isSelected) && React.createElement(edit_RichText, {
          tagName: "h3",
          className: textClassNames + " collection-card__title",
          style: textStyle,
          value: title,
          multitline: false,
          onChange: function onChange(title) {
            return _this4.updateCollection(index, {
              title: title
            });
          },
          placeholder: 'Collection Title'
        }), (description || isSelected) && React.createElement(edit_RichText, {
          className: textClassNames + " collection-card__description",
          style: textStyle,
          value: description,
          multitline: false,
          onChange: function onChange(description) {
            return _this4.updateCollection(index, {
              description: description
            });
          },
          placeholder: 'Collection description...'
        })), link && (0 !== index ? React.createElement("span", {
          className: textClassNames + " collection-card__arrow",
          style: textStyle
        }, "\u2192") : React.createElement("span", {
          className: buttonClassNames,
          style: badgeStyle
        }, collections_edit_('View')))), url && React.createElement("div", {
          "data-url": url,
          "data-id": id,
          style: imageStyle,
          className: imageClassName
        })), isSelected && React.createElement("div", {
          className: "collection-card-edit"
        }, React.createElement(URLInput, {
          value: link,
          onChange: function onChange(link) {
            return _this4.updateCollection(index, {
              link: link
            });
          }
        }), React.createElement(edit_MediaUpload, {
          gallery: false,
          multiple: false,
          onSelect: function onSelect(media) {
            return _this4.onSelectImage(index, media);
          },
          type: "image",
          value: id,
          render: function render(_ref4) {
            var open = _ref4.open;
            return React.createElement(edit_IconButton, {
              className: "edit-image",
              icon: "format-image",
              onClick: open
            });
          }
        }))));
      })));
    }
  }]);

  return CollectionsEdit;
}(edit_Component);

/* harmony default export */ var collections_edit = (edit_compose([edit_withColors({
  backgroundColor: 'background-color',
  textColor: 'color',
  badgeBackgroundColor: 'background-color',
  badgeTextColor: 'color'
}), edit_withNotices, applyFallbackStyles])(edit_CollectionsEdit));
// CONCATENATED MODULE: ./resources/blocks/library/collections/deprecated110.js


/**
 * External dependencies.
 */



/**
 * WordPress dependencies.
 */

var deprecated110_ = wp.i18n.__;
var deprecated110_RichText = wp.blockEditor.RichText;
var deprecated110_getColorClassName = wp.editor.getColorClassName;
function Deprecated110(_ref) {
  var _classnames;

  var attributes = _ref.attributes;
  var collections = attributes.collections,
      align = attributes.align,
      hasParallax = attributes.hasParallax,
      hasTextBgBlur = attributes.hasTextBgBlur,
      dimRatio = attributes.dimRatio,
      cards = attributes.cards,
      backgroundColor = attributes.backgroundColor,
      textColor = attributes.textColor,
      customBackgroundColor = attributes.customBackgroundColor,
      customTextColor = attributes.customTextColor;
  var textClass = deprecated110_getColorClassName('color', textColor);
  var backgroundClass = deprecated110_getColorClassName('background-color', backgroundColor);
  var classNames = classnames_default()('collections', (_classnames = {}, defineProperty_default()(_classnames, "align".concat(align), align), defineProperty_default()(_classnames, "cards-".concat(cards), true), defineProperty_default()(_classnames, 'has-text-bg', !!hasTextBgBlur), _classnames));
  var textStyle = {
    color: textClass ? undefined : customTextColor
  };
  var textClassNames = classnames_default()(defineProperty_default()({
    'has-text-color': textColor || customTextColor
  }, textClass, textClass));
  return React.createElement("div", {
    className: classNames
  }, Object(external_lodash_["times"])(cards, function (index) {
    // Every collection shares child attributes.
    var _ref2 = Object(external_lodash_["get"])(collections, [index]) || {},
        supTitle = _ref2.supTitle,
        title = _ref2.title,
        description = _ref2.description,
        badge = _ref2.badge,
        link = _ref2.link,
        url = _ref2.url,
        id = _ref2.id;

    var imageStyle = backgroundImageStyles(url);

    if (!backgroundClass && imageStyle) {
      imageStyle.backgroundColor = customBackgroundColor;
    }

    var imageClassName = classnames_default()('collection-card__image', dimRatioToClass(dimRatio), defineProperty_default()({
      'has-parallax': hasParallax,
      'has-background': backgroundColor || customBackgroundColor
    }, backgroundClass, backgroundClass));
    return React.createElement("div", {
      className: "collection-card-wrap",
      key: index
    }, React.createElement("div", {
      className: "collection-card"
    }, link && link.length > 0 && React.createElement("a", {
      href: link,
      className: textClassNames + " collection-card__link",
      style: textStyle
    }), React.createElement("div", {
      className: "collection-card__content"
    }, badge && badge.length > 0 && React.createElement(deprecated110_RichText.Content, {
      tagName: "div",
      className: "collection-card__badge",
      value: badge
    }), React.createElement("div", {
      className: "collection-card__content-inner"
    }, supTitle && supTitle.length > 0 && React.createElement(deprecated110_RichText.Content, {
      tagName: "div",
      className: textClassNames + " collection-card__category",
      value: supTitle,
      style: textStyle
    }), title && title.length > 0 && React.createElement(deprecated110_RichText.Content, {
      tagName: "h3",
      className: textClassNames + " collection-card__title",
      value: title,
      style: textStyle
    }), description && description.length > 0 && React.createElement(deprecated110_RichText.Content, {
      tagName: "div",
      className: textClassNames + " collection-card__description",
      value: description,
      style: textStyle
    })), link && link.length > 0 && (0 !== index ? React.createElement("span", {
      className: textClassNames + " collection-card__arrow",
      style: textStyle
    }, "\u2192") : React.createElement("span", {
      className: "collection-card__visit"
    }, deprecated110_('View')))), url && React.createElement("div", {
      "data-id": id,
      "data-url": url,
      style: imageStyle,
      className: imageClassName
    })));
  }));
}
;
// CONCATENATED MODULE: ./resources/blocks/library/collections/index.js



/**
 * External dependencies.
 */


/**
 * WordPress dependencies.
 */

var collections_ = wp.i18n.__;
var collections_registerBlockType = wp.blocks.registerBlockType;
var collections_RichText = wp.blockEditor.RichText;
var collections_getColorClassName = wp.editor.getColorClassName;
/**
 * Internal dependencies.
 */




var collections_validAlignments = ['wide', 'full'];
var blockAttributes = {
  collections: {
    type: 'array',
    source: 'query',
    selector: '.collection-card',
    query: {
      badge: {
        type: 'string',
        source: 'children',
        selector: '.collection-card__badge'
      },
      supTitle: {
        type: 'string',
        source: 'children',
        selector: '.collection-card__category'
      },
      title: {
        type: 'string',
        source: 'children',
        selector: '.collection-card__title'
      },
      description: {
        type: 'string',
        source: 'children',
        selector: '.collection-card__description'
      },
      link: {
        type: 'string',
        source: 'attribute',
        selector: '.collection-card__link',
        attribute: 'href'
      },
      url: {
        type: 'string',
        source: 'attribute',
        selector: '.collection-card__image',
        attribute: 'data-url'
      },
      id: {
        type: 'number',
        source: 'attribute',
        selector: '.collection-card__image',
        attribute: 'data-id'
      }
    },
    default: [[], [], []]
  },
  hasParallax: {
    type: 'boolean',
    default: false
  },
  hasTextBgBlur: {
    type: 'boolean',
    default: false
  },
  dimRatio: {
    type: 'number',
    default: 50
  },
  cards: {
    type: 'number',
    default: 3
  },
  align: {
    type: 'string'
  },
  backgroundColor: {
    type: 'string'
  },
  textColor: {
    type: 'string'
  },
  badgeTextColor: {
    type: 'string',
    default: 'light'
  },
  badgeBackgroundColor: {
    type: 'string',
    default: 'primary'
  },
  customTextColor: {
    type: "string"
  },
  customBackgroundColor: {
    type: "string"
  }
};
/**
 * Register "Collections" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */

collections_registerBlockType('vendify/collections', {
  title: collections_('Collections'),
  description: collections_('Quickly link to different area\'s of your website or highlight new products.'),
  icon: 'screenoptions',
  category: 'vendify',
  keywords: [collections_('collections')],
  attributes: blockAttributes,

  /**
   * Ensure block alignment is reflected.
   *
   * @param {Object} attrributes Block attributes.
   * @return {Object} Wrapper properties.
   */
  getEditWrapperProps: function getEditWrapperProps(attributes) {
    var align = attributes.align;

    if (-1 !== collections_validAlignments.indexOf(align)) {
      return {
        'data-align': align
      };
    }
  },

  /**
   * Edit mode.
   */
  edit: collections_edit,

  /**
   * Save mode.
   *
   * @param {Object} attributes Block attributes.
   * @return {string} Block.
   */
  save: function save(_ref) {
    var _classnames, _classnames3, _classnames4;

    var attributes = _ref.attributes;
    var collections = attributes.collections,
        align = attributes.align,
        hasParallax = attributes.hasParallax,
        hasTextBgBlur = attributes.hasTextBgBlur,
        dimRatio = attributes.dimRatio,
        cards = attributes.cards,
        backgroundColor = attributes.backgroundColor,
        textColor = attributes.textColor,
        badgeTextColor = attributes.badgeTextColor,
        badgeBackgroundColor = attributes.badgeBackgroundColor,
        customBackgroundColor = attributes.customBackgroundColor,
        customTextColor = attributes.customTextColor,
        customBadgeTextColor = attributes.customBadgeTextColor,
        customBadgeBackgroundColor = attributes.customBadgeBackgroundColor;
    var textClass = collections_getColorClassName('color', textColor);
    var backgroundClass = collections_getColorClassName('background-color', backgroundColor);
    var badgeTextClass = collections_getColorClassName('color', badgeTextColor);
    var badgeBackgroundClass = collections_getColorClassName('background-color', badgeBackgroundColor);
    var classNames = classnames_default()('collections', (_classnames = {}, defineProperty_default()(_classnames, "align".concat(align), align), defineProperty_default()(_classnames, "cards-".concat(cards), true), defineProperty_default()(_classnames, 'has-text-bg', !!hasTextBgBlur), _classnames));
    var textStyle = {
      color: textClass ? undefined : customTextColor
    };
    var textClassNames = classnames_default()(defineProperty_default()({
      'has-text-color': textColor || customTextColor
    }, textClass, textClass));
    var badgeClassNames = classnames_default()('collection-card__badge', (_classnames3 = {}, defineProperty_default()(_classnames3, "badge badge-".concat(badgeBackgroundColor), !!badgeBackgroundColor), defineProperty_default()(_classnames3, "has-text-color has-".concat(badgeTextColor, "-color"), !!badgeTextColor), _classnames3));
    var buttonClassNames = classnames_default()('collection-card__visit', (_classnames4 = {}, defineProperty_default()(_classnames4, "button btn-".concat(badgeBackgroundColor), !!badgeBackgroundColor), defineProperty_default()(_classnames4, "has-text-color has-".concat(badgeTextColor, "-color"), !!badgeTextColor), _classnames4));
    var badgeStyle = {
      color: badgeTextClass ? undefined : customBadgeTextColor,
      backgroundColor: badgeBackgroundClass ? undefined : customBadgeBackgroundColor
    };
    return React.createElement("div", {
      className: classNames
    }, Object(external_lodash_["times"])(cards, function (index) {
      // Every collection shares child attributes.
      var _ref2 = Object(external_lodash_["get"])(collections, [index]) || {},
          supTitle = _ref2.supTitle,
          title = _ref2.title,
          description = _ref2.description,
          badge = _ref2.badge,
          link = _ref2.link,
          url = _ref2.url,
          id = _ref2.id;

      var imageStyle = backgroundImageStyles(url);

      if (!backgroundClass && imageStyle) {
        imageStyle.backgroundColor = customBackgroundColor;
      }

      var imageClassName = classnames_default()('collection-card__image', dimRatioToClass(dimRatio), defineProperty_default()({
        'has-parallax': hasParallax,
        'has-background': backgroundColor || customBackgroundColor
      }, backgroundClass, backgroundClass));
      return React.createElement("div", {
        className: "collection-card-wrap",
        key: index
      }, React.createElement("div", {
        className: "collection-card"
      }, link && link.length > 0 && React.createElement("a", {
        href: link,
        className: textClassNames + " collection-card__link",
        style: textStyle
      }), React.createElement("div", {
        className: "collection-card__content"
      }, badge && badge.length > 0 && React.createElement(collections_RichText.Content, {
        tagName: "div",
        className: badgeClassNames,
        style: badgeStyle,
        value: badge
      }), React.createElement("div", {
        className: "collection-card__content-inner"
      }, supTitle && supTitle.length > 0 && React.createElement(collections_RichText.Content, {
        tagName: "div",
        className: textClassNames + " collection-card__category",
        value: supTitle,
        style: textStyle
      }), title && title.length > 0 && React.createElement(collections_RichText.Content, {
        tagName: "h3",
        className: textClassNames + " collection-card__title",
        value: title,
        style: textStyle
      }), description && description.length > 0 && React.createElement(collections_RichText.Content, {
        tagName: "div",
        className: textClassNames + " collection-card__description",
        value: description,
        style: textStyle
      })), link && link.length > 0 && (0 !== index ? React.createElement("span", {
        className: textClassNames + " collection-card__arrow",
        style: textStyle
      }, "\u2192") : React.createElement("span", {
        className: buttonClassNames,
        style: badgeStyle
      }, collections_('View')))), url && React.createElement("div", {
        "data-id": id,
        "data-url": url,
        style: imageStyle,
        className: imageClassName
      })));
    }));
  },
  deprecated: [{
    attributes: objectSpread_default()({}, blockAttributes),
    save: Deprecated110
  }]
});
// EXTERNAL MODULE: ./resources/blocks/library/vendor-registration/index.js
var vendor_registration = __webpack_require__(69);

// EXTERNAL MODULE: ./resources/blocks/library/vendor-dashboard/index.js
var vendor_dashboard = __webpack_require__(70);

// EXTERNAL MODULE: ./resources/blocks/library/featured-vendors/index.js
var featured_vendors = __webpack_require__(71);

// CONCATENATED MODULE: ./resources/blocks/library/hero/edit.js






/**
 * External dependencies.
 */


/**
 * WordPress dependencies.
 */

var hero_edit_ = wp.i18n.__;
var hero_edit_wp$element = wp.element,
    hero_edit_Component = hero_edit_wp$element.Component,
    hero_edit_Fragment = hero_edit_wp$element.Fragment;
var hero_edit_wp$blockEditor = wp.blockEditor,
    hero_edit_InspectorControls = hero_edit_wp$blockEditor.InspectorControls,
    hero_edit_RichText = hero_edit_wp$blockEditor.RichText,
    hero_edit_BlockControls = hero_edit_wp$blockEditor.BlockControls;
var hero_edit_wp$editor = wp.editor,
    edit_InnerBlocks = hero_edit_wp$editor.InnerBlocks,
    AlignmentToolbar = hero_edit_wp$editor.AlignmentToolbar,
    hero_edit_MediaUpload = hero_edit_wp$editor.MediaUpload,
    MediaPlaceholder = hero_edit_wp$editor.MediaPlaceholder;
var hero_edit_wp$components = wp.components,
    hero_edit_IconButton = hero_edit_wp$components.IconButton,
    hero_edit_PanelBody = hero_edit_wp$components.PanelBody,
    hero_edit_RangeControl = hero_edit_wp$components.RangeControl,
    edit_ToggleControl = hero_edit_wp$components.ToggleControl,
    Toolbar = hero_edit_wp$components.Toolbar,
    hero_edit_withNotices = hero_edit_wp$components.withNotices;
/**
 * Internal dependencies.
 */


/**
 * Edit a hero.
 */

var edit_HeroEdit =
/*#__PURE__*/
function (_Component) {
  inherits_default()(HeroEdit, _Component);

  function HeroEdit() {
    classCallCheck_default()(this, HeroEdit);

    return possibleConstructorReturn_default()(this, getPrototypeOf_default()(HeroEdit).apply(this, arguments));
  }

  createClass_default()(HeroEdit, [{
    key: "render",

    /**
     * Render Block.
     *
     * @return {string} Block editing.
     */
    value: function render() {
      var _this$props = this.props,
          attributes = _this$props.attributes,
          setAttributes = _this$props.setAttributes,
          isSelected = _this$props.isSelected,
          className = _this$props.className,
          noticeOperations = _this$props.noticeOperations,
          noticeUI = _this$props.noticeUI;
      var url = attributes.url,
          title = attributes.title,
          subtitle = attributes.subtitle,
          align = attributes.align,
          contentAlign = attributes.contentAlign,
          id = attributes.id,
          hasParallax = attributes.hasParallax,
          hasAnimation = attributes.hasAnimation,
          dimRatio = attributes.dimRatio,
          paddingTop = attributes.paddingTop,
          paddingBottom = attributes.paddingBottom;

      var updateAlignment = function updateAlignment(nextAlign) {
        return setAttributes({
          align: nextAlign
        });
      };

      var toggleParallax = function toggleParallax() {
        return setAttributes({
          hasParallax: !hasParallax
        });
      };

      var toggleAnimation = function toggleAnimation() {
        return setAttributes({
          hasAnimation: !hasAnimation
        });
      };

      var toggleSearchForm = function toggleSearchForm() {
        return setAttributes({
          hasSearchForm: !hasSearchForm
        });
      };

      var setDimRatio = function setDimRatio(ratio) {
        if (ratio === 5) {
          setAttributes({
            dimRatio: 0
          });
        } else {
          setAttributes({
            dimRatio: ratio
          });
        }
      };

      var setPaddingTop = function setPaddingTop(padding) {
        return setAttributes({
          paddingTop: padding
        });
      };

      var setPaddingBottom = function setPaddingBottom(padding) {
        return setAttributes({
          paddingBottom: padding
        });
      };

      var onSelectImage = function onSelectImage(media) {
        if (!media || !media.url) {
          setAttributes({
            url: undefined,
            id: undefined
          });
          return;
        }

        setAttributes({
          url: media.url,
          id: media.id
        });
      };

      var style = backgroundImageStyles(url);
      var classes = classnames_default()(className, dimRatioToClass(dimRatio), {
        'has-background-dim': dimRatio !== 0,
        'has-parallax': hasParallax,
        'hero--animatable': hasAnimation
      });
      var controls = React.createElement(hero_edit_Fragment, null, React.createElement(hero_edit_BlockControls, null, React.createElement(AlignmentToolbar, {
        value: contentAlign,
        onChange: function onChange(nextAlign) {
          return setAttributes({
            contentAlign: nextAlign
          });
        }
      }), React.createElement(Toolbar, null, React.createElement(hero_edit_MediaUpload, {
        onSelect: onSelectImage,
        type: "image",
        value: id,
        render: function render(_ref) {
          var open = _ref.open;
          return React.createElement(hero_edit_IconButton, {
            className: "components-toolbar__control",
            label: hero_edit_('Edit image'),
            icon: "edit",
            onClick: open
          });
        }
      }))), !!url && React.createElement(hero_edit_InspectorControls, null, React.createElement(hero_edit_PanelBody, {
        title: hero_edit_('Background Image')
      }, React.createElement(edit_ToggleControl, {
        label: hero_edit_('Parallax Background'),
        checked: !!hasParallax,
        onChange: toggleParallax
      }), React.createElement(edit_ToggleControl, {
        label: hero_edit_('Animated Background'),
        checked: !!hasAnimation,
        onChange: toggleAnimation
      }), React.createElement(hero_edit_RangeControl, {
        label: hero_edit_('Background Opacity'),
        value: dimRatio,
        onChange: setDimRatio,
        min: 0,
        max: 90,
        step: 5
      })), React.createElement(hero_edit_PanelBody, {
        title: hero_edit_('Size'),
        initialOpen: false
      }, React.createElement(hero_edit_RangeControl, {
        label: hero_edit_('Top Padding (px)'),
        value: paddingTop,
        onChange: setPaddingTop,
        min: 0,
        max: 500,
        step: 1
      }), React.createElement(hero_edit_RangeControl, {
        label: hero_edit_('Bottom Padding (px)'),
        value: paddingBottom,
        onChange: setPaddingBottom,
        min: 0,
        max: 500,
        step: 1
      }))));

      if (!url) {
        var hasTitle = !Object(external_lodash_["isEmpty"])(title);
        var icon = hasTitle ? undefined : 'format-image';
        var label = hasTitle ? React.createElement(hero_edit_RichText, {
          tagName: "h2",
          value: title,
          onChange: function onChange(value) {
            return setAttributes({
              title: value
            });
          },
          inlineToolbar: true
        }) : hero_edit_('Background Image');
        return React.createElement(hero_edit_Fragment, null, controls, React.createElement(MediaPlaceholder, {
          icon: icon,
          className: className,
          labels: {
            title: label,
            name: hero_edit_('an image')
          },
          onSelect: onSelectImage,
          accept: "image/*",
          type: "image",
          notices: noticeUI,
          onError: noticeOperations.createErrorNotice
        }));
      }

      return React.createElement(hero_edit_Fragment, null, controls, React.createElement("div", {
        "data-url": url,
        style: style,
        className: classes
      }, React.createElement("div", {
        className: "hero-block__content has-".concat(contentAlign, "-content"),
        style: {
          paddingTop: "".concat(paddingTop, "px"),
          paddingBottom: "".concat(paddingBottom, "px")
        }
      }, React.createElement(edit_InnerBlocks, {
        allowedBlocks: ['core/paragraph', 'core/heading', 'core/button', 'core/image', 'core/spacer', 'core/columns', 'vendify/hero-search'],
        template: [['core/heading'], ['core/paragraph'], ['core/button']],
        templateInsertUpdatesSelection: false
      }))));
    }
  }]);

  return HeroEdit;
}(hero_edit_Component);

/* harmony default export */ var hero_edit = (hero_edit_withNotices(edit_HeroEdit));
// CONCATENATED MODULE: ./resources/blocks/library/hero/index.js
/**
 * External dependencies.
 */

/**
 * WordPress dependencies.
 */

var hero_ = wp.i18n.__;
var hero_registerBlockType = wp.blocks.registerBlockType;
var hero_InnerBlocks = wp.editor.InnerBlocks;
/**
 * Internal dependencies.
 */


/**
 * Register "Hero" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */

hero_registerBlockType('vendify/hero', {
  title: hero_('Hero'),
  description: hero_('Grab your visitor\'s attention with a hero callout!'),
  icon: 'align-full-width',
  category: 'vendify',
  keywords: [hero_('hero'), hero_('call to action')],
  attributes: {
    title: {
      type: 'string'
    },
    subtitle: {
      type: 'string'
    },
    url: {
      type: 'string'
    },
    align: {
      type: 'string'
    },
    contentAlign: {
      type: 'string',
      default: 'center'
    },
    id: {
      type: 'number'
    },
    hasParallax: {
      type: 'boolean',
      default: false
    },
    hasAnimation: {
      type: 'boolean',
      default: true
    },
    dimRatio: {
      type: 'number',
      default: 50
    },
    paddingTop: {
      type: 'number',
      default: 130
    },
    paddingBottom: {
      type: 'number',
      default: 130
    }
  },

  /**
   * Ensure block alignment is reflected.
   *
   * @param {Object} attrributes Block attributes.
   * @return {Object} Wrapper properties.
   */
  getEditWrapperProps: function getEditWrapperProps(attributes) {
    return {
      'data-align': 'full'
    };
  },

  /**
   * Edit mode.
   */
  edit: hero_edit,

  /**
   * Save mode.
   *
   * Output handled on the server.
   *
   * @param {Object} attributes Block attributes.
   * @return {string}
   */
  save: function save() {
    return React.createElement(hero_InnerBlocks.Content, null);
  }
});
// EXTERNAL MODULE: ./resources/blocks/library/hero-search/index.js
var hero_search = __webpack_require__(72);

// EXTERNAL MODULE: ./resources/blocks/library/blog-posts/index.js
var blog_posts = __webpack_require__(73);

// CONCATENATED MODULE: ./resources/blocks/library/featured-post/index.js


/**
 * WordPress dependencies.
 */
var featured_post_ = wp.i18n.__;
var ServerSideRender = wp.components.ServerSideRender;
var featured_post_registerBlockType = wp.blocks.registerBlockType;
var featured_post_wp$blockEditor = wp.blockEditor,
    featured_post_InspectorControls = featured_post_wp$blockEditor.InspectorControls,
    featured_post_BlockControls = featured_post_wp$blockEditor.BlockControls,
    featured_post_BlockAlignmentToolbar = featured_post_wp$blockEditor.BlockAlignmentToolbar;
var featured_post_wp$components = wp.components,
    featured_post_PanelBody = featured_post_wp$components.PanelBody,
    TextControl = featured_post_wp$components.TextControl;

var featured_post_validAlignments = ['wide', 'full'];
var blockName = 'vendify/featured-post';
/**
 * Register "Blog Posts" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */

featured_post_registerBlockType(blockName, {
  title: featured_post_('Featured Post'),
  description: featured_post_('Add a featured post.'),
  icon: 'admin-post',
  category: 'vendify',
  keywords: [featured_post_('featured'), featured_post_('post')],
  attributes: {
    postID: {
      type: 'string',
      default: '1'
    },
    linkText: {
      type: 'string',
      default: 'View More'
    },
    align: {
      type: 'string'
    }
  },

  /**
   * Ensure block alignment is reflected.
   *
   * @param {Object} attrributes Block attributes.
   * @return {Object} Wrapper properties.
   */
  getEditWrapperProps: function getEditWrapperProps(attributes) {
    var align = attributes.align;

    if (-1 !== featured_post_validAlignments.indexOf(align)) {
      return {
        'data-align': align
      };
    }
  },

  /**
   * Edit mode.
   *
   * @param {Object} props Block properties.
   * @return {string} Edit block mode.
   */
  edit: function edit(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    var postID = attributes.postID,
        linkText = attributes.linkText,
        align = attributes.align;
    var classNames = classnames_default()('featured-post', defineProperty_default()({}, "align".concat(align), align));
    return React.createElement("div", {
      className: classNames
    }, React.createElement(featured_post_BlockControls, null, React.createElement(featured_post_BlockAlignmentToolbar, {
      value: align,
      onChange: function onChange(value) {
        return setAttributes({
          align: value
        });
      },
      controls: featured_post_validAlignments
    })), React.createElement(featured_post_InspectorControls, null, React.createElement(featured_post_PanelBody, null, React.createElement(TextControl, {
      label: featured_post_('Post ID'),
      value: postID,
      onChange: function onChange(postID) {
        return setAttributes({
          postID: postID
        });
      }
    }), React.createElement(TextControl, {
      label: featured_post_('"View More" Text'),
      value: linkText || '',
      onChange: function onChange(linkText) {
        setAttributes({
          linkText: linkText
        });
      }
    }))), React.createElement(ServerSideRender, {
      block: blockName,
      attributes: attributes
    }));
  },

  /**
   * Save mode.
   *
   * @return {null} Nothing.
   */
  save: function save() {
    return null;
  }
});
// CONCATENATED MODULE: ./resources/blocks/library/testimonial/edit.js






/**
 * External dependencies.
 */

/**
 * WordPress dependencies.
 */

var testimonial_edit_ = wp.i18n.__;
var testimonial_edit_wp$element = wp.element,
    testimonial_edit_Component = testimonial_edit_wp$element.Component,
    testimonial_edit_Fragment = testimonial_edit_wp$element.Fragment;
var testimonial_edit_wp$blockEditor = wp.blockEditor,
    testimonial_edit_RichText = testimonial_edit_wp$blockEditor.RichText,
    testimonial_edit_BlockControls = testimonial_edit_wp$blockEditor.BlockControls,
    testimonial_edit_BlockAlignmentToolbar = testimonial_edit_wp$blockEditor.BlockAlignmentToolbar,
    testimonial_edit_InspectorControls = testimonial_edit_wp$blockEditor.InspectorControls;
var testimonial_edit_wp$editor = wp.editor,
    testimonial_edit_MediaUpload = testimonial_edit_wp$editor.MediaUpload,
    edit_MediaPlaceholder = testimonial_edit_wp$editor.MediaPlaceholder;
var testimonial_edit_wp$components = wp.components,
    testimonial_edit_withNotices = testimonial_edit_wp$components.withNotices,
    testimonial_edit_PanelBody = testimonial_edit_wp$components.PanelBody,
    testimonial_edit_RangeControl = testimonial_edit_wp$components.RangeControl,
    edit_TextControl = testimonial_edit_wp$components.TextControl,
    testimonial_edit_ToggleControl = testimonial_edit_wp$components.ToggleControl,
    testimonial_edit_IconButton = testimonial_edit_wp$components.IconButton;
/**
 * Internal dependencies.
 */



/**
 * Edit a testimonial.
 */

var edit_TestimonialEdit =
/*#__PURE__*/
function (_Component) {
  inherits_default()(TestimonialEdit, _Component);

  function TestimonialEdit() {
    classCallCheck_default()(this, TestimonialEdit);

    return possibleConstructorReturn_default()(this, getPrototypeOf_default()(TestimonialEdit).apply(this, arguments));
  }

  createClass_default()(TestimonialEdit, [{
    key: "render",
    value: function render() {
      var _this$props = this.props,
          attributes = _this$props.attributes,
          setAttributes = _this$props.setAttributes,
          className = _this$props.className,
          isSelected = _this$props.isSelected,
          noticeUI = _this$props.noticeUI;
      var quote = attributes.quote,
          cite = attributes.cite,
          avatarUrl = attributes.avatarUrl,
          avatarId = attributes.avatarId,
          videoText = attributes.videoText,
          videoUrl = attributes.videoUrl,
          backgroundUrl = attributes.backgroundUrl,
          backgroundId = attributes.backgroundId,
          hasParallax = attributes.hasParallax,
          dimRatio = attributes.dimRatio,
          align = attributes.align;

      var onSelectBackgroundImage = function onSelectBackgroundImage(media) {
        return setAttributes({
          backgroundUrl: media.url,
          backgroundId: media.id
        });
      };

      var onSelectAvatarImage = function onSelectAvatarImage(media) {
        return setAttributes({
          avatarUrl: media.url,
          avatarId: media.id
        });
      };

      var toggleParallax = function toggleParallax() {
        return setAttributes({
          hasParallax: !hasParallax
        });
      };

      var setDimRatio = function setDimRatio(ratio) {
        return setAttributes({
          dimRatio: ratio
        });
      };

      var controls = React.createElement(testimonial_edit_Fragment, null, React.createElement(testimonial_edit_BlockControls, null, React.createElement(testimonial_edit_BlockAlignmentToolbar, {
        value: align,
        onChange: function onChange(value) {
          return setAttributes({
            align: value
          });
        },
        controls: testimonial_validAlignments
      }), React.createElement(testimonial_edit_MediaUpload, {
        onSelect: onSelectBackgroundImage,
        type: "image",
        value: backgroundId,
        render: function render(_ref) {
          var open = _ref.open;
          return React.createElement(testimonial_edit_IconButton, {
            className: "components-toolbar__control",
            label: testimonial_edit_('Edit image'),
            icon: "edit",
            onClick: open
          });
        }
      })), React.createElement(testimonial_edit_InspectorControls, null, React.createElement(testimonial_edit_PanelBody, null, React.createElement(edit_TextControl, {
        label: testimonial_edit_('Video URL'),
        value: videoUrl || '',
        onChange: function onChange(videoUrl) {
          setAttributes({
            videoUrl: videoUrl
          });
        }
      })), !!backgroundUrl && React.createElement(testimonial_edit_PanelBody, {
        title: testimonial_edit_('Background Image Settings')
      }, React.createElement(testimonial_edit_ToggleControl, {
        label: testimonial_edit_('Fixed Background'),
        checked: !!hasParallax,
        onChange: toggleParallax
      }), React.createElement(testimonial_edit_RangeControl, {
        label: testimonial_edit_('Background Opacity'),
        value: dimRatio,
        onChange: setDimRatio,
        min: 10,
        max: 90,
        step: 5
      }))));

      if (!backgroundUrl) {
        return React.createElement(testimonial_edit_Fragment, null, controls, React.createElement(edit_MediaPlaceholder, {
          icon: "format-image",
          className: className,
          labels: {
            title: testimonial_edit_('Background Image'),
            name: testimonial_edit_('an image')
          },
          onSelect: onSelectBackgroundImage,
          accept: "image/*",
          type: "image"
        }));
      }

      var imageClassNames = classnames_default()('testimonial-banner', dimRatioToClass(dimRatio), {
        'has-background-dim': dimRatio !== 0,
        'has-parallax': hasParallax
      });
      var imageStyle = backgroundImageStyles(backgroundUrl);
      return React.createElement(testimonial_edit_Fragment, null, noticeUI, controls, React.createElement("div", {
        className: className
      }, React.createElement("div", {
        className: imageClassNames,
        style: imageStyle,
        "data-url": backgroundUrl
      }, React.createElement("div", {
        className: "container"
      }, React.createElement("div", {
        className: "testimonial-banner__content"
      }, (quote || isSelected) && React.createElement("blockquote", {
        className: "testimonial-banner__quote"
      }, React.createElement(testimonial_edit_RichText, {
        tagName: "p",
        value: quote,
        multitline: true,
        onChange: function onChange(quote) {
          return setAttributes({
            quote: quote
          });
        },
        placeholder: 'I love this website...',
        keepPlaceholderOnFocus: true
      })), React.createElement("div", {
        className: "testimonial-banner__author"
      }, React.createElement(testimonial_edit_MediaUpload, {
        gallery: false,
        multiple: false,
        onSelect: onSelectAvatarImage,
        type: "image",
        value: avatarId,
        render: function render(_ref2) {
          var open = _ref2.open;
          return isSelected || !avatarUrl && isSelected ? React.createElement(testimonial_edit_IconButton, {
            className: "edit-image",
            icon: "format-image",
            onClick: open
          }) : React.createElement("img", {
            src: avatarUrl,
            alt: ""
          });
        }
      }), (cite || isSelected) && React.createElement("span", {
        className: "testimonial-banner__author-name"
      }, React.createElement(testimonial_edit_RichText, {
        tagName: "span",
        value: cite,
        multitline: false,
        onChange: function onChange(cite) {
          return setAttributes({
            cite: cite
          });
        },
        placeholder: 'John Doe'
      }))), (videoText || videoUrl || isSelected) && React.createElement("div", {
        className: "testimonial-banner__watch"
      }, React.createElement(testimonial_edit_RichText, {
        tagName: "span",
        value: videoText,
        multitline: false,
        onChange: function onChange(videoText) {
          return setAttributes({
            videoText: videoText
          });
        },
        placeholder: 'Watch the Video',
        keepPlaceholderOnFocus: true
      })))))));
    }
  }]);

  return TestimonialEdit;
}(testimonial_edit_Component);

/* harmony default export */ var testimonial_edit = (testimonial_edit_withNotices(edit_TestimonialEdit));
// CONCATENATED MODULE: ./resources/blocks/library/testimonial/index.js


/**
 * External dependencies.
 */

/**
 * WordPress dependencies.
 */

var testimonial_ = wp.i18n.__;
var testimonial_registerBlockType = wp.blocks.registerBlockType;
var testimonial_RichText = wp.blockEditor.RichText;
/**
 * Internal dependencies.
 */



var testimonial_validAlignments = ['wide', 'full'];
/**
 * Register "Testimonial" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */

testimonial_registerBlockType('vendify/testimonial', {
  title: testimonial_('Testimonial'),
  description: testimonial_('Add a testimonial with an optional video'),
  icon: 'format-quote',
  category: 'vendify',
  keywords: [testimonial_('testimonial'), testimonial_('quote')],
  attributes: {
    quote: {
      type: 'array',
      source: 'children',
      selector: '.testimonial-banner__quote p'
    },
    cite: {
      type: 'array',
      source: 'children',
      selector: '.testimonial-banner__author-name'
    },
    videoText: {
      type: 'array',
      source: 'children',
      selector: '.testimonial-banner__watch span'
    },
    videoUrl: {
      type: 'string'
    },
    avatarUrl: {
      type: 'string'
    },
    avatarId: {
      type: 'number'
    },
    backgroundUrl: {
      type: 'string'
    },
    backgroundId: {
      type: 'number'
    },
    hasParallax: {
      type: 'boolean',
      default: false
    },
    dimRatio: {
      type: 'number',
      default: 50
    },
    align: {
      type: 'string'
    }
  },

  /**
   * Ensure the block is always in full align mode.
   *
   * @param {Object} attributes Block attributes.
   * @return {Object} Wrapper properties.
   */
  getEditWrapperProps: function getEditWrapperProps(attributes) {
    var align = attributes.align;

    if (-1 !== testimonial_validAlignments.indexOf(align)) {
      return {
        'data-align': align
      };
    }
  },

  /**
   * Edit mode.
   */
  edit: testimonial_edit,

  /**
   * Save mode.
   *
   * @param {Object} attributes Block attributes.
   * @return {string} Block.
   */
  save: function save(_ref) {
    var _classnames;

    var attributes = _ref.attributes,
        className = _ref.className;
    var quote = attributes.quote,
        cite = attributes.cite,
        avatarUrl = attributes.avatarUrl,
        videoUrl = attributes.videoUrl,
        videoText = attributes.videoText,
        hasParallax = attributes.hasParallax,
        dimRatio = attributes.dimRatio,
        backgroundUrl = attributes.backgroundUrl,
        align = attributes.align;
    var classNames = classnames_default()('testimionial-banner', dimRatioToClass(dimRatio), (_classnames = {}, defineProperty_default()(_classnames, "align".concat(align), align), defineProperty_default()(_classnames, 'has-background-dim', dimRatio !== 0), defineProperty_default()(_classnames, 'has-parallax', hasParallax), _classnames));
    var imageStyle = backgroundImageStyles(backgroundUrl);
    return React.createElement("div", {
      className: className
    }, React.createElement("div", {
      className: classNames,
      style: imageStyle,
      "data-url": backgroundUrl
    }, React.createElement("div", {
      className: "container"
    }, React.createElement("div", {
      className: "testimonial-banner__content"
    }, quote && quote.length > 0 && React.createElement("blockquote", {
      className: "testimonial-banner__quote"
    }, React.createElement(testimonial_RichText.Content, {
      tagName: "p",
      value: quote
    })), cite && cite.length > 0 && React.createElement("div", {
      className: "testimonial-banner__author"
    }, avatarUrl && React.createElement("img", {
      src: avatarUrl,
      alt: ""
    }), React.createElement(testimonial_RichText.Content, {
      className: "testimonial-banner__author-name",
      tagName: "span",
      value: cite
    })), videoUrl && videoUrl.length > 0 && React.createElement("a", {
      href: videoUrl,
      className: "testimonial-banner__watch",
      target: "_blank",
      rel: "noindex noopener noreferrer"
    }, videoText && videoText.length > 0 && React.createElement(testimonial_RichText.Content, {
      tagName: "span",
      value: videoText
    }))))));
  }
});
// CONCATENATED MODULE: ./resources/blocks/library/products-with-filter/index.js


/**
 * WordPress dependencies.
 */
var products_with_filter_ = wp.i18n.__;
var products_with_filter_ServerSideRender = wp.components.ServerSideRender;
var products_with_filter_registerBlockType = wp.blocks.registerBlockType;
var products_with_filter_wp$blockEditor = wp.blockEditor,
    products_with_filter_InspectorControls = products_with_filter_wp$blockEditor.InspectorControls,
    products_with_filter_BlockControls = products_with_filter_wp$blockEditor.BlockControls,
    products_with_filter_BlockAlignmentToolbar = products_with_filter_wp$blockEditor.BlockAlignmentToolbar;
var products_with_filter_wp$components = wp.components,
    products_with_filter_PanelBody = products_with_filter_wp$components.PanelBody,
    products_with_filter_TextControl = products_with_filter_wp$components.TextControl;

var products_with_filter_validAlignments = ['wide', 'full'];
var products_with_filter_blockName = 'vendify/products-with-filter';
/**
 * Register "Blog Posts" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */

products_with_filter_registerBlockType(products_with_filter_blockName, {
  title: products_with_filter_('Products with category filter'),
  description: products_with_filter_('Show products with category filter'),
  icon: 'products',
  category: 'vendify',
  keywords: [products_with_filter_('filter'), products_with_filter_('products')],
  attributes: {
    postNumber: {
      type: 'string',
      default: '8'
    },
    align: {
      type: 'string'
    }
  },

  /**
   * Ensure block alignment is reflected.
   *
   * @param {Object} attrributes Block attributes.
   * @return {Object} Wrapper properties.
   */
  getEditWrapperProps: function getEditWrapperProps(attributes) {
    var align = attributes.align;

    if (-1 !== products_with_filter_validAlignments.indexOf(align)) {
      return {
        'data-align': align
      };
    }
  },

  /**
   * Edit mode.
   *
   * @param {Object} props Block properties.
   * @return {string} Edit block mode.
   */
  edit: function edit(props) {
    var attributes = props.attributes,
        setAttributes = props.setAttributes;
    var postNumber = attributes.postNumber,
        align = attributes.align;
    var classNames = classnames_default()('featured-post', defineProperty_default()({}, "align".concat(align), align));
    return React.createElement("div", {
      className: classNames
    }, products_with_filter_('Product with filter', 'vendify'), React.createElement(products_with_filter_BlockControls, null, React.createElement(products_with_filter_BlockAlignmentToolbar, {
      value: align,
      onChange: function onChange(value) {
        return setAttributes({
          align: value
        });
      },
      controls: products_with_filter_validAlignments
    })), React.createElement(products_with_filter_InspectorControls, null, React.createElement(products_with_filter_PanelBody, null, React.createElement(products_with_filter_TextControl, {
      label: products_with_filter_('Post per page'),
      value: postNumber,
      onChange: function onChange(postNumber) {
        return setAttributes({
          postNumber: postNumber
        });
      }
    }))), React.createElement(products_with_filter_ServerSideRender, {
      block: products_with_filter_blockName,
      attributes: attributes
    }));
  },

  /**
   * Save mode.
   *
   * @return {null} Nothing.
   */
  save: function save() {
    return null;
  }
});
// CONCATENATED MODULE: ./resources/blocks/extenders/button/index.js



/**
 * Externa dependencies.
 */


/**
 * WordPress dependencies.
 */

var addFilter = wp.hooks.addFilter;
var button_ = wp.i18n.__;
var button_Fragment = wp.element.Fragment;
var createHigherOrderComponent = wp.compose.createHigherOrderComponent;
var button_InspectorControls = wp.blockEditor.InspectorControls;
var button_wp$components = wp.components,
    button_PanelBody = button_wp$components.PanelBody,
    button_SelectControl = button_wp$components.SelectControl;
/**
 * Add new inspector control panel.
 *
 * @param {function|component} BlockEdit component.
 * @return {string} Wrapped component.
 */

addFilter('editor.BlockEdit', 'vendify/withInspectorControl', createHigherOrderComponent(function (BlockEdit) {
  return function (props) {
    if ('core/button' !== props.name) {
      return React.createElement(BlockEdit, props);
    }

    var setAttributes = props.setAttributes;
    var size = props.attributes.size;

    if ('core/button' !== props.name) {
      return React.createElement(BlockEdit, props);
    }

    return React.createElement(button_Fragment, null, React.createElement("div", {
      className: "btn-".concat(size)
    }, React.createElement(BlockEdit, props)), React.createElement(button_InspectorControls, null, React.createElement(button_PanelBody, {
      title: button_('Button Size')
    }, React.createElement(button_SelectControl, {
      value: size,
      options: [{
        value: 'sm',
        label: button_('Small')
      }, {
        value: 'default',
        label: button_('Default')
      }, {
        value: 'lg',
        label: button_('Large')
      }],
      onChange: function onChange(newValue) {
        return setAttributes({
          size: newValue
        });
      }
    }))));
  };
}, 'withInspectorControl'));
/**
 * Expose extra attributes for new controls.
 *
 * @param {Object} settings Settings configuration.
 * @param {string} name Block name.
 */

addFilter('blocks.registerBlockType', 'vendify/button', function (settings, name) {
  if ('core/button' !== name) {
    return settings;
  }

  var styles = settings.styles;
  var squared = Object(external_lodash_["find"])(styles, {
    name: 'squared'
  });
  var outline = Object(external_lodash_["find"])(styles, {
    name: 'outline'
  });
  return objectSpread_default()({}, settings, {
    styles: [objectSpread_default()({}, squared, {
      isDefault: true
    }), outline],
    attributes: objectSpread_default()({}, settings.attributes, {
      size: {
        type: 'string',
        default: 'default'
      }
    })
  });
});
/**
 * Update classname on save.
 */

addFilter('blocks.getSaveContent.extraProps', 'vendify/button', function (props, blockType, attributes) {
  var _attributes$size = attributes.size,
      size = _attributes$size === void 0 ? 'default' : _attributes$size;

  if ('core/button' !== blockType.name) {
    return props;
  }

  if (size) {
    return objectSpread_default()({}, props, {
      className: classnames_default()(props.className, defineProperty_default()({}, "btn-".concat(size), 'default' !== size))
    });
  }

  return props;
});
wp.blocks.registerBlockStyle('core/button', {
  name: 'rounded',
  label: 'Rounded'
});
// CONCATENATED MODULE: ./resources/blocks/extenders/registerPlugin.js







/**
 * WordPress dependencies.
 */
var registerPlugin_ = wp.i18n.__;
var registerPlugin_wp$element = wp.element,
    registerPlugin_Component = registerPlugin_wp$element.Component,
    registerPlugin_Fragment = registerPlugin_wp$element.Fragment;
var registerPlugin_wp$components = wp.components,
    registerPlugin_TextControl = registerPlugin_wp$components.TextControl,
    registerPlugin_RangeControl = registerPlugin_wp$components.RangeControl;
var _wp$editPost = wp.editPost,
    PluginSidebar = _wp$editPost.PluginSidebar,
    PluginSidebarMoreMenuItem = _wp$editPost.PluginSidebarMoreMenuItem;
var registerPlugin = wp.plugins.registerPlugin;
var registerPlugin_compose = wp.compose.compose;
var _wp$data = wp.data,
    withSelect = _wp$data.withSelect,
    registerPlugin_select = _wp$data.select,
    withDispatch = _wp$data.withDispatch;

var registerPlugin_VendifySidebarPlugin =
/*#__PURE__*/
function (_Component) {
  inherits_default()(VendifySidebarPlugin, _Component);

  function VendifySidebarPlugin() {
    var _this;

    classCallCheck_default()(this, VendifySidebarPlugin);

    _this = possibleConstructorReturn_default()(this, getPrototypeOf_default()(VendifySidebarPlugin).apply(this, arguments));
    _this.state = {
      key: null,
      selectedValue: ''
    };
    _this.handleOptionChange = _this.handleOptionChange.bind(assertThisInitialized_default()(assertThisInitialized_default()(_this)));
    _this.updateClassNames = _this.updateClassNames.bind(assertThisInitialized_default()(assertThisInitialized_default()(_this)));
    return _this;
  }

  createClass_default()(VendifySidebarPlugin, [{
    key: "handleOptionChange",
    value: function handleOptionChange(e) {
      var props = this.props;
      var meta = props.postData.meta;
      var newValue = e.target.value; // in case there is a click on the same checkbox it means that we are trying to uncheck.

      if (newValue === meta.vendify_content_width) {
        newValue = '';
      }

      this.props.updateContentWidth(newValue); // I just wanna trigger a re-render;

      this.setState({
        key: Math.random(),
        selectedValue: newValue
      });
    }
  }, {
    key: "updateClassNames",
    value: function updateClassNames() {
      var newClass = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
      var allClasses = arguments.length > 1 ? arguments[1] : undefined;
      var body = document.querySelector('body'); // remove any old className

      allClasses.map(function (c) {
        body.classList.remove(c);
      });

      if (newClass !== '') {
        // add the new className
        body.classList.add('vendify_content_width_' + newClass);
      }
    }
  }, {
    key: "render",
    value: function render() {
      var _this2 = this;

      var props = this.props;
      var meta = props.postData.meta;
      var currentValue = typeof meta.vendify_content_width !== "undefined" && meta.vendify_content_width !== "" ? meta.vendify_content_width : '';
      var body_classes = [];
      var contentWidthFields = ['very-thin', 'thin', 'normal', 'wide', 'very-wide'].map(function (i, j) {
        body_classes.push('vendify_content_width_' + i);
        return React.createElement("fieldset", {
          className: "vendify_content_width_img_radio_button",
          key: i
        }, React.createElement("input", {
          type: "radio",
          id: i,
          value: i,
          name: "vendify_content_width[" + i + "]",
          checked: currentValue === i,
          onClick: _this2.handleOptionChange
        }), React.createElement("label", {
          htmlFor: i
        }, i));
      });
      this.updateClassNames(currentValue, body_classes);
      return React.createElement(registerPlugin_Fragment, null, React.createElement(PluginSidebarMoreMenuItem, {
        target: "vendify-editor-sidebar"
      }, registerPlugin_('Vendify Sidebar')), React.createElement(PluginSidebar, {
        name: "vendify-editor-sidebar",
        title: registerPlugin_('Vendify Extras'),
        className: "vendify-sidebar-body"
      }, React.createElement("h3", {
        className: "field-title"
      }, registerPlugin_('Content Width')), React.createElement("form", {
        action: "#",
        name: "vendify-content-width",
        className: "vendify-content-width-field"
      }, contentWidthFields), React.createElement("p", {
        className: "components-base-control__help"
      }, registerPlugin_('Select the desired Content Width for this page. Blocks with alignment Wide or Full will ignore this setting.'))));
    }
  }]);

  return VendifySidebarPlugin;
}(registerPlugin_Component);

var VendifySidebarPluginComposed = registerPlugin_compose([withSelect(function (select) {
  return {
    postData: select('core/editor').getCurrentPost()
  };
}), withDispatch(function (dispatch, props) {
  return {
    updateContentWidth: function updateContentWidth(newWidth) {
      var meta = props.postData.meta;
      meta['vendify_content_width'] = newWidth;
      dispatch('core/editor').editPost({
        meta: {
          vendify_content_width: newWidth
        }
      });
    }
  };
})])(registerPlugin_VendifySidebarPlugin);
registerPlugin('vendify-editor-sidebar', {
  icon: 'layout',
  render: VendifySidebarPluginComposed
});
// EXTERNAL MODULE: ./node_modules/prop-types/index.js
var prop_types = __webpack_require__(16);
var prop_types_default = /*#__PURE__*/__webpack_require__.n(prop_types);

// CONCATENATED MODULE: ./resources/blocks/components/vendify-logo.js


/**
 * WordPress dependencies
 */

var vendify_logo_wp$components = wp.components,
    SVG = vendify_logo_wp$components.SVG,
    Path = vendify_logo_wp$components.Path,
    G = vendify_logo_wp$components.G;

var vendify_logo_VendifyLogo = function VendifyLogo(_ref) {
  var width = _ref.width,
      height = _ref.height,
      className = _ref.className;
  var classes = classnames_default()('vendify-logo', className);
  return React.createElement(SVG, {
    width: width,
    height: height,
    className: classes
  }, React.createElement("defs", null, React.createElement("linearGradient", {
    x1: "50%",
    y1: "2.052%",
    x2: "50%",
    y2: "50.178%",
    id: "a"
  }, React.createElement("stop", {
    stopColor: "#0062E0",
    offset: "0%"
  }), React.createElement("stop", {
    stopColor: "#002ACF",
    offset: "100%"
  })), React.createElement(Path, {
    d: "M6 9.895a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm12 0a3 3 0 1 1 0-6 3 3 0 0 1 0 6z",
    id: "c"
  }), React.createElement("filter", {
    x: "-38.9%",
    y: "-83.3%",
    width: "177.8%",
    height: "333.3%",
    filterUnits: "objectBoundingBox",
    id: "b"
  }, React.createElement("feOffset", {
    dy: "2",
    "in": "SourceAlpha",
    result: "shadowOffsetOuter1"
  }), React.createElement("feGaussianBlur", {
    stdDeviation: "2",
    "in": "shadowOffsetOuter1",
    result: "shadowBlurOuter1"
  }), React.createElement("feColorMatrix", {
    values: "0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.169270833 0",
    "in": "shadowBlurOuter1"
  }))), React.createElement(G, {
    fill: "none",
    fillRule: "evenodd"
  }, React.createElement(Path, {
    fill: "url(#a)",
    d: "M0 0h23.895L24 23.895H0z",
    transform: "translate(1 .105)"
  }), React.createElement(G, {
    transform: "translate(1 .105)"
  }, React.createElement("use", {
    fill: "#000",
    filter: "url(#b)"
  }), React.createElement("use", {
    fill: "#01068A"
  })), React.createElement(Path, {
    d: "M7 7l2 5.5s1 3.5 4 3.5 4-3.5 4-3.5L19 7",
    stroke: "#FFF",
    strokeWidth: "2",
    strokeLinecap: "round"
  })));
};

vendify_logo_VendifyLogo.propTypes = {
  width: prop_types_default.a.string,
  height: prop_types_default.a.string,
  className: prop_types_default.a.string
};
vendify_logo_VendifyLogo.defaultProps = {
  width: '26',
  height: '24'
};
/* harmony default export */ var vendify_logo = (vendify_logo_VendifyLogo);
// CONCATENATED MODULE: ./resources/blocks/extenders/register-category.js


/**
 * WordPress dependencies.
 */
var _wp$blocks = wp.blocks,
    getCategories = _wp$blocks.getCategories,
    setCategories = _wp$blocks.setCategories;
/**
 * Internal dependencies.
 */


setCategories([// Add a Vendify block category.
{
  slug: 'vendify',
  title: 'Vendify',
  icon: React.createElement(vendify_logo, null)
}].concat(toConsumableArray_default()(getCategories().filter(function (_ref) {
  var slug = _ref.slug;
  return slug !== 'vendify';
}))));
// CONCATENATED MODULE: ./resources/blocks/index.js
/**
 * Internal dependencies.
 */
// Custom blocks.











 // Modify core blocks.


 // register custom blocks category



/***/ })
/******/ ]);