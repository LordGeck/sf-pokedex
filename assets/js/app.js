/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
import '../css/global.scss';

global.jQuery = require('jquery');
const $ = require('jquery');

// bootstrap does not export anything
require('bootstrap');

// to look for a local file start path with './' or '../' for a previous folder
// import greet from './greet.js';

// enable datatables lib
import dt from 'datatables.net-bs4';
dt(window, $);
import 'datatables.net-bs4/css/dataTables.bootstrap4.css'

// autoload images (miniatures and brand in common folder)
// common
const imagesCommonContext = require.context('../images/common', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesCommonContext.keys().forEach(imagesCommonContext);
// sprites
//const imagesSpritesContext = require.context('../images/sprites', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
//imagesSpritesContext.keys().forEach(imagesSpritesContext);
// artworks (heavier, seek an alternative)
const imagesArtworksContext = require.context('../images/artworks', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesArtworksContext.keys().forEach(imagesArtworksContext);
