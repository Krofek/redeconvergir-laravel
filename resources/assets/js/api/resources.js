/**
 * Vue XMLHttpRequests (i.e. Ajax calls)
 */

import Vue from 'vue'
import VueResource from 'vue-resource'

Vue.use(VueResource);
// add csrf token (in meta#csrf-token) to all post requests
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('value');

/**
 * Export resources (used in api/index.js)
 */
export const InitiativeResource = Vue.resource(laroute.action('api::initiatives'));
export const MarkerResource = Vue.resource(laroute.action('api::map-markers'));