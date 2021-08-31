@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="products-catalog::type.name.0"
    placeholder="products-catalog::type.name._" />

<x-backend-form-boolean :resource="$resource ?? null" name="is_sold"
    label="products-catalog::type.is_sold.0"
    placeholder="products-catalog::type.is_sold._" />

<x-backend-form-boolean :resource="$resource ?? null" name="has_stock"
    label="products-catalog::type.has_stock.0"
    placeholder="products-catalog::type.has_stock._" />

<x-backend-form-multiple name="options"
    :values="$options"
    :selecteds="isset($resource) ? $resource->options : []"
    contents-view="products-catalog::types.form.option"

    label="products-catalog::type.options.0" />

<x-backend-form-controls
    submit="products-catalog::types.save"
    cancel="products-catalog::types.cancel" cancel-route="backend.types" />
