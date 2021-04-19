@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('products-catalog::category.name.0') }}"
    placeholder="{{ __('products-catalog::category.name._') }}" />

<x-backend-form-number :resource="$resource ?? null"
    name="priority"
    label="{{ __('products-catalog::category.priority.0') }}"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::category.priority._') }}" />

<x-backend-form-controls
    submit="products-catalog::categories.save"
    cancel="products-catalog::categories.cancel" cancel-route="backend.categories" />
