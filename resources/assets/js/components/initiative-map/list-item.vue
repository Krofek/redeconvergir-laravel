<!--suppress CssUnknownTarget -->
<template>
    <a href="#" class="list-group-item" :class="{disabled: !initiative.within_bounds, active: isActive}" @click="clickInitiative(initiative)">
        <div class="list-group-item-left">
            <img :src="initiative.logo_url" :alt="initiative.name" class="list-group-item-image img-thumbnail">
        </div>
        <div class="list-group-item-right">
            <h4 class="list-group-item-heading">{{ initiative.name }}</h4>
            <div class="list-group-item-tags-wrapper">
                <ul class="list-group-item-tags">
                    <li v-for="c in initiative.categories">{{ c.name }}</li>
                </ul>
            </div>
            <p class="list-group-item-text">{{ initiative.short_description }}</p>
        </div>
    </a>
</template>

<script type="text/babel">
    import {mapGetters} from 'vuex'

    export default{
        props: {
            initiative: {
                required: true,
                type: Object
            },
            isTop: {
                type: Boolean,
                default: false
            }
        },
        data(){
            return {
                id: {
                    type: Number
                }
            }
        },
        methods: {
            clickInitiative(initiative) {
                this.$store.dispatch('clickInitiative', initiative);
                return false;
            }
        },
        computed: {
            isActive() {
                return this.isTop || (this.initiative.id in this.focusedInitiatives)
            },
            ...mapGetters(['focusedInitiatives'])
        }
    }
</script>

<style lang="sass" rel="stylesheet/scss">
    @import "resources/assets/sass/variables";
    @import "resources/assets/sass/mixins";

    .list-group-item{
        overflow: hidden;
        &-left{
             padding: 0;
             width: 100px;
             height: 100px;
             float: left;
         }
        &-right{
             padding: 0 0 0 10px;
             float: left;
             width: calc(100% - 110px);
         }

        &-tags{
             overflow: hidden;
             padding-left: 0;
             margin: 10px 0 3px 0 ;

            li{
                font-size: 11px;
                float: left;
                display: inline-block;
                background: #dddddd;
                padding: 1px 6px;
                margin-right: 4px;
                margin-bottom: 3px;
            }
            &-wrapper{
            }
        }

        &-image{
            width: 100px;
            height: 100px;
        }
    }
</style>
