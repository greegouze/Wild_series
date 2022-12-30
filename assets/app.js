/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

/* import logoPath from '../images/logo.png';

let html = `<img src="${logoPath}" alt="ACME logo">`; */

console.log('Hello Webpack Encore !')

require('bootstrap');// j appel boostrap

import headerPath from './images/bvn.webp';

let html = `<img src="${headerPath}" alt="image of retro wave">`;

import logoPath from './images/placeholder.jpeg';

let logo = `<img src="${logoPath}" alt="image of retro wave">`;
// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover(); //animation js 
});