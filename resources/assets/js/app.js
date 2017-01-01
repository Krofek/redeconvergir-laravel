/**
 * Main app.js file included in just before closing body tag, </body>.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'
import store from './store'

import VueLocalization from 'vue-i18n'
import Locales from './generated/vue-i18n-locales.generated'

import InitiativeMap from './components/initiative-map/index.vue';

/**
 * Routing
 */
Vue.use(VueRouter);

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
    components: {
        InitiativeMap
    }
});

$(document).ready(() => {

});