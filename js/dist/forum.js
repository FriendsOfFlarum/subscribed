module.exports =
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
/******/ 	return __webpack_require__(__webpack_require__.s = "./forum.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./forum.js":
/*!******************!*\
  !*** ./forum.js ***!
  \******************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _src_forum__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./src/forum */ "./src/forum/index.js");
/* empty/unused harmony star reexport *//*
 * This file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js":
/*!******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js ***!
  \******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return _inheritsLoose; });
function _inheritsLoose(subClass, superClass) {
  subClass.prototype = Object.create(superClass.prototype);
  subClass.prototype.constructor = subClass;
  subClass.__proto__ = superClass;
}

/***/ }),

/***/ "./src/forum/index.js":
/*!****************************!*\
  !*** ./src/forum/index.js ***!
  \****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var flarum_common_extend__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! flarum/common/extend */ "flarum/common/extend");
/* harmony import */ var flarum_common_extend__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(flarum_common_extend__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var flarum_forum_components_NotificationGrid__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flarum/forum/components/NotificationGrid */ "flarum/forum/components/NotificationGrid");
/* harmony import */ var flarum_forum_components_NotificationGrid__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flarum_forum_components_NotificationGrid__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _notifications_DiscussionCreatedNotification__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./notifications/DiscussionCreatedNotification */ "./src/forum/notifications/DiscussionCreatedNotification.js");
/* harmony import */ var _notifications_UserCreatedNotification__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./notifications/UserCreatedNotification */ "./src/forum/notifications/UserCreatedNotification.js");
/* harmony import */ var _notifications_PostUnapprovedNotification__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./notifications/PostUnapprovedNotification */ "./src/forum/notifications/PostUnapprovedNotification.js");





app.initializers.add('fof-subscribed', function () {
  app.notificationComponents.discussionCreated = _notifications_DiscussionCreatedNotification__WEBPACK_IMPORTED_MODULE_2__["default"];
  app.notificationComponents.userCreated = _notifications_UserCreatedNotification__WEBPACK_IMPORTED_MODULE_3__["default"];
  app.notificationComponents.postUnapproved = _notifications_PostUnapprovedNotification__WEBPACK_IMPORTED_MODULE_4__["default"];
  Object(flarum_common_extend__WEBPACK_IMPORTED_MODULE_0__["extend"])(flarum_forum_components_NotificationGrid__WEBPACK_IMPORTED_MODULE_1___default.a.prototype, 'notificationTypes', function (items) {
    if (app.forum.attribute('subscribeDiscussionCreated')) {
      items.add('discussionCreated', {
        name: 'discussionCreated',
        icon: 'fas fa-pencil-alt',
        label: app.translator.trans('fof-subscribed.forum.settings.notify_discussion_created_label')
      }, 5);
    }

    if (app.forum.attribute('subscribePostUnapproved')) {
      items.add('postUnapproved', {
        name: 'postUnapproved',
        icon: 'fas fa-check',
        label: app.translator.trans('fof-subscribed.forum.settings.notify_post_unapproved_label')
      }, -10);
    }

    if (app.forum.attribute('subscribeUserCreated')) {
      items.add('userCreated', {
        name: 'userCreated',
        icon: 'fas fa-user-plus',
        label: app.translator.trans('fof-subscribed.forum.settings.notify_user_created_label')
      }, -10);
    }
  });
});

/***/ }),

/***/ "./src/forum/notifications/DiscussionCreatedNotification.js":
/*!******************************************************************!*\
  !*** ./src/forum/notifications/DiscussionCreatedNotification.js ***!
  \******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return DiscussionCreatedNotification; });
/* harmony import */ var _babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/inheritsLoose */ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js");
/* harmony import */ var flarum_forum_components_Notification__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flarum/forum/components/Notification */ "flarum/forum/components/Notification");
/* harmony import */ var flarum_forum_components_Notification__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flarum_forum_components_Notification__WEBPACK_IMPORTED_MODULE_1__);



var DiscussionCreatedNotification = /*#__PURE__*/function (_Notification) {
  Object(_babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__["default"])(DiscussionCreatedNotification, _Notification);

  function DiscussionCreatedNotification() {
    return _Notification.apply(this, arguments) || this;
  }

  var _proto = DiscussionCreatedNotification.prototype;

  _proto.icon = function icon() {
    // Same as create discussion button on purpose.
    return 'fas fa-edit';
  };

  _proto.href = function href() {
    var notification = this.attrs.notification;
    return app.route.discussion(notification.subject());
  };

  _proto.content = function content() {
    return app.translator.trans('fof-subscribed.forum.notifications.discussion_created_text', {
      user: this.attrs.notification.fromUser()
    });
  };

  return DiscussionCreatedNotification;
}(flarum_forum_components_Notification__WEBPACK_IMPORTED_MODULE_1___default.a);



