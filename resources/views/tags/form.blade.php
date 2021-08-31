@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="products-catalog::tag.name.0"
    placeholder="products-catalog::tag.name._" />

<x-backend-form-controls
    submit="products-catalog::tags.save"
    cancel="products-catalog::tags.cancel" cancel-route="backend.tags" />
