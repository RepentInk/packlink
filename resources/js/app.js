window.Vue = require('vue');

require('./bootstrap');
require('./script');

//import packages
import Swal from 'sweetalert2';
import vSelect from 'vue-select';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import StarRating from 'vue-star-rating'


//sweet alert
Vue.use(Loading);
window.Swal = Swal;
window.Fire = new Vue();

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.Toast = Toast;



// Registering vue component
Vue.component("v-select", vSelect);
Vue.component('index-component', require('./component/Index').default);
Vue.component('login-component', require('./component/Login').default);
Vue.component('signup-component', require('./component/SignUp').default);
Vue.component('dashboard-component', require('./component/Dashboard').default);

Vue.component('profile-component', require('./page/Profile').default);
Vue.component('home-component', require('./page/Home').default);
Vue.component('user-component', require('./page/Users').default);
Vue.component('user-profile-component', require('./page/UserProfile').default);
Vue.component('user-package-component', require('./page/Package').default);
Vue.component('search-package-component', require('./page/SearchPackage').default);
Vue.component('star-rating', StarRating);



//Registering admin component
Vue.component('admin-dashboard-component', require('./admin/Dashboard').default);
Vue.component('admin-user-component', require('./admin/Users').default);
Vue.component('admin-profile-component', require('./admin/Profile').default);
Vue.component('admin-category-component', require('./admin/Category').default);
Vue.component('admin-language-component', require('./admin/Language').default);
Vue.component('admin-installation-component', require('./admin/Installation').default);
Vue.component('admin-package-component', require('./admin/Package').default);


const app = new Vue({
    el: '#app'
});