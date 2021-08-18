@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="products-catalog::option.name.0"
    placeholder="products-catalog::option.name._" />

<x-backend-form-text :resource="$resource ?? null" name="label"
    label="products-catalog::option.label.0"
    placeholder="products-catalog::option.label.optional" />

<x-backend-form-select :resource="$resource ?? null" name="value_type" required
    :values="Option::VALUE_TYPES" default="text"

    label="products-catalog::option.value_type.0"
    placeholder="products-catalog::option.value_type._"
    {{-- helper="products-catalog::option.value_type.?" --}} />

<x-backend-form-boolean :resource="$resource ?? null"
    name="show"
    label="products-catalog::option.show.0"
    placeholder="products-catalog::option.show._" />

<div data-only="value_type={{ Option::VALUE_TYPE_Choice }}|{{ Option::VALUE_TYPE_Color }}" class="mb-3">
    <x-backend-form-multiple name="values" :extra="isset($resource) ? [ $resource ] : []"
        :values="[]" :selecteds="isset($resource) ? $resource->values : []"
        contents-view="products-catalog::options.form.option_value"

        label="products-catalog::product.values.0" />
</div>

<x-backend-form-controls
    submit="products-catalog::options.save"
    cancel="products-catalog::options.cancel" cancel-route="backend.options" />
