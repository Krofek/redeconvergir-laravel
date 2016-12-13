<template>
    <div class="page-full">
        <sidebar>
            <initiative-item v-for="initiative in initiatives" :initiative="initiative"></initiative-item>
        </sidebar>
        <vgm-map
                :center="center"
                :zoom="zoom"
                :map-type-id="mapTypeId"
                :options="options"
                ref="vgm-map"
                @idle="fetchInitiatives"
        >
            <vgm-marker
                    v-for="m in markers"
                    :position.sync="m.position"
                    :clickable="true"
                    :draggable="true"
                    @g-click="center=m.position"
            ></vgm-marker>
        </vgm-map>
    </div>
</template>

<!--suppress JSUnresolvedVariable -->
<script type="text/babel">
    import * as VueGoogleMap from 'vue2-google-maps'
    import Sidebar from './sidebar.vue'
    import InitiativeItem from './initiative-item.vue'

    VueGoogleMap.load('AIzaSyAveqa-JPO_vdHeJFVp-FH8DpqbUuyOyhA');

    export default {
        data () {
            return {
                center: {
                    lat: this.init.center.lat,
                    lng: this.init.center.lng
                },
                zoom: this.init.zoom,
                mapTypeId: this.init.mapTypeId,
                options: this.init.options,
                markers: [{
                    position: {lat: 11.0, lng: 11.0}
                }],
            }
        },
        props: {
            init: {
                required: true,
                type: Object
            },
            initiatives: {
                required: true,
                type: Array // array of objects
            }
        },
        methods: {
            fetchInitiatives() {
                var bounds = this.mapObject.getBounds();
                var url = laroute.action('api::initiatives-list-items');

                this.$http.post(url, {boundaries: JSON.stringify(bounds)}).then((response) => {
                    console.log(response.body);
                    this.initiatives = response.body.initiatives;
                    this.markers = response.body.markers;
                }, (response) => {
                    console.log(response)
                })
            }
        },
        computed: {
            mapObject() {
                return this.$refs['vgm-map'].$mapObject;
            }
        },
        components: {
            'vgm-map': VueGoogleMap.Map,
            'vgm-marker' : VueGoogleMap.Marker,
            'sidebar' : Sidebar,
            'initiative-item' : InitiativeItem
        }
    }
</script>

<style>

</style>