import {InitiativeResource, MarkerResource, FiltersDataResource} from './resources'

export default {
    getFiltersData(params){
        console.log(laroute.action('api::initiative-filters-data'));
        return FiltersDataResource.get(params);
    },
    getInitiatives(params){
        console.log(laroute.action('api::initiatives'));
        return InitiativeResource.get(params);
    },
    getMarkers(params){
        console.log(laroute.action('api::map-markers'));
        return MarkerResource.get(params);
    }
}