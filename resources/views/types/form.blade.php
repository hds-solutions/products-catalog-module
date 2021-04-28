@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('products-catalog::type.name.0') }}"
    placeholder="{{ __('products-catalog::type.name._') }}" />

<x-backend-form-boolean :resource="$resource ?? null"
    name="is_sold"
    label="{{ __('products-catalog::type.is_sold.0') }}"
    placeholder="{{ __('products-catalog::type.is_sold._') }}" />

<div class="form-row form-group d-flex">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::type.options.0')</label>
    <div class="col-9">
        <div class="row" data-multiple=".type-option-container" data-template="#new">
            @if (isset($resource))
            @foreach($resource->options as $selected)
                @include('products-catalog::types.option', compact('options', 'selected'))
            @endforeach
            @endif
            {{-- add empty for adding new options --}}
            @include('products-catalog::types.option', [
                'options'  => $options,
                'selected' => null,
            ])
        </div>
    </div>
</div>

<x-backend-form-controls
    submit="products-catalog::types.save"
    cancel="products-catalog::types.cancel" cancel-route="backend.types" />
