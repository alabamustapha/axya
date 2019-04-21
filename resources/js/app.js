
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Event = new Vue();


import Acl from './custom/acl'
// Tied to Vue so it can be used within it
Vue.prototype.$acl = new Acl(window.user); 


// Moment:
import moment from 'moment'


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
    height: '8px'
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


// VueCtkDateTimePicker: https://vuejsexamples.com/a-vuejs-component-for-select-date-time-2/
//                       https://github.com/chronotruck/vue-ctk-date-time-picker#readme
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';

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
Vue.component('searches',         require('./components/Searches.vue'));
Vue.component('prescription',     require('./components/Prescription.vue'));
Vue.component('drug',             require('./components/Drug.vue'));
Vue.component('display-prescription',require('./components/DisplayPrescription.vue'));
Vue.component('appointment-form', require('./components/appointments/AppointmentForm.vue'));
Vue.component('appointment-details', require('./components/appointments/AppointmentDetails.vue'));
Vue.component('user-search',      require('./components/UserSearch.vue'));
Vue.component('doctor-search',    require('./components/DoctorSearch.vue'));
Vue.component('admin-list',       require('./components/Admin/AdminList.vue'));
Vue.component('staff-list',       require('./components/Admin/StaffList.vue'));
Vue.component('schedule-calendar-users',   require('./components/Schedules/ScheduleCalendarUsers.vue'));
Vue.component('schedule-index',   require('./components/Schedules/ScheduleIndex.vue'));
Vue.component('schedule-list',    require('./components/Schedules/OldAttempt/ScheduleList.vue'));
Vue.component('schedule',         require('./components/Schedules/OldAttempt/Schedule.vue'));

Vue.component('pagination',       require('laravel-vue-pagination'));
// UTILITIES
Vue.component('loading-spinner',  require('./components/Utilities/LoadingSpinner.vue'));
Vue.component('doctor-verify-notif', require('./components/Utilities/DoctorVerifyNotif.vue'));
Vue.component('location-selection',  require('./components/Utilities/LocationSelection.vue'));

// Vue.component('vue-ctk-date-time-picker', VueCtkDateTimePicker);

const app = new Vue({
    el: '#app',
    router,
    data: {
      search: ''
    },
    methods: {
      // Used with @keyup.enter
      searchForQuery(){ 
        Event.$emit('search_stuff');
      },

      // searchForQuery: _.debounce(() => {
      //   Event.$emit('search_stuff');
      // }, 750),

      searchForUser: _.debounce(() => {
        Event.$emit('search_user');
      }, 750),

      searchForDoctor: _.debounce(() => {
        Event.$emit('search_doctor');
      }, 750),
    }
});