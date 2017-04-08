<template>
    <form @submit.prevent="search" class="shaded">
        <div class="input-group input-group-query">
            <input
                type="text"
                v-model="query"
                class="form-control"
                :placeholder="$t('initiative.map.sidebar.search.placeholder')"
                @keyup.esc="clearQuery"
            >
            <span id="clearQuery" class="glyphicon glyphicon-remove" v-show="query != ''" @click="clearQuery"></span>
            <div class="input-group-btn">
                <button class="btn btn-primary" type="submit">
                    {{ $t('initiative.map.sidebar.search.action') }}
                </button>
            </div>
        </div>
        <div class="input-group input-group-filter-button">
            <button class="btn btn-regular" type="button" @click.prevent="clickFiltersButton">
                <span class="glyphicon glyphicon-cog"></span>
            </button>
        </div>
    </form>
</template>

<script type="text/babel">
    import {mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        data(){
            return {
                query: ''
            }
        },
        methods: {
            search: _.debounce(
                function () {
                    // searchQuery is previous value, query is the new one
                    if (this.searchQuery != this.query) {
                        this.updateSearchQuery(this.query);
                        this.$store.dispatch('ajaxCallInitiatives');
                    }
                },
                0 // change this to e.g. 400 if you wish search query @keyup behaviour (and add to <input>)
            ),
            clearQuery() {
                this.query = '';
                this.search();
            },
            clickFiltersButton() {
                this.$emit('toggleFilters')
            },
            ...mapMutations({
                updateSearchQuery: 'update_search_query'
            })
        },
        computed: {
            ...mapGetters(['searchQuery'])
        },
        watch: {
            query() {
                if(this.query == ''){
                    this.search();
                }
            },
            searchQuery(value) {
                this.query = value
            }
        }
    }
</script>

<style lang="sass" rel="stylesheet/scss" scoped>
    @import "resources/assets/sass/variables";

    form{
        margin-bottom: 5px;
        overflow: hidden;
        clear: both;

        .input-group{

            &.input-group-query{
                width: calc(100% - 55px);
                float: left;

                input{
                    padding: 8px 27px 8px 12px;
                }

                .input-group-btn .btn{
                    width: 100px;
                    outline: none;
                }

                #clearQuery{
                    position: absolute;
                    right: 110px;
                    z-index: 3;
                    top: 0;
                    bottom: 0;
                    height: 14px;
                    margin: auto;
                    font-size: 14px;
                    cursor: pointer;
                    color: $brand-primary;
                }
            }

            &.input-group-filter-button{
                width: 50px;
                float: left;
                margin-left: 5px;

                button{
                    width: 100%;
                    background: #fff;
                    border: 1px solid #ccc;
                    color: #666;
                    outline: none;
                    padding: 9px 12px 7px 12px;
                }
            }
        }


    }
</style>