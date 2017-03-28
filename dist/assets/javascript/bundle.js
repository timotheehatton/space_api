(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

var timeline = document.querySelector('.timeline'),
    items = document.querySelectorAll('.item--container'),
    btn_previous = document.querySelector('.previous'),
    window_width,
    btn_next = document.querySelector('.next');

function cover() {
  window_width = window.innerWidth;
  for (var i = 0; i < items.length; i++) {
    items[i].style.width = window_width / 2 + 'px';
  }
  timeline.style.width = window_width * items.length + 'px';
  timeline.style.marginLeft = -window_width / 4 + 'px';
}
cover();
window.addEventListener('resize', cover);

function slider() {
  var i = 0;
  items[1].classList.add('item--active');
  btn_next.addEventListener('click', function (e) {
    i++;
    if (i == items.length - 1) i = 0;
    items[i].classList.remove('item--active');
    items[i + 1].classList.add('item--active');
    timeline.style.transform = 'translate(-' + window_width / 2 * i + 'px)';
    e.preventDefault();
  });
  btn_previous.addEventListener('click', function (e) {
    if (i === 0) i = items.length - 1;
    i--;
    timeline.style.transform = 'translate(-' + window_width / 2 * i + 'px)';
    e.preventDefault();
  });
}
slider();

},{}]},{},[1])

//# sourceMappingURL=bundle.js.map
