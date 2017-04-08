export default class InitiativeMapService {
    /**
     * Constructor.
     * 
     * @param state
     */
    constructor(state) {
        this.state = state
    }

    /**
     * Returns objects in store state that correspond to given id-keyed dictionary of objects.
     *
     * @param entityName
     * @param objectsKeyed
     */
    correspondingInState(entityName, objectsKeyed) {
        return _.reduce(this.state[entityName], function(entities, e) {
            if(e.id in objectsKeyed){
                entities[e.id] = e;
            }
            return entities;
        }, {});
    }

    /**
     * Returns ratio of sidebar width to body width.
     *
     * @returns {number}
     */
    static sidebarToBodyRatio() {
        return $('.sidebar-wrapper').outerWidth() / $('body').width()
    }

    /**
     * Returns sidebar width in degrees, which is usable for
     *
     * @param bounds
     * @param proportionStretch
     * @returns {number}
     */
    static sidebarWidthDeg(bounds, proportionStretch = false) {
        let ratio = this.sidebarToBodyRatio(),
            westLng = bounds.getSouthWest().lng(),
            eastLng = bounds.getNorthEast().lng(),
            divisor = proportionStretch ? (1 - ratio) : 1;
        return (eastLng - westLng) * ratio / divisor
    }

    /**
     * Returns LatLngBounds used for focusing multiple markers that correspond to an initiative.
     *
     * @param markers
     * @returns {L.LatLngBounds|o.LatLngBounds}
     */
    static multipleMarkerBounds(markers) {
        // fill bounds with markers
        let bounds = new google.maps.LatLngBounds();
        _.each(markers, function (marker) {
            bounds.extend(marker.position)
        });
        // add sidebar's width in lng (degrees)
        let sidebarSpaceLng = InitiativeMapService.sidebarWidthDeg(bounds, true);
        bounds.extend({
            lat: bounds.getSouthWest().lat(),
            lng: bounds.getSouthWest().lng() - sidebarSpaceLng
        });

        return bounds
    }
}