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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/client/employee/main.js":
/***/ (function(module, exports) {

/**
 * Created by kevinpurwono on 11/11/17.
 */
$(document).ready(function () {

    $('.datepicker').datepicker({ format: 'dd/mm/yyyy' });

    $(function ($) {
        $("#birth-date").mask("99/99/9999");
    });

    var personalInfoForm = $('#personalInformationForm');

    $('#createEmployeeBtn').on('click', function () {
        var formData = personalInfoForm.serialize();
        /* TODO CREATE VALIDATION FROM CONTROLLER AND SEND WITH AXIOS*/
    });

    $('#go-back-to-personal-tab').on('click', function () {
        goToPersonalInfoTab();
    });

    function goToEmploymentTab() {
        clearActiveTab();
        $('#item-employment').addClass('active');
        $('#tab-employment').addClass('active');
    }

    function goToPersonalInfoTab() {
        clearActiveTab();
        $('#item-personal-info').addClass('active');
        $('#tab-personal-info').addClass('active');
    }

    function clearActiveTab() {
        $('.tab-pane').removeClass('active');
        $('.nav-item a').removeClass('active');
    }
});

/***/ }),

/***/ 1:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/client/employee/main.js");


/***/ })

/******/ });