<template>
    <select multiple="multiple">
        <slot></slot>
    </select>
</template>

<style>

</style>

<script>
    export default{
        data() {
            return {

            }
        },
        props: ['value'],
        mounted() {
            var vm = this;
            $(this.$el)
                .val(this.value)
                // init select2
                .select2({ width: '100%' })
                // emit event on change.
                .on('change', function (e) {
                    vm.$emit('input', e.val)
                });
        },
        watch: {
            value: {
                handler: function(value) {
//                    alert('watcher select2');
                    // update value
                    $(this.$el).select2('val', value);
                },
                deep: true
            }
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy')
        }
    }
</script>
