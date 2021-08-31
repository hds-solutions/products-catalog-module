@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="products-catalog::line.name.0"
    placeholder="products-catalog::line.name._" />

<x-backend-form-multiple name="options"
    :values="$options"
    :selecteds="isset($resource) ? $resource->options : []"
    contents-view="products-catalog::lines.form.option"

    label="products-catalog::line.options.0" />

<x-backend-form-number :resource="$resource ?? null" name="priority"
    label="products-catalog::line.priority.0"
    placeholder="products-catalog::line.priority.optional" />

<x-backend-form-controls
    submit="products-catalog::lines.save"
    cancel="products-catalog::lines.cancel" cancel-route="backend.lines" />
