@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('products-catalog::line.name.0') }}"
    placeholder="{{ __('products-catalog::line.name._') }}" />

<div class="form-row form-group d-flex">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::line.options.0')</label>
    <div class="col-9">
        <div class="row" data-multiple=".line-option-container" data-template="#new">
            @if (isset($resource))
            @foreach($resource->options as $selected)
                @include('products-catalog::lines.option', compact('options', 'selected'))
            @endforeach
            @endif
            {{-- add empty for adding new options --}}
            @include('products-catalog::lines.option', [
                'options'  => $options,
                'selected' => null,
            ])
        </div>
    </div>
</div>

<x-backend-form-number :resource="$resource ?? null"
    name="priority"
    label="{{ __('products-catalog::line.priority.0') }}"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::line.priority._') }}" />

<x-backend-form-controls
    submit="products-catalog::lines.save"
    cancel="products-catalog::lines.cancel" cancel-route="backend.lines" />
