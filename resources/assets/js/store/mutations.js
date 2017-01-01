import * as types from './mutation-types'

export default {
    [types.update_initiatives] (state, initiatives){
        state.initiatives = initiatives
    },
    [types.update_markers] (state, markers){
        state.markers = markers
    },
    [types.update_focused_initiatives] (state, initiatives){
        state.focusedInitiatives = initiatives
    },
    [types.update_top_initiatives] (state, initiatives){
        state.topInitiatives = initiatives
    },
    [types.update_top_and_focused_initiatives] (state, initiatives){
        state.topInitiatives = initiatives;
        state.focusedInitiatives = initiatives
    },
    [types.update_focused_markers] (state, markers){
        state.focusedMarkers = markers
    },
    [types.update_bounds] (state, bounds){
        state.bounds = bounds
    },
    [types.update_search_query] (state, searchQuery){
        state.searchQuery = searchQuery
    }
}