<template>
    <!-- Modal -->
    <div id="filters-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ $t('initiative.map.sidebar.filters_modal.title') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group form-group-categories">
                        <label class="col-lg-3">Dovoljene kategorije</label>
                        <div class="col-lg-9">
                            <select2 :options="options" v-model="selected">
                                <option disabled value="0">Select one</option>
                            </select2>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import Select2 from '../partials/select2';

    export default{
        data(){
            return {
                selected: null,
                options: [
                    { id: 1, text: 'Hello' },
                    { id: 2, text: 'World' }
                ]
            }
        },
        components: {
            'select2': Select2
        }
    }
</script>

<style lang="sass" rel="stylesheet/scss">
    button {
        outline: none;
    }
    .modal-content{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }

    .form-group-categories select{
        min-width: 100%;
    }

</style>