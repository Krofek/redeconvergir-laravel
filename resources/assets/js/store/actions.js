import * as types from './mutation-types'
import Api from '../api'
import InitiativeMapService from '../services/initiative-map-service'

export const ajaxInitFilters = ({commit}) => {
    Api.getFiltersData().then((response) => {
        commit(types.update_filters_data, response.body.filters_data);
    }, (response) => {
        console.log(response)
    })
};

export const ajaxCallInitiatives = ({commit, state}) => {
    let request = {
        boundaries: JSON.stringify(state.bounds),
        searchQuery: state.searchQuery,
        filters: state.filters
    };

    Api.getInitiatives(request).then((response) => {
        commit(types.update_initiatives, response.body.initiatives);
    }, (response) => {
        console.log(response)
    })
};

export const ajaxCallMarkers = ({commit, state}) => {
    let request = {
        filters: state.filters
    };

    Api.getMarkers(request).then((response) => {
        commit(types.update_markers, response.body.markers);
    }, (response) => {
        console.log(response)
    })
};

export const updateBounds = ({commit}, bounds) => {
    commit(types.update_bounds, bounds)
};

export const clickInitiative = ({commit, state}, initiative) => {
    let service = new InitiativeMapService(state),
        correspondingMarkers = service.correspondingInState('markers', initiative.locations),
        initiativeMap = window.Vue.$refs['initiative-map'];

    if(_.size(correspondingMarkers) > 1){
        let bounds = InitiativeMapService.multipleMarkerBounds(correspondingMarkers),
            mapObject = initiativeMap.$refs['vgm-map'].$mapObject;
        
        mapObject.fitBounds(bounds);
    }else{
        let marker = correspondingMarkers[Object.keys(correspondingMarkers)[0]];
        initiativeMap.center = initiativeMap.getApparentCenterOf(marker.position);
    }

    commit(types.update_focused_markers, correspondingMarkers);
    commit(types.update_focused_initiatives, {
        [initiative.id]: initiative
    });
    commit(types.update_top_initiatives, {})
};

export const clickMarker = ({commit, state}, marker) => {
    let service = new InitiativeMapService(state),
        correspondingInitiatives = service.correspondingInState('initiatives', marker.initiatives);

    commit(types.update_focused_initiatives, correspondingInitiatives);
    commit(types.update_focused_markers, {
        [marker.id]: marker
    });
};

export const clear = ({commit}) => {
    commit(types.update_focused_initiatives, {});
    commit(types.update_top_initiatives, {});
    commit(types.update_focused_markers, {});
};

/**
 * Filter updates
 */
export const updateCategories = ({commit}, categories = []) => {
    commit(types.update_filters_categories, categories);
};

export const updateAudiences = ({commit}, audiences = []) => {
    commit(types.update_filters_audiences, audiences);
};

export const clearCriteria = ({commit}) => {
    updateCategories({commit});
    updateAudiences({commit});
    commit(types.update_search_query, "");
};

export const filterFocusedInitiatives = ({commit, state}, filteredFocusedInitiatives) => {
    let service = new InitiativeMapService(state),
        filteredFocusedMarkers = {};

    console.log('triggd ffi');
    _.each(filteredFocusedInitiatives, (initiative) => {
        let correspondingMarkers = service.correspondingInState('markers', initiative.locations);
        _.assign(filteredFocusedMarkers, correspondingMarkers);
    });
    commit(types.update_focused_initiatives, filteredFocusedInitiatives);
    commit(types.update_focused_markers, filteredFocusedMarkers);
};