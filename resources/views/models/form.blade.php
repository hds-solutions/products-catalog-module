@include('backend::components.errors')

<x-backend-form-foreign :resource="$resource ?? null" name="brand_id" required
    foreign="brands" :values="$brands" foreign-add-label="{{ __('products-catalog::brands.add') }}"

    label="{{ __('products-catalog::model.brand_id.0') }}"
    placeholder="{{ __('products-catalog::model.brand_id._') }}"
    {{-- helper="{{ __('products-catalog::model.brand_id.?') }}" --}} />

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('products-catalog::model.name.0') }}"
    placeholder="{{ __('products-catalog::model.name._') }}" />

<x-backend-form-controls
    submit="products-catalog::models.save"
    cancel="products-catalog::models.cancel" cancel-route="backend.models" />
