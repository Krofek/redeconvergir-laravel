import Vue from 'vue'
import Vuex from 'vuex'
import * as actions from './actions'
import * as getters from './getters'
import mutations from "./mutations";
// import modules here

Vue.use(Vuex);
// Do not enable strict mode when deploying for production! Strict mode runs a deep watch on the state tree for
// detecting inappropriate mutations. It costs.

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    state: {
        initiatives: [],
        markers: [],
        focusedInitiatives: [],
        topInitiatives: [],
        focusedMarkers: [],
        searchQuery: "",
        bounds: {},
        filtersData: [],
        filters: {
            categories: [],
            audiences: []
        }
    },
    actions,
    getters,
    mutations,
    modules: {
        // list modules here
    },
    strict: debug
}) 