/***/ }),

/***/ "./src/forum/notifications/PostUnapprovedNotification.js":
/*!***************************************************************!*\
  !*** ./src/forum/notifications/PostUnapprovedNotification.js ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return PostUnapprovedNotification; });
/* harmony import */ var _babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/inheritsLoose */ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js");
/* harmony import */ var flarum_forum_components_Notification__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flarum/forum/components/Notification */ "flarum/forum/components/Notification");
/* harmony import */ var flarum_forum_components_Notification__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flarum_forum_components_Notification__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var flarum_common_utils_string__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! flarum/common/utils/string */ "flarum/common/utils/string");
/* harmony import */ var flarum_common_utils_string__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(flarum_common_utils_string__WEBPACK_IMPORTED_MODULE_2__);




var PostUnapprovedNotification = /*#__PURE__*/function (_Notification) {
  Object(_babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__["default"])(PostUnapprovedNotification, _Notification);

  function PostUnapprovedNotification() {
    return _Notification.apply(this, arguments) || this;
  }

  var _proto = PostUnapprovedNotification.prototype;

  _proto.icon = function icon() {
    return 'fas fa-gavel';
  };

  _proto.href = function href() {
    var notification = this.attrs.notification;
    var post = notification.subject();
    return app.route.discussion(post.discussion(), post.number());
  };

  _proto.content = function content() {
    return app.translator.trans('fof-subscribed.forum.notifications.post_unapproved_text', {
      user: this.attrs.notification.fromUser()
    });
  };

  _proto.excerpt = function excerpt() {
    return Object(flarum_common_utils_string__WEBPACK_IMPORTED_MODULE_2__["truncate"])(this.attrs.notification.subject().contentPlain(), 200);
  };

  return PostUnapprovedNotification;
}(flarum_forum_components_Notification__WEBPACK_IMPORTED_MODULE_1___default.a);



/***/ }),

/***/ "./src/forum/notifications/UserCreatedNotification.js":
/*!************************************************************!*\
  !*** ./src/forum/notifications/UserCreatedNotification.js ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return UserCreatedNotification; });
/* harmony import */ var _babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/inheritsLoose */ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js");
/* harmony import */ var flarum_forum_components_Notification__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flarum/forum/components/Notification */ "flarum/forum/components/Notification");
/* harmony import */ var flarum_forum_components_Notification__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flarum_forum_components_Notification__WEBPACK_IMPORTED_MODULE_1__);



var UserCreatedNotification = /*#__PURE__*/function (_Notification) {
  Object(_babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__["default"])(UserCreatedNotification, _Notification);

  function UserCreatedNotification() {
    return _Notification.apply(this, arguments) || this;
  }

  var _proto = UserCreatedNotification.prototype;

  _proto.icon = function icon() {
    return 'fas fa-user-plus';
  };

  _proto.href = function href() {
    var notification = this.attrs.notification;
    return app.route.user(notification.subject());
  };

  _proto.content = function content() {
    return app.translator.trans('fof-subscribed.forum.notifications.user_created_text', {
      user: this.attrs.notification.fromUser()
    });
  };

  return UserCreatedNotification;
}(flarum_forum_components_Notification__WEBPACK_IMPORTED_MODULE_1___default.a);



/***/ }),

/***/ "flarum/common/extend":
/*!******************************************************!*\
  !*** external "flarum.core.compat['common/extend']" ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/extend'];

/***/ }),

/***/ "flarum/common/utils/string":
/*!************************************************************!*\
  !*** external "flarum.core.compat['common/utils/string']" ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['common/utils/string'];

/***/ }),

/***/ "flarum/forum/components/Notification":
/*!**********************************************************************!*\
  !*** external "flarum.core.compat['forum/components/Notification']" ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['forum/components/Notification'];

/***/ }),

/***/ "flarum/forum/components/NotificationGrid":
/*!**************************************************************************!*\
  !*** external "flarum.core.compat['forum/components/NotificationGrid']" ***!
  \**************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['forum/components/NotificationGrid'];

/***/ })

/******/ });
//# sourceMappingURL=forum.js.map