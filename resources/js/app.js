window.Vue = require('vue');

require('./bootstrap');







//Registering vue component
Vue.component('index-component', require('./component/Index').default);


const app = new Vue({
    el: '#app'
});