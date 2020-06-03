/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import { Form, HasError, AlertError } from 'vform'
window.form = Form
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import VueSimpleAlert from "vue-simple-alert";
import moment from 'moment'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import VueApexCharts from 'vue-apexcharts'

Vue.use(VueSimpleAlert)
Vue.use(moment)
Vue.use(Vuex)
Vue.use(VueRouter)
Vue.use(VueApexCharts)

let routes = [
    {path: '/', component: require('./components/Welcome.vue').default},
    {path: '/dashboard', component: require('./components/Dashboard.vue').default},
    
    // Meeting Room Routes
    {path: '/manage-rooms', component: require('./components/ManageRooms.vue').default},
    {path: '/manage-rooms/pending-list', component: require('./components/ManageRooms.vue').default},
    {path: '/manage-rooms/booking-list', component: require('./components/ManageRooms.vue').default},
    {path: '/manage-rooms/settings', component: require('./components/ManageRooms.vue').default},

    // Car Routes
    {path: '/manage-cars', component: require('./components/ManageCars.vue').default},
    {path: '/manage-cars/pending-list', component: require('./components/ManageCars.vue').default},
    {path: '/manage-cars/booking-list', component: require('./components/ManageCars.vue').default},
    {path: '/manage-cars/settings', component: require('./components/ManageCars.vue').default},

    // Document Routes
    {path: '/manage-docs', component: require('./components/ManageDocs.vue').default},
    {path: '/maintenance', component: require('./components/ManageMaintenance.vue').default},
    {path: '/manage-docs/:id', component: require('./components/DetailDocs.vue').default},

    // HRD Routes
    {path: '/hrd', component: require('./components/SalarySlipList.vue').default},
    {path: '/hrd/salary-slip', component: require('./components/SalarySlipList.vue').default},
    {path: '/hrd/salary-slip/:id', component: require('./components/SalarySlipDetail.vue').default},
    
    {path: '/manage-users', component: require('./components/Users.vue').default},
]

const router = new VueRouter({
    mode: 'history',
    hashbang: false,
    routes // short for `routes: routes`
})

Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + value.slice(1) ;
});
Vue.filter('ucwords', function(text){
    return text
        .split(' ')
        .map(w => w[0].toUpperCase() + w.substr(1).toLowerCase())
        .join(' ')
})
// Vue.filter('capitalize', function (str) {
//     let splitStr = str.toLowerCase().split(' ');
//     for (var i = 0; i < splitStr.length; i++) {
//        splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
//     }
    
//     return splitStr.join(' '); 
// })

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('apexchart', VueApexCharts);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */ 

let store = new Vuex.Store({
    state: {
        selectedPlaylist: [],
        playlistParentID: Number
    },
    mutations: {
        SET_SELECTED_PLAYLIST(state, item){
            let alreadyInArray = state.selectedPlaylist.indexOf(item);
            if(alreadyInArray == -1){
                state.selectedPlaylist.push(item);
            }else{
                state.selectedPlaylist.splice(alreadyInArray, 1);
            }
        },
        RESET_SELECTED_PLAYLIST(state){
            state.selectedPlaylist = [];
        },
        SET_PLAYLIST_PARENT_ID(state, id){
            state.playlistParentID = id;
        }
    },
    actions: {

    },
    getters: {
        getSelectedPlaylist(state){
            return state.selectedPlaylist
        }
    }
});

const app = new Vue({
    el: '#app',
    router,
    store,
    /*components: {
        'navbar': require('./components/Upload.vue'),
    }*/
}).$mount('#app')