<div class="col-2">

    <x-form-foreign name="prices[currency_id][]" id="f{{ $id = Str::random(16) }}"
        :values="$currencies"
        default="{{ $old['currency_id'] ?? $selected?->id }}"

        show="code name" title="code"
        append="decimals"

        {{-- foreign="currencies" foreign-add-label="products-catalog::currencies.add" --}}

        label="products-catalog::variant.prices.currency_id.0"
        placeholder="products-catalog::variant.prices.currency_id._"
        {{-- helper="products-catalog::variant.prices.currency_id.?" --}} />
</div>

<div class="col-10 d-flex">
    <x-form-amount name="prices[cost][]" :required="isset($selected)"
        min="0" step="{{ 1 / pow(10, $selected->decimals ?? 0) }}"
        :data-currency-by="isset($selected) ? '#f'.$id : '[name=\'prices[currency_id][]\']'"
        {{-- value="{{ $old['cost'] ?? (isset($selected) ? number($selected->pivot->cost, $selected->pivot->currency->decimals) : null) ?? null }}" --}}
        value="{{ $old['cost'] ?? (isset($selected) ? $selected->pivot->cost : null) ?? null }}"

        placeholder="products-catalog::variant.prices.cost._"
        class="text-right" />

    <x-form-amount name="prices[price][]" :required="isset($selected)"
        min="0" step="{{ 1 / pow(10, $selected->decimals ?? 0) }}"
        :data-currency-by="isset($selected) ? '#f'.$id : '[name=\'prices[currency_id][]\']'"
        {{-- value="{{ $old['price'] ?? (isset($selected) ? number($selected->pivot->price, $selected->pivot->currency->decimals) : null) ?? null }}" --}}
        value="{{ $old['price'] ?? (isset($selected) ? $selected->pivot->price : null) ?? null }}"

        placeholder="products-catalog::variant.prices.price._"
        class="ml-2 text-right" />

    <x-form-amount name="prices[limit][]" :required="isset($selected)"
        min="0" step="{{ 1 / pow(10, $selected->decimals ?? 0) }}"
        :data-currency-by="isset($selected) ? '#f'.$id : '[name=\'prices[currency_id][]\']'"
        {{-- value="{{ $old['limit'] ?? (isset($selected) ? number($selected->pivot->limit, $selected->pivot->currency->decimals) : null) ?? null }}" --}}
        value="{{ $old['limit'] ?? (isset($selected) ? $selected->pivot->limit : null) ?? null }}"

        placeholder="products-catalog::variant.prices.limit._"
        class="ml-2 text-right" />

    <button type="button" class="btn btn-danger ml-2"
        data-action="delete"
        @if ($selected !== null)
        data-confirm="Eliminar @lang('Price')?"
        data-text="Esta seguro de eliminar la @lang('Price') {{ $selected->name }}?"
        data-accept="Si, eliminar"
        @endif>X</button>
</div>
