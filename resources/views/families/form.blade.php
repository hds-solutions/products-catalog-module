@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="products-catalog::family.name.0"
    placeholder="products-catalog::family.name._" />

<x-backend-form-multiple name="options"
    :values="$options"
    :selecteds="isset($resource) ? $resource->options : []"
    contents-view="products-catalog::families.form.option"

    label="products-catalog::product.options.0" />

<x-backend-form-number :resource="$resource ?? null" name="priority"
    label="products-catalog::family.priority.0"
    placeholder="products-catalog::family.priority.optional" />

<x-backend-form-controls
    submit="products-catalog::families.save"
    cancel="products-catalog::families.cancel" cancel-route="backend.families" />
