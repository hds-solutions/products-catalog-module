@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('products-catalog::option.name.0') }}"
    placeholder="{{ __('products-catalog::option.name._') }}" />

<x-backend-form-text :resource="$resource ?? null" name="label"
    label="{{ __('products-catalog::option.label.0') }}"
    placeholder="{{ __('products-catalog::option.label._') }}" />

<x-backend-form-select :resource="$resource ?? null" name="value_type" required
    :values="\HDSSolutions\Laravel\Models\Option::VALUE_TYPES"
    default="text"
    label="{{ __('products-catalog::option.value_type.0') }}"
    placeholder="{{ __('products-catalog::option.value_type._') }}"
    {{-- helper="{{ __('products-catalog::option.value_type.?') }}" --}} />

<x-backend-form-boolean :resource="$resource ?? null"
    name="show"
    label="{{ __('products-catalog::option.show.0') }}"
    placeholder="{{ __('products-catalog::option.show._') }}" />

<div class="form-row form-group d-flex">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::option.values.0')</label>
    <div class="col-9">
        <div class="row" data-multiple=".option-value-container" data-template="#new">
            @if (isset($resource))
            @foreach($resource->values as $value)
                @include('products-catalog::options.option_value', compact('value'))
            @endforeach
            @endif
            {{-- add empty for adding new options --}}
            @include('products-catalog::options.option_value', [ 'value' => null ])
        </div>
    </div>
</div>

<x-backend-form-controls
    submit="products-catalog::options.save"
    cancel="products-catalog::options.cancel" cancel-route="backend.options" />
