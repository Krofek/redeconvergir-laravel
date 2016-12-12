<!-- select2 multiple -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{{ $field['label'] }}</label>
    <select
            name="{{ $field['name'] }}[]"
            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2'])
            multiple>

        @if (isset($field['model']))
            @php
                /**
                    PHP v blade fajlu :(
                */
                if(isset($field['other_id'])){
                    $connected_entity_entries = $field['model']::whereNotIn('id', [$field['other_id']])->get();
                    if(isset($field['value']) && !$field['value']->where('id', $field['other_id'])->isEmpty()){
                        $field['value_other'] = $field['value']->where('id', $field['other_id'])->first()->pivot->{$field['pivot_column']};
                    }
                }else{
                    $connected_entity_entries = $field['model']::all();
                }
            @endphp
            @foreach ($connected_entity_entries as $connected_entity_entry)
                <option value="{{ $connected_entity_entry->getKey() }}"
                        @if ( (isset($field['value']) && in_array($connected_entity_entry->getKey(), $field['value']->pluck($connected_entity_entry->getKeyName(), $connected_entity_entry->getKeyName())->toArray())) || ( old( $field["name"] ) && in_array($connected_entity_entry->getKey(), old( $field["name"])) ) )
                        selected
                        @endif
                >{{ $connected_entity_entry->{$field['attribute']} }}</option>
            @endforeach
        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label_other'] !!}</label>
    <input
            type="text"
            placeholder="{{ isset($field['placeholder_other']) ? $field['placeholder_other'] : '' }}"
            name="{{ $field['name_other'] }}"
            value="{{ old($field['name_other']) ? old($field['name_other']) : (isset($field['value_other']) ? $field['value_other'] : (isset($field['default_other']) ? $field['default_other'] : '' )) }}"
            @include('crud::inc.field_attributes')
    >

    {{-- HINT --}}
    @if (isset($field['hint_other']))
        <p class="help-block">{!! $field['hint_other'] !!}</p>
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
            // trigger select2 for each untriggered select2_multiple box
            $('.select2').each(function (i, obj) {
                if (!$(obj).data("select2"))
                {
                    $(obj).select2();
                }
            });
        });
    </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}