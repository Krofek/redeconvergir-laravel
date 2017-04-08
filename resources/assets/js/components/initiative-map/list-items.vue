<template>
    <div class="list-group">
        <initiative-item v-for="i in topInitiatives" :isTop="true" :initiative="i" :id="i.id"></initiative-item>
        <initiative-item v-for="i in notTopInitiatives" :initiative="i" :id="i.id"></initiative-item>
        <div class="noResultsWrapper" v-show="noResults">
            <span class="noResults">
                {{ $t('initiative.map.sidebar.list.no_results') }}
            </span>
            <br>
            <a href="#" @click.prevent="clearCriteria">
                {{ $t('initiative.map.sidebar.filters.clear') }}
            </a>
        </div>
    </div>
</template>

<script type="text/babel">
    /**
     * Functionality of having top and non-top initiatives is kept scripted because it may be needed in future,
     * for example for having only initiatives that are within bounds in "top", and others in non-top.
     *
     * But this functionality is currently not used.
     */
    import InitiativeItem from './list-item'
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {}
        },
        components: {
            'initiative-item': InitiativeItem
        },
        methods: {
            clearCriteria() {
                this.$store.dispatch('clearCriteria');
                this.$store.dispatch('ajaxCallInitiatives');
                this.$store.dispatch('ajaxCallMarkers');
            }
        },
        computed: {
            notTopInitiatives() {
                return _.filter(this.initiatives, (i) => {
                    return !(i.id in this.topInitiatives);
                });
            },
            noResults() {
                return (this.notTopInitiatives.length == 0)
            },
            ...mapGetters(['initiatives', 'topInitiatives'])
        }
    }
</script>

<style lang="sass" rel="stylesheet/scss">
    @import "../../../sass/variables";

    .list-group {
        margin: 10px;
    }

    .noResultsWrapper {
        text-align: center;
    }

    .noResults {
        font-size: $font-size-large;
        text-align: center;
        color: $gray-dark;
        display: inline-block;
        padding: 3px 8px;
        background: $gray-lighter;
        border-radius: 3px;
    }

    .noResultsWrapper a {
        display: inline-block;
        margin-top: 5px;
    }

</style>