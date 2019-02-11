/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
import '../css/global.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// import $ from 'jquery';

var $ = require('jquery');
global.$ = $;
global.jQuery = $;

// bootstrap does not export anything
require('bootstrap');

// to look for a local file start path with './' or '../' for a previous folder
import greet from './greet.js';

$(document).ready(function() {
//	$('body').prepend('<h1>' + greet('Satoshi Nakamoto') + '</h1>');
	console.log('document is ready');

	// test bootstrap pop
//	$('[data-toggle="popover"]').popover();
});

//console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

// autoload images (miniatures and brand in common folder)
const imagesContext = require.context('../images/common', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);