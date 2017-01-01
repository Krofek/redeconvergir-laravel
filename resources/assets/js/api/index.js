import {InitiativeResource, MarkerResource} from './resources'

export default {
    getInitiatives(params){
        console.log(laroute.action('api::initiatives'));
        return InitiativeResource.get(params);
    },
    getMarkers(params){
        console.log(laroute.action('api::map-markers'));
        return MarkerResource.get(params);
    }
}