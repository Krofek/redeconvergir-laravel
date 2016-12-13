<template>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 sidebar-wrapper">
            <input type="text" :placeholder="$t('initiative.map.sidebar.search.placeholder')" class="form-control shaded">
            <div class="sidebar shaded">
                <div class="list-group">
                    <slot></slot>
                </div>
            </div>
        </div>
</template>

<script type="text/babel">
    import InitiativeItem from './initiative-item.vue'

    export default {
        data() {
            return {
            }
        },
        components: {
        }
    }
</script>

<!--suppress CssUnknownTarget -->
<style scoped lang="sass" rel="stylesheet/scss">

    .sidebar-wrapper{
        position: absolute;
        z-index: 2;
        margin: 60px 0 0;
    }
    .sidebar{
        height: calc(100vh - 119px); /* 60px margintop, 39px input height, 5px input margin bottom, 15px margin bottom == 119px */
        background: #fff;
        padding: 10px;
    }
    .shaded{
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.10);
    }
    input.form-control{
        margin-bottom: 5px;
    }
</style>