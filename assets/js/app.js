require('../css/app.css');
require('../css/animated_css.css');
require('jquery/dist/jquery');
global.$ = global.jQuery = $;

const element =  document.querySelector('#flashes');
element.classList.add('animated', 'bounceOut', 'delay-2s');
element.addEventListener('animationend', function() {
    $('#flashes').remove()
});
