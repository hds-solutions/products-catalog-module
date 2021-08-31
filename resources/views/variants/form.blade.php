@include('backend::components.errors')

<x-backend-form-foreign :resource="$resource ?? null" name="product_id" required
    :values="$products" request="product" :readonly="request()->has('product')"

    foreign="products" foreign-add-label="products-catalog::products.add"
    append="type:type_id,family:family_id,line:line_id"

    label="products-catalog::variant.product_id.0"
    placeholder="products-catalog::variant.product_id._"
    helper="products-catalog::variant.product_id.?" />

<x-backend-form-text :resource="$resource ?? null" name="sku" required
    label="products-catalog::variant.sku.0"
    placeholder="products-catalog::variant.sku._" />

<x-backend-form-multiple name="prices" values-as="currencies"
    :values="$currencies" :selecteds="isset($resource) ? $resource->prices : []"
    grouped old-filter-fields="currency_id,cost,price,limit"
    contents-view="products-catalog::variants.form.price" contents-size="lg"
    row-class="mb-0" container-class="mb-3"

    label="products-catalog::product.prices.0" />

{{-- <x-backend-form-amount :resource="$resource ?? null"
    name="price" field="priceRaw" prepend="{{ config('settings.currency-symbol', 'USD"
    label="products-catalog::variant.price.0') }} / {{ __('products-catalog::variant.price_reseller.0"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::variant.price._"
    helper="products-catalog::variant.price.?">

    <x-backend-form-amount :resource="$resource ?? null" secondary
        name="price_reseller" prepend="{{ config('settings.currency-symbol', 'USD"
        label="products-catalog::variant.price_reseller.0"
        placeholder="({{ __('optional') }}) {{ __('products-catalog::variant.price_reseller._"
        helper="products-catalog::variant.price_reseller.?">
    </x-backend-form-amount>

</x-backend-form-amount> --}}

<x-backend-form-image :resource="$resource ?? null" :images="$images"
    name="images" multiple
    filtered-by="[name=product_id]" filtered-using="product"

    label="products-catalog::variant.images.0"
    placeholder="products-catalog::variant.images.optional" />

{{-- available options --}}
@foreach ($options as $option)

<div class="form-row form-group align-items-center"
    data-types="{{ implode(',', $option->types?->pluck('id')->all() ?? [] ) }}"
    data-families="{{ implode(',', $option->families?->pluck('id')->all() ?? [] ) }}"
    data-lines="{{ implode(',', $option->lines?->pluck('id')->all() ?? [] ) }}"
    data-linked-with="[name=product_id]" data-linked-using="type:types|family:families|line:lines">

    <label class="col-12 col-md-3 col-lg-2 control-label m-0">{{ $option->label ?? $option->name }}</label>

    <div class="col-12 col-md-9 col-xl-4">
        {{-- get selected value on variant, if exists --}}
        <?php $key = isset($resource) ? $resource->values->pluck('option_id')->search($option->id) : null; ?>

        @switch ($option->value_type)
            @case ('text')
                <x-form-input type="text" name="option_value_id[{{ $option->id }}]"
                    :value="isset($resource) && $resource->values->count() && $resource->values->pluck('option_id')[$key] == $option->id ? $resource->values->pluck('value')[$key] : null"
                    placeholder="{{ $option->name }}" />
                @break

            @case ('boolean')
                TODO: boolean
                @break

            @case ('color')
            @case ('choice')
                {{-- option available values --}}
                <select name="option_value_id[{{ $option->id }}]"
                    class="form-control selectpicker"
                    placeholder="{{ $option->name }}">

                    <option value="" selected disabled hidden>-- {{ $option->name }} --</option>
                    @foreach ($option->values as $value)
                    <option value="{{ $value->id }}"
                        @if (isset($resource) && $resource->values->count() && (
                            $resource->values->pluck('option_id')[$key] == $option->id &&
                            $resource->values->pluck('option_value_id')[$key] == $value->id
                        )) selected @endif>{{ $value->value }}</option>
                    @endforeach

                </select>
                @break

            @case ('image')
                TODO: image
                @break

            @default
                <h4 class="text-danger">Invalid option value type</h4>
        @endswitch
    </div>

    @if ($option->label !== null)
    <i class="fas fa-info-circle ml-2 cursor-help d-none d-lg-inline-block" data-toggle="tooltip" data-placement="right"
        title="{{ $option->name }}"></i>
    @endif
</div>

@endforeach

<x-backend-form-number :resource="$resource ?? null"
    name="priority"
    label="products-catalog::variant.priority.0"
    placeholder="products-catalog::variant.priority.optional" />

<x-backend-form-multiple name="locators" values-as="warehouses"
    :values="$warehouses" :selecteds="isset($resource) ? $resource->locators : []"
    grouped old-filter-fields="warehouse_id,locator_id"
    contents-view="products-catalog::variants.form.locator" contents-size="lg"
    row-class="mb-0" container-class="mb-3"

    label="products-catalog::variant.locators.0" />

<x-backend-form-controls
    submit="products-catalog::variants.save"
    cancel="products-catalog::variants.cancel" cancel-route="backend.variants" />
