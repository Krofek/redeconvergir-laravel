<template>
        <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 sidebar-wrapper">
            <search @toggleFilters="toggleFilters"></search>
            <div class="sidebar shaded">
                <filters v-show="filtersExpanded"></filters>
                <div class="initiative-items-wrapper" :class="{ shortened: filtersExpanded }">
                    <initiative-items ref="items"></initiative-items>
                </div>
            </div>
        </div>
</template>

<script type="text/babel">
    import InitiativeItems from './list-items'
    import Search from './search'
    import Filters from './filters'

    export default {
        data() {
            return {
                filtersExpanded: false
            }
        },
        methods: {
            toggleFilters() {
                this.filtersExpanded = !this.filtersExpanded
            }
        },
        components: {
            'initiative-items': InitiativeItems,
            'search': Search,
            'filters': Filters
        }
    }
</script>

<style lang="sass" rel="stylesheet/scss">
    @import "../../../sass/variables";

    .sidebar-wrapper{
        position: absolute;
        z-index: 2;
        margin: 15px 0 0;
        opacity: 0.93;
    }
    /*.sidebar-wrapper:hover{*/
        /*opacity: 1;*/
    /*}*/
    .sidebar{
        height: calc(100vh - 119px); /* 60px margintop, 39px input height, 5px input margin bottom, 15px margin bottom == 119px */
        background: #fff;
    }
    .shaded{
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.10);
    }
    .initiative-items-wrapper{
        overflow-y: scroll;
        height: 100%;

        &.shortened{
            height: calc(100% - #{$filter-height});
        }
    }

</style>