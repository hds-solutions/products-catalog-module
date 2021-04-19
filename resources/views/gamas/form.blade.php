@include('backend::components.errors')

<x-backend-form-foreign :resource="$resource ?? null" name="line_id" required
    foreign="lines" :values="$lines" foreign-add-label="{{ __('products-catalog::lines.add') }}"

    label="{{ __('products-catalog::gama.line_id.0') }}"
    placeholder="{{ __('products-catalog::gama.line_id._') }}"
    {{-- helper="{{ __('products-catalog::gama.line_id.?') }}" --}} />

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('products-catalog::gama.name.0') }}"
    placeholder="{{ __('products-catalog::gama.name._') }}" />

<x-backend-form-controls
    submit="products-catalog::gamas.save"
    cancel="products-catalog::gamas.cancel" cancel-route="backend.gamas" />
