/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
/***********************************************************/
import Swal from 'sweetalert2';
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
  window.Toast = Toast;
/***********************************************************/
import VueRouter from 'vue-router';
Vue.use(VueRouter);
let routes = [
    {path:'/dashboard',component:require('./components/Dashboard.vue').default},
    {path:'/users',component:require('./components/Users.vue').default},
    {path:'/immeubles',component:require('./components/Immeubles.vue').default},
    {path:'/appartements',component:require('./components/Appartements.vue').default},
    {path:'/clients',component:require('./components/Clients.vue').default},
    {path:'/visites',component:require('./components/Visites.vue').default},
    {path:'/promesseVentes',component:require('./components/PromesseVentes.vue').default},
    {path:'/avocats',component:require('./components/Avocats.vue').default},
    {path:'/signatures',component:require('./components/Signatures.vue').default},
    {path:'/desistements',component:require('./components/Desistements.vue').default},
    {path:'/payements',component:require('./components/Payements.vue').default},
    {path:'/contratVenteDefinitifs',component:require('./components/contratVenteDefinitifs.vue').default},
    {path:'/procesVerbals',component:require('./components/ProcesVerbals.vue').default}
];
const router = new VueRouter({
    routes
})
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('page-title', require('./components/PageTitle.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
