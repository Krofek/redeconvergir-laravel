/**
 * app.js file must be included just before closing body tag </body>.
 *
 * Firstly, import all basic plugins needed for our app to work.
 */
import Vue from 'vue'
import VueResource from 'vue-resource'
import store from './store'
import VueRouter from 'vue-router'
import { sync } from 'vuex-router-sync'

/**
 * Localization in Vue
 */
import VueLocalization from 'vue-i18n'
import Locales from './generated/vue-i18n-locales.generated'

/**
 * App components
 */
import InitiativeMap from './components/initiative-map/index.vue';

/**
 * Routing
 */
import routes from './routes';
Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    routes: routes
});

/**
 * Localization binding Vue-Laravel.
 */
Vue.use(VueLocalization);
Vue.config.lang = 'sl';
Object.keys(Locales).forEach(function (lang) {
    Vue.locale(lang, Locales[lang])
});

window.Vue = new Vue({
    el: '#app',
    store,
    router,
    components: {
        InitiativeMap
    }
});

/**
 * Non-vue scripts. Pls try to integrate app frontend behaviour with Vue as much as possible.
 */