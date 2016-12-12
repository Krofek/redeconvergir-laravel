import Vue from 'vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'

import VueLocalization from 'vue-i18n'
import Locales from './generated/vue-i18n-locales.generated'

import InitiativeMap from './components/initiative_map/initiative-map.vue';

/**
 * Routing
 */
Vue.use(VueRouter);

/**
 * Vue XMLHttpRequests (i.e. Ajax calls)
 */
Vue.use(VueResource);
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('value');

/**
 * Localization binding Vue-Laravel.
 */
Vue.use(VueLocalization);
Vue.config.lang = 'sl';
Object.keys(Locales).forEach(function (lang) {
    Vue.locale(lang, Locales[lang])
});

new Vue({
    el: '#app',
    components: {
        InitiativeMap
    }
});