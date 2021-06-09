{{-- <div class="form-row price-container mb-3" @if ($selected === null && $old === null) id="new" @else data-used="true" @endif> --}}
    <div class="col-2">
{{--
        <select name="prices[currency_id][]" @if (isset($selected)) id="f{{ $id = Str::random(16) }}" @endif
            value="{{ isset($selected) ? $selected->currency_id : '' }}"
            data-none-selected-text="@lang('products-catalog::variant.prices.currency_id._')"
            class="form-control selectpicker" placeholder="@lang('cash::currency.name._')">
            <option value="" selected disabled hidden>@lang('cash::currency.name.0')</option>
            @foreach($currencies as $currency)
            <option value="{{ $currency->id }}" title="{{ $currency->code }}"
                data-decimals="{{ $currency->decimals }}"
                @if (isset($selected) && $selected->id == $currency->id) selected @endif>{{ $currency->code }} {{ $currency->name }}</option>
            @endforeach
        </select>
 --}}
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
{{--
        <input name="prices[cost][]" type="number" thousand @if (isset($selected)) required @endif
            min="0" step="{{ 1 / pow(10, $selected->decimals ?? 0) }}"
            data-currency-by="{{ isset($selected) ? "#f$id" : '[name="prices[currency_id][]"]' }}"
            value="{{ isset($selected) ? number($selected->pivot->cost, $selected->pivot->currency->decimals) : '' }}"
            class="form-control" placeholder="@lang('products-catalog::variant.prices.cost._')">
 --}}
        <x-form-amount name="prices[cost][]"
            :required="isset($selected)"
            min="0" step="{{ 1 / pow(10, $selected->decimals ?? 0) }}"
            :data-currency-by="isset($selected) ? '#f'.$id : '[name=\'prices[currency_id][]\']'"
            value="{{ $old['cost'] ?? (isset($selected) ? number($selected->pivot->cost, $selected->pivot->currency->decimals) : null) ?? null }}"
            placeholder="products-catalog::variant.prices.cost._" />
{{--
        <input name="prices[price][]" type="number" thousand @if (isset($selected)) required @endif
            min="0" step="{{ 1 / pow(10, $selected->decimals ?? 0) }}"
            data-currency-by="{{ isset($selected) ? "#f$id" : '[name="prices[currency_id][]"]' }}"
            value="{{ isset($selected) ? number($selected->pivot->price, $selected->pivot->currency->decimals) : '' }}"
            class="form-control ml-2" placeholder="@lang('products-catalog::variant.prices.price._')">
 --}}
        <x-form-amount name="prices[price][]"
            :required="isset($selected)"
            min="0" step="{{ 1 / pow(10, $selected->decimals ?? 0) }}"
            :data-currency-by="isset($selected) ? '#f'.$id : '[name=\'prices[currency_id][]\']'"
            value="{{ $old['price'] ?? (isset($selected) ? number($selected->pivot->price, $selected->pivot->currency->decimals) : null) ?? null }}"
            placeholder="products-catalog::variant.prices.price._"
            class="ml-2" />
{{--
        <input name="prices[limit][]" type="number" thousand
            min="0" step="{{ 1 / pow(10, $selected->decimals ?? 0) }}"
            data-currency-by="{{ isset($selected) ? "#f$id" : '[name="prices[currency_id][]"]' }}"
            value="{{ isset($selected) ? number($selected->pivot->limit, $selected->pivot->currency->decimals) : '' }}"
            class="form-control ml-2" placeholder="(@lang('optional')) @lang('products-catalog::variant.prices.limit._')">
 --}}
        <x-form-amount name="prices[limit][]"
            :required="isset($selected)"
            min="0" step="{{ 1 / pow(10, $selected->decimals ?? 0) }}"
            :data-currency-by="isset($selected) ? '#f'.$id : '[name=\'prices[currency_id][]\']'"
            value="{{ $old['limit'] ?? (isset($selected) ? number($selected->pivot->limit, $selected->pivot->currency->decimals) : null) ?? null }}"
            placeholder="products-catalog::variant.prices.limit._"
            class="ml-2" />

        <button type="button" class="btn btn-danger ml-2"
            data-action="delete"
            @if ($selected !== null)
            data-confirm="Eliminar @lang('Price')?"
            data-text="Esta seguro de eliminar la @lang('Price') {{ $selected->name }}?"
            data-accept="Si, eliminar"
            @endif>X</button>
    </div>
{{-- </div> --}}
