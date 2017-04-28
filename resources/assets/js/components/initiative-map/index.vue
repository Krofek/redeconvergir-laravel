<template>
    <div class="page-full">
        <sidebar ref="sidebar"></sidebar>
        <vgm-map
                :center="center"
                :zoom="zoom"
                :map-type-id="mapTypeId"
                :options="options.map"
                ref="vgm-map"
                @zoom_changed="zoom = $event"
                @bounds_changed="updateBounds($event)"
                @center_changed="reportedCenter = $event"
                @idle="idle"
        >
            <vgm-marker
                    v-for="m in markers"
                    :position="m.position"
                    :initiatives="m.initiatives"
                    :clickable="true"
                    :icon="init.marker.icon"
                    :draggable="false"
                    @click="clickMarker(m)"
            >
                <vgm-info-window
                        :opened="m.id in focusedMarkers"
                        @closeclick="closeInfoWindow"
                >``
                    <div class="bs-component">
                        <div class="list-group">
                            <a href="#" class="list-group-item" v-for="i in m.initiatives">
                                {{ i.name }}
                            </a>
                        </div>
                    </div>
                </vgm-info-window>
            </vgm-marker>
        </vgm-map>
    </div>
</template>

<script type="text/babel">
    import * as VueGoogleMap from 'vue2-google-maps'
    import {mapGetters, mapActions} from 'vuex'
    import Sidebar from './sidebar.vue'
    import InitiativeMapService from "../../services/initiative-map-service";

    VueGoogleMap.load('AIzaSyAveqa-JPO_vdHeJFVp-FH8DpqbUuyOyhA');

    export default {
        data () {
            return {
                center: {
                    lat: this.init.center.lat,
                    lng: this.init.center.lng
                },
                initCenter: this.init.center,
                reportedCenter: {},
                zoom: this.init.zoom,
                mapTypeId: this.init.mapTypeId,
                options: this.init.options,
                boundsChangedYet: false
            }
        },
        props: {
            init: {
                required: true,
                type: Object
            }
        },
        methods: {
            idle() {
                if(!this.boundsChangedYet){
                    // We have to write bounds manually to a variable the first time because bounds_changed hasn't
                    // been fired yet. (Idle also gets called on map object init.)
                    // What we want is to move map center a bit to the right because of sidebar overlay.
                    this.updateBounds(this.$refs['vgm-map'].$mapObject.getBounds());
                    this.center = this.getApparentCenterOf(this.center);
                    this.boundsChangedYet = true;
                }else{
                    // When bounds/zoom change (which is also when map gets loaded the first time), we fetch
                    // initiatives list.
                    this.$store.dispatch('ajaxCallInitiatives');
                    this.$store.dispatch('ajaxCallMarkers');
                }
            },
            updateBounds (bounds){
                this.$store.dispatch('updateBounds', bounds)
            },
            getApparentCenterOf(position) {
                let sidebarLngWidth = InitiativeMapService.sidebarWidthDeg(this.mapBounds);
                return {
                    lat: position.lat,
                    lng: position.lng - sidebarLngWidth / 2
                }
            },
            clickMarker(marker) {
                // You can center the marker like this:
//                this.center = this.getApparentCenterOf(marker.position);
                this.$store.dispatch('clickMarker', marker);
            },
            closeInfoWindow() {
                this.$store.dispatch('clear');
            }
            /**
             * tu naredi se spremljanje search criteria; takoj ko kriteriji izlocijo fokusirano iniciativo jo odfokusiraj
             */
        },
        computed: {
            ...mapGetters({
                markers: 'markers',
                initiatives: 'initiatives',
                focusedMarkers: 'focusedMarkers',
                mapBounds: 'bounds'
            })
        },
        components: {
            'vgm-map': VueGoogleMap.Map,
            'vgm-marker' : VueGoogleMap.Marker,
            'vgm-info-window': VueGoogleMap.InfoWindow,
            'sidebar' : Sidebar
        }
    }
</script>

<style lang="sass" rel="stylesheet/scss">
    @import "../../../sass/_variables.scss";

    .page-full {
        width: 100%;
        height: calc(100vh - 45px);
        display: table;
        margin-top: $navbar-height;
    }

    .modal, .modal-backdrop {
        position: absolute !important;
    }

    .gm-style-iw {
        top: 1px !important;
        left: 1px !important;
        background-color: #fff;
        border-radius: 2px 2px 0 0;
    }

    /*.gm-style-iw .list-group {*/
        /*margin: 0;*/
    /*}*/
</style>