<template>
    <form>
        <div class="input-group">
            <input
                    type="text"
                    v-model="query"
                    class="form-control shaded"
                    :placeholder="$t('initiative.map.sidebar.search.placeholder')"
                    @keyup="search"
            >
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit">
                    {{ $t('initiative.map.sidebar.search.action') }}
                </button>
            </div>
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
                400
            ),
//            _.debounce(
//                () => {
//                    var vm = this;
//                    console.log(vm.query);
//                    if (vm.searchQuery != vm.query) {
//                        vm.updateSearchQuery(vm.query);
//                        vm.$store.dispatch('ajaxCallInitiatives');
//                    }
//                },
//                400
//            ),
            ...mapMutations({
                updateSearchQuery: 'update_search_query'
            })
        },
        computed: {
            ...mapGetters(['searchQuery'])
        }
    }
</script>

<style lang="sass" rel="stylesheet/scss" scoped>
    form{
        margin-bottom: 5px;
    }
</style>