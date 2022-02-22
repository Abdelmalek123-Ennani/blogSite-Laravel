/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/script.js ***!
  \********************************/
// console.log('javascript working good');
var btnEditComment = document.querySelectorAll('.edit-button');
btnEditComment.forEach(function (btn) {
  btn.addEventListener('click', function () {
    if (btn.nextElementSibling.classList.contains('hidden')) {
      btn.nextElementSibling.classList.remove('hidden');
    } else {
      btn.nextElementSibling.classList.add('hidden');
    }
  });
});
/******/ })()
;