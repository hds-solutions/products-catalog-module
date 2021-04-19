@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('products-catalog::family.name.0') }}"
    placeholder="{{ __('products-catalog::family.name._') }}" />

<div class="form-row form-group d-flex">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::family.options.0')</label>
    <div class="col-9">
        <div class="row" data-multiple=".family-option-container" data-template="#new">
            @if (isset($resource))
            @foreach($resource->options as $selected)
                @include('products-catalog::families.option', compact('options', 'selected'))
            @endforeach
            @endif
            {{-- add empty for adding new options --}}
            @include('products-catalog::families.option', [
                'options'  => $options,
                'selected' => null,
            ])
        </div>
    </div>
</div>

<x-backend-form-number :resource="$resource ?? null"
    name="priority"
    label="{{ __('products-catalog::family.priority.0') }}"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::family.priority._') }}" />

<x-backend-form-controls
    submit="products-catalog::families.save"
    cancel="products-catalog::families.cancel" cancel-route="backend.families" />
