@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required

    label="products-catalog::price_list.name.0"
    placeholder="products-catalog::price_list.name._" />

<x-backend-form-text :resource="$resource ?? null" name="description"

    label="products-catalog::price_list.description.0"
    placeholder="products-catalog::price_list.description.optional" />

<x-backend-form-foreign :resource="$resource ?? null" name="currency_id" required
    foreign="currencies" :values="backend()->currencies()" foreign-add-label="cash::currencies.add"
    default="{{ backend()->currency()?->id }}"

    label="products-catalog::price_list.currency_id.0"
    placeholder="products-catalog::price_list.currency_id._"
    {{-- helper="products-catalog::price_list.currency_id.?" --}} />

<x-backend-form-boolean :resource="$resource ?? null" name="is_purchase"

    label="products-catalog::price_list.is_purchase.0"
    placeholder="products-catalog::price_list.is_purchase._"
    {{-- helper="products-catalog::price_list.is_purchase.?" --}} />

<x-backend-form-boolean :resource="$resource ?? null" name="is_default"

    label="products-catalog::price_list.is_default.0"
    placeholder="products-catalog::price_list.is_default._"
    {{-- helper="products-catalog::price_list.is_default.?" --}} />

<x-backend-form-controls
    submit="products-catalog::price_lists.save"
    cancel="products-catalog::price_lists.cancel" cancel-route="backend.price_lists" />
