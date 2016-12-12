<!--suppress CssUnknownTarget -->
<template>
    <a href="#" class="list-group-item">
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
            <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit. Escuchere jebemti mater pojeban text. Escuchere jebemti mater pojeban text.</p>
        </div>
    </a>
</template>

<script>
    export default{
        props: {
            initiative: {
                required: true,
                type: Object
            }
        },
        data(){
            return{

            }
        }
    }
</script>

<style scoped lang="sass" rel="stylesheet/scss">
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
