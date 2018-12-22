
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Event = new Vue();


import Acl from './acl'
// Tied to Vue so it can be used within it
Vue.prototype.$acl = new Acl(window.user); 


// Moment:
import moment from 'moment'


// AOS (Animate On Scroll Library):
import AOS from 'aos'


// VueForm:
import { Form, HasError, AlertError } from 'vform'
window.Form = Form // Available globally for global access.
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


// VueRouter:
import VueRouter from 'vue-router'
Vue.use(VueRouter)


// VueProgressBar:
// Import and Add to master.blade.php after <router-view>
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
})


// SweetAlert:
// ES6 Modules or TypeScript
import swal from 'sweetalert2'
window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;


// Vue Filters
Vue.filter('upText', function(text)   { return text.toUpperCase() });
Vue.filter('myDate', function(created){ return moment(created).format("MMM Do YY") });


// Vue Routes
let routes = [
    // { path: '/searches', component: require('./components/Searches.vue')},

    // { path: '/appointments',       component: require('./components/appointments/AppointmentIndex.vue')},
    // { path: '/appointments/:slug', component: require('./components/appointments/AppointmentShow.vue')},
];
const router = new VueRouter({
    mode: 'history',
    routes // short for "routes: routes"
});



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component',require('./components/ExampleComponent.vue'));
Vue.component('searches',         require('./components/Searches.vue'));
Vue.component('schedule-list',    require('./components/ScheduleList.vue'));
Vue.component('schedule',         require('./components/Schedule.vue'));
Vue.component('prescription',     require('./components/Prescription.vue'));
Vue.component('drug',             require('./components/Drug.vue'));
Vue.component('edit-prescription',require('./components/EditPrescription.vue'));
Vue.component('appointment-form', require('./components/appointments/AppointmentForm.vue'));
Vue.component('appointment-details', require('./components/appointments/AppointmentDetails.vue'));

Vue.component('pagination', require('laravel-vue-pagination'));

const app = new Vue({
    el: '#app',
    router,
    data: {
      search: ''
    },
    methods: {
      searchForQuery: _.debounce(() => {
        Event.$emit('search_stuff');
      }, 750)

      // Used with @keyup.enter
      // searchForQuery(){ 
      //   Event.$emit('search_stuff');
      // }
    }
});