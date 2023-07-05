/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

Vue.prototype.window = window;
window.$ = require('jquery');



import { library } from '@fortawesome/fontawesome-svg-core'
import { faTwitter, faFacebook, faInstagram } from '@fortawesome/free-brands-svg-icons'
import { faMagnifyingGlass, faArrowRightToBracket, faRightFromBracket, faBars, faComments, faHeart, faHeartBroken, faTrash, faTriangleExclamation, faUser, faPenToSquare, faEye, faCirclePlus, faCircleCheck, faCircleXmark} from '@fortawesome/free-solid-svg-icons'
import { } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Notifications from 'vue-notification'
import VModal from 'vue-js-modal'
import underscore from 'vue-underscore';
import VuePluralize from 'vue-pluralize'

library.add(faTwitter, faFacebook, faInstagram, faMagnifyingGlass, faArrowRightToBracket, faBars, faComments, faHeart, faHeartBroken, faRightFromBracket, faTrash, faTriangleExclamation, faUser, faPenToSquare, faEye, faCirclePlus, faCircleCheck, faCircleXmark)

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
Vue.component('navigation', require('./components/Navigation.vue').default);
Vue.component('site-footer', require('./components/SiteFooter.vue').default);
Vue.component('tags', require('./components/Tags.vue').default);
Vue.component('categories', require('./components/Categories.vue').default);
Vue.component('horizontal-post-list', require('./components/HorizontalPostList.vue').default);
Vue.component('author', require('./components/Author.vue').default);
Vue.component('contact', require('./components/Contact.vue').default);
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.use(Notifications)
Vue.use(VModal)
Vue.use(underscore)
Vue.use(VuePluralize)

// authentication components
require('./auth');

Vue.component('home', require('./components/Home.vue').default);
Vue.component('rating', require('./components/Rating.vue').default);


// post related components
require('./post');
require('./filters');
require('./users');
require('./admin');



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
