@include('backend::components.errors')

<x-backend-form-foreign :resource="$resource ?? null" name="price_list_id" required
    foreign="price_lists" :values="$price_lists" foreign-add-label="products-catalog::price_lists.add"
    append="decimals:currency.decimals"

    label="products-catalog::price_list_version.price_list_id.0"
    placeholder="products-catalog::price_list_version.price_list_id._"
    {{-- helper="products-catalog::price_list_version.price_list_id.?" --}} />

<x-backend-form-text :resource="$resource ?? null" name="name" required

    label="products-catalog::price_list_version.name.0"
    placeholder="products-catalog::price_list_version.name._" />

<x-backend-form-text :resource="$resource ?? null" name="description"

    label="products-catalog::price_list_version.description.0"
    placeholder="products-catalog::price_list_version.description.optional" />

<x-backend-form-datetime :resource="$resource ?? null" name="valid_from" required
    default="{{ now() }}"

    label="products-catalog::price_list_version.valid_from.0"
    placeholder="products-catalog::price_list_version.valid_from._"
    helper="products-catalog::price_list_version.valid_from.?" />

<x-backend-form-datetime :resource="$resource ?? null" name="valid_until"

    label="products-catalog::price_list_version.valid_until.0"
    placeholder="products-catalog::price_list_version.valid_until.optional"
    helper="products-catalog::price_list_version.valid_until.?" />

<x-backend-form-multiple name="prices" contents-view="products-catalog::price_list_versions.form.price"
    data-type="price_list_version"

    :values="$products" values-as="products"
    :selecteds="isset($resource) ? $resource->prices : []" grouped old-filter-fields="product_id,price"

    contents-size="xxl"
    container-class="my-3"
    card="bg-light"

    label="products-catalog::price_list_version.prices.0" />

<x-backend-form-controls
    submit="products-catalog::price_list_versions.save"
    cancel="products-catalog::price_list_versions.cancel" cancel-route="backend.price_list_versions" />
