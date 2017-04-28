<template>
    <div class="filters-wrapper">
        <div class="well bs-component">
            <form>
                <fieldset>
                    <legend>
                        <h4>{{ $t('initiative.map.sidebar.filters.title') }}</h4>
                    </legend>
                    <div class='col-lg-6'>
                        <div class="form-group">
                            <label class="control-label">{{ $t('initiative.map.sidebar.filters.choose_categories') }}:</label>
                            <div>
                                <select2 :value="selected.categories" @input="categoriesChanged($event)">
                                    <option v-for="c in data.categories" :value="c.id">{{ c.name }}</option>
                                </select2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="control-label">{{ $t('initiative.map.sidebar.filters.choose_audience') }}:</label>
                            <div>
                                <select2 :value="selected.audiences" @input="audiencesChanged($event)">
                                    <option v-for="a in data.audiences" :value="a.id">{{ a.name }}</option>
                                </select2>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</template>

<script type="text/babel">
    import Select2 from '../partials/select2';
    import {mapGetters, mapMutations} from 'vuex';

    export default{
        data(){
            return {
                selectedAudiences: []
            }
        },
        methods: {
            categoriesChanged(categories) {
                this.$store.dispatch('updateCategories', categories);
                this.$store.dispatch('ajaxCallInitiatives');
                this.$store.dispatch('ajaxCallMarkers');
            },
            audiencesChanged(audiences) {
                this.$store.dispatch('updateAudiences', audiences);
                this.$store.dispatch('ajaxCallInitiatives');
                this.$store.dispatch('ajaxCallMarkers');
            }
        },
        watch: {
            initiatives() {
                let filteredFocusedInitiatives = _.pick(this.initiatives, Object.keys(this.focusedInitiatives));
                if(!_.isEqual(Object.keys(filteredFocusedInitiatives), Object.keys(this.focusedInitiatives))){
                    this.$store.dispatch('filterFocusedInitiatives', filteredFocusedInitiatives);
                }
            }
        },
        computed: {
            ...mapGetters({
                data: 'filtersData',
                selected: 'filters',
                initiatives: 'initiatives',
                focusedInitiatives: 'focusedInitiatives',
                focusedMarkers: 'focusedMarkers'
            })
        },
        mounted() {
            this.$store.dispatch('ajaxInitFilters');
        },
        components: {
            'select2': Select2
        }
    }
</script>

<style lang="sass" rel="stylesheet/scss">
    @import "../../../sass/variables";

    .filters-wrapper {
        background: $brand-primary;
        height: $filter-height;
        width: 100%;
        padding: 10px;
        overflow: hidden;
        color: #fff;

        .page-header {
            margin-top: 0;

            h4 {
                margin-top: 10px;
                margin-bottom: 0;
            }
        }

        .well {
            padding: 10px 15px;
            margin: 0;
            background: none;
            border: 0;
            box-shadow: none;
        }

        legend {
            color: #fff;
        }

        fieldset > div {
            padding-left: 5px;
            padding-right: 5px;
        }
    }
</style>