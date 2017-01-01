<template>
    <div class="list-group">
        <initiative-item v-for="i in topInitiatives" :isTop="true" :initiative="i" :id="i.id"></initiative-item>
        <initiative-item v-for="i in notTopInitiatives" :initiative="i" :id="i.id"></initiative-item>
    </div>
</template>

<script type="text/babel">
    import InitiativeItem from './list-item'
    import { mapGetters } from 'vuex'

    export default {
        data() {
            return {}
        },
        components: {
            'initiative-item': InitiativeItem,
        },
        computed: {
            notTopInitiatives() {
                return _.filter(this.initiatives, (i) => {
                    return !(i.id in this.topInitiatives);
                });
            },
            ...mapGetters(['initiatives', 'topInitiatives'])
        }
    }
</script>

<style lang="sass" rel="stylesheet/scss">

</style>