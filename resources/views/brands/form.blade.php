@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('products-catalog::brand.name.0') }}"
    placeholder="{{ __('products-catalog::brand.name._') }}"
    {{-- helper="{{ __('products-catalog::brand.name.?') }}" --}} />

<x-backend-form-image :resource="$resource ?? null" :images="$images"
    name="logo_id"
    label="{{ __('products-catalog::brand.logo_id.0') }}"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::brand.logo_id._') }}" />

{{-- <div class="form-row form-group">
    <label class="col-3 control-label">Mostrar en Home ?</label>
    <div class="col-3">
        <div class="form-check">
            <input name="show_home" type="checkbox" id="show_home"
                @if (isset($resource) && !old('show_home') ? $resource->show_home : old('show_home')) checked @endif
                class="form-check-input {{ $errors->has('show_home') ? 'is-danger' : '' }}" placeholder="Mostrar en Home ?">
            <label for="show_home" class="form-check-label">Si, mostrar esta Marca en la Home</label>
        </div>
    </div>
</div> --}}

<x-backend-form-number :resource="$resource ?? null"
    name="priority"
    label="{{ __('products-catalog::brand.priority.0') }}"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::brand.priority._') }}" />

<x-backend-form-controls
    submit="products-catalog::brands.save"
    cancel="products-catalog::brands.cancel" cancel-route="backend.brands" />
