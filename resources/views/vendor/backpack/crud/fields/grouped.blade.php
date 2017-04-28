<!-- select2 -->
<div class="box-sector">
    <div class="box-sector-header">
        <h3>{{ $field['label'] }}</h3>
    </div>
    @php
    /**
        $label_existing = 'Existing';
        $label_new = 'New';
        <div class="grouped-box-radios">
            <div @include('crud::inc.field_wrapper_attributes') >
                <label for="new" class="radio-inline">
                    <input type="radio" id="new" name="grouped_radio" value="0" checked> {!! $label_new !!}
                </label>
                <label for="existing" class="radio-inline">
                    <input type="radio" id="existing" name="grouped_radio" value="1"> {!! $label_existing !!}
                </label>
            </div>
        </div>
        <div class="grouped-box-existing" style="display: none">
            <div @include('crud::inc.field_wrapper_attributes') >
                <?php $entity_model = $crud->model; ?>
                <select
                        name="{{ $field['name'] }}"
                        @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2'])
                >
                    <option value="">-</option>
                    @if (isset($field['model']))
                        @foreach ($field['model']::all() as $connected_entity_entry)
                            <option value="{{ $connected_entity_entry->getKey() }}"
                                    @if ( ( old($field['name']) && old($field['name']) == $connected_entity_entry->getKey() ) || (isset($field['value']) && $connected_entity_entry->getKey()==$field['value']))
                                    selected
                                    @endif
                            >{{ $connected_entity_entry->{$field['attribute']} }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    */
    @endphp
    <div class="grouped-box-new">
        @php
            $crud_controller = $field['crud_controller'];
            $group_fields = $crud_controller->crud->create_fields;
        @endphp
        @foreach ($group_fields as $group_field)
            @php
                if(isset($field['value'])){
                    $group_field['value'] = $field['value']->{$group_field['name']};
                }
                $group_field['name'] = $field['name'] . '[' . $group_field['name'] . ']';
            @endphp
            <!-- load the view from the application if it exists, otherwise load the one in the package -->
            @if(view()->exists('vendor.backpack.crud.fields.'.$group_field['type']))
                @include('vendor.backpack.crud.fields.'.$group_field['type'], array('field' => $group_field))
            @else
                @include('crud::fields.'.$group_field['type'], array('field' => $group_field))
            @endif
        @endforeach
    </div>
    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    <!-- include select2 css-->
    <link href="{{ asset('vendor/backpack/select2/select2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/backpack/select2/select2-bootstrap-dick.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <!-- include select2 js-->
    <script src="{{ asset('vendor/backpack/select2/select2.js') }}"></script>
    <script>
        jQuery(document).ready(function($) {
            // trigger select2 for each untriggered select2 box
            $('.select2').each(function (i, obj) {
                if (!$(obj).data("select2"))
                {
                    $(obj).select2();
                }
            });
//            $('.grouped-box-radios input[name=grouped_radio]').change(function () {
//                if($(this).val() == 1){
//                    $('.grouped-box-existing').show()
//                    $('.grouped-box-new').hide()
//                    $('.grouped-box-existing .select2').prop('disabled', false);
//                }else{
//                    $('.grouped-box-existing').hide()
//                    $('.grouped-box-new').show()
//                    $('.grouped-box-existing .select2').prop('disabled', true);
//                }
//            });
        });
    </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}