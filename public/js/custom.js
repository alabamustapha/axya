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
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 246);
/******/ })
/************************************************************************/
/******/ ({

/***/ 246:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(247);
module.exports = __webpack_require__(248);


/***/ }),

/***/ 247:
/***/ (function(module, exports) {


$('[data-toggle="tooltip"]').tooltip();
$('[data-toggle="popover"]').popover();
$('.carousel').carousel();

/***/ }),

/***/ 248:
/***/ (function(module, exports) {

$(document).ready(function () {

    //   NAVIGATION TOGGLE 
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active'), $('#content').toggleClass('active');
    });

    var $excessNav = $('.xs-nav');
    var $buttomNav = $('#extra-buttom-nav');
    var $buttomBtnToggler = $('.buttom-nav-toggler');

    if (document.body.scrollWidth <= 992) {
        $excessNav.hide();
        $buttomNav.addClass('collapse ');
        $('.navbar-brand img').attr('src', '../images/axya-logo-mini.svg').css('margin', '0'), $('.main-nav').find('.search-form').css('padding', '.25rem'), $('.notification-count').css('borderColor', '#147ba7');
        // alert("yes");      
    } else {
        $excessNav.show(), $buttomNav.show();
        // alert("nont");      
    }

    $buttomBtnToggler.click(function () {
        $('#buttom-nav').append($buttomNav), $('#content').toggleClass('active-buttom'), $('#sidebar').toggleClass('active-buttom'), 0;
        $buttomNav.find('.nav-avatar').hide();
        $buttomNav.toggleClass('active');
    });

    // // SEARCH SCRIPT
    //         // GLOBALS
    //         let $searchForm = $('.search-form'),
    //             $searchComponents = $('.search-component'),
    //             $searchOption= $('.search-options'),
    //             $ssDisplay = $('.search-select-display'),
    //             $searchItem = $('.search-item'),
    //             $filterItem = $('.filter .dropdown-item'),
    //             $profileContainer = $('.profile-container');


    //         // show the search-components


    //         function openAction() {
    //             $searchComponents.show().css('z-index', '3');
    //             $searchOption.css('z-index', '10'),
    //             $ssDisplay.css({'opacity': '1', 'z-index': '10'});
    //             $('.crumb').hide();
    //             $('.wrapper-content .content').hide();

    //         }

    //         function closeAction() {
    //             $searchComponents.hide().css('z-index', '-10'),
    //                 $ssDisplay.css({ 'opacity': '0', 'z-index': '-10' });
    //             $('.crumb').show();
    //             $('.wrapper-content .content').show();

    //         }

    //         $searchForm.keypress(openAction);

    //         $searchForm.keyup(function(){
    //             if($searchForm.val() == ""){
    //                closeAction();
    //                 $ssDisplay.find('.display-wrapper').hide();
    //             }

    //         });


    //         // DISPLAY FILTER LIST AND TYPE


    //         if ($filterItem.hasClass('active')){
    //             $('.filter-type').text($('.filter .dropdown-item.active').text());
    //         }
    //         $filterItem.click(function () {
    //            $filterItem.removeClass('active');
    //            $(this).addClass('active');  

    //            let filterText = $(this).text();
    //            $('.filter-type').text(filterText);
    //         })


    //         // GET SERACH RESULT INFO 

    //         $searchItem.click(function(){
    //                 $ssDisplay.find('.display-wrapper').show();

    //             let name =       $(this).find('#p-d').find('.name').text(),
    //                 speciality = $(this).find('#p-d').find('.speciality').text(),
    //                 workName =   $(this).find('#w-d').find('.name').text(),
    //                 fee =        $(this).find('#w-d').find('.fee strong').text(),
    //                 imgSrc=      $(this).find('.doc-img').attr('src');


    //                 $ssDisplay.find('.user-img img').attr('src', imgSrc);
    //                 $ssDisplay.find('.details .name').text(name);
    //                 $ssDisplay.find('.details .speciality').text(speciality);

    //                 $profileContainer.find('.profile-img img').attr('src', imgSrc),
    //                 $profileContainer.find('.profile-details .category .name').text(name),
    //                 $profileContainer.find('.profile-details .category .office-name').text(workName),
    //                 $profileContainer.find('.profile-details .fee').text(fee);


    //         });


    // MESSAGE SCRIPT

    $('.msg-search-icon').click(function () {
        $('.msg-contact-head .head-main').hide();
        $('.msg-search').show();
    });

    $('.search-close').click(function () {
        $('.msg-contact-head .head-main').show();
        $('.msg-search').hide();
    });

    if (window.screen.width < 768) {
        $('#msg-contact-over').append($('.msg-contact'));
    }
    $('.msg-contact-toggle').click(function (e) {
        e.preventDefault();
        $('.contact-over').addClass('active');
    });
    $('.contact-close').click(function (e) {
        e.preventDefault();
        $('.contact-over').removeClass('active');
    });
});

/***/ })

/******/ });