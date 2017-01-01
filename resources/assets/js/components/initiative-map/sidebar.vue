<template>
        <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 sidebar-wrapper">
            <search-filters></search-filters>
            <div class="sidebar shaded">
                <initiative-items ref="items"></initiative-items>
            </div>
        </div>
</template>

<script type="text/babel">
    import InitiativeItems from './list-items'
    import SearchFilters from './search-filters'

    export default {
        data() {
            return {}
        },
        components: {
            'initiative-items': InitiativeItems,
            'search-filters': SearchFilters
        }
    }
</script>

<!--suppress CssUnknownTarget -->
<style lang="sass" rel="stylesheet/scss">

    .sidebar-wrapper{
        position: absolute;
        z-index: 2;
        margin: 15px 0 0;
        opacity: 0.9;
    }
    /*.sidebar-wrapper:hover{*/
        /*opacity: 1;*/
    /*}*/
    .sidebar{
        height: calc(100vh - 119px); /* 60px margintop, 39px input height, 5px input margin bottom, 15px margin bottom == 119px */
        background: #fff;
        padding: 10px;
        overflow-y: scroll;
    }
    .shaded{
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.10);
    }
</style>