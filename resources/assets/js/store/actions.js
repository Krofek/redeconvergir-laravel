import * as types from './mutation-types'
import Api from '../api'
import InitiativeMapService from '../services/initiative-map-service'

export const ajaxCallInitiatives = ({commit, state}) => {
    let request = {
        boundaries: JSON.stringify(state.bounds),
        searchQuery: state.searchQuery
    };
    Api.getInitiatives(request).then((response) => {
        console.log(response.body.initiatives);
        commit(types.update_initiatives, response.body.initiatives);
    }, (response) => {
        console.log(response)
    })
};

export const ajaxCallMarkers = ({commit}) => {
    Api.getMarkers().then((response) => {
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
        marker = correspondingMarkers[Object.keys(correspondingMarkers)[0]],
        initiativeMap = window.Vue.$refs['initiative-map'],
        mapObject = initiativeMap.$refs['vgm-map'].$mapObject;

    if(_.size(correspondingMarkers) > 1){
        let bounds = InitiativeMapService.multipleMarkerBounds(correspondingMarkers);
        mapObject.fitBounds(bounds);
    }else{
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