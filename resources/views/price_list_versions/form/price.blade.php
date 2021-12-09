<div class="col-1 d-flex justify-content-center">
    <div class="position-relative d-flex align-items-center h-75px">
        <img src="" class="img-fluid mh-75px" id="line_preview">
    </div>
</div>

<div class="col-9 col-xl-10 d-flex align-items-center">
    <div class="form-row flex-fill">

        <div class="col-8 d-flex align-items-center mb-1">
            <x-form-foreign name="prices[product_id][]" :required="$selected !== null"
                :values="$products" data-live-search="true"
                default="{{ $old['product_id'] ?? $selected?->product_id }}"

                {{-- show="code name" title="code" --}}
                append="url:images.0.url??backend-module/assets/images/default.jpg"
                data-preview="#line_preview" data-preview-init="false"
                data-preview-url-prepend="{{ asset('') }}"

                foreign="products" foreign-add-label="products-catalog::products.add"

                label="products-catalog::price_list_version.prices.product_id.0"
                placeholder="products-catalog::price_list_version.prices.product_id._"
                {{-- helper="products-catalog::price_list_version.prices.product_id.?" --}} />
        </div>

        <div class="col-4 d-flex align-items-center mb-1">
            <x-form-foreign name="prices[variant_id][]" {{-- :required="$selected !== null" --}}
                :values="$products->pluck('variants')->flatten()" data-live-search="true"
                default="{{ $old['variant_id'] ?? $selected?->variant_id }}"

                filtered-by='[name="prices[product_id][]"]' filtered-using="product"
                data-filtered-init="false"

                show="sku" {{-- title="code" --}}
                {{-- append="url:images.0.url??backend-module/assets/images/default.jpg" --}}
                {{-- data-preview="#line_preview" data-preview-init="false" --}}
                {{-- data-preview-url-prepend="{{ asset('') }}" --}}

                foreign="variants" foreign-add-label="products-catalog::variants.add"

                {{-- label="products-catalog::price_list_version.prices.variant_id.0" --}}
                placeholder="products-catalog::price_list_version.prices.variant_id._"
                {{-- helper="products-catalog::price_list_version.prices.variant_id.?" --}} />
        </div>

        <div class="col-12 d-flex align-items-center">
            <div class="form-row flex-fill">

                <div class="col-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">@lang('products-catalog::price_list_version.prices.list.0')</label>
                        </div>

                        <x-form-input type="number" name="prices[list][]" min="0" {{-- :required="$selected !== null" --}}
                            value="{{ $old['list'] ?? $selected?->list ?? null }}"
                            data-currency-by="[name='price_list_id']" data-keep-id="true" thousand
                            class="text-right"
                            placeholder="products-catalog::price_list_version.prices.list.0" />
                    </div>
                </div>

                <div class="col-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">@lang('products-catalog::price_list_version.prices.price.0')</label>
                        </div>

                        <x-form-input type="number" name="prices[price][]" min="0" :required="$selected !== null"
                            value="{{ $old['price'] ?? $selected?->price ?? null }}"
                            data-currency-by="[name='price_list_id']" data-keep-id="true" thousand
                            class="text-right"
                            placeholder="products-catalog::price_list_version.prices.price.0" />
                    </div>
                </div>

                <div class="col-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">@lang('products-catalog::price_list_version.prices.limit.0')</label>
                        </div>

                        <x-form-input type="number" name="prices[limit][]" min="0" {{-- :required="$selected !== null" --}}
                            value="{{ $old['limit'] ?? $selected?->limit ?? null }}"
                            data-currency-by="[name='price_list_id']" data-keep-id="true" thousand
                            class="text-right"
                            placeholder="products-catalog::price_list_version.prices.limit.0" />
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<div class="col-2 col-xl-1 d-flex justify-content-end align-items-center">
    <button type="button" class="btn btn-danger"
        data-action="delete"
        @if ($selected !== null)
        data-confirm="Eliminar Linea?"
        data-text="Esta seguro de eliminar el precio del producto {{ $selected->product->name }}?"
        data-accept="Si, eliminar"
        @endif>X</button>
</div>

