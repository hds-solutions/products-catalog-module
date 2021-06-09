{{-- <div class="form-row price-container mb-3" @if ($selected === null && $old === null) id="new" @else data-used="true" @endif> --}}
    <div class="col-2 pr-0">
{{--
        <select name="prices[currency_id][]" @if (isset($selected)) id="f{{ $id = Str::random(16) }}" @endif
            value="{{ isset($selected) ? $selected->currency_id : '' }}"
            data-none-selected-text="@lang('products-catalog::product.prices.currency_id._')"
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

            {{-- foreign="" --}}
            {{-- foreign-add-label="products-catalog::currencies.add" --}}

            label="products-catalog::product.prices.currency_id.0"
            placeholder="products-catalog::product.prices.currency_id._"
            {{-- helper="products-catalog::product.prices.currency_id.?" --}} />
    </div>

    <div class="col-10 d-flex">
        <div class="input-group">

{{--
        <input name="prices[cost][]" type="number" thousand @if (isset($selected)) required @endif
            min="0" step="{{ 1 / pow(10, $selected->decimals ?? 0) }}" data-currency-by="{{ isset($selected) ? "#f$id" : '[name="prices[currency_id][]"]' }}"
            value="{{ isset($selected) ? number($selected->pivot->cost, $selected->pivot->currency->decimals) : '' }}"
            class="form-control" placeholder="@lang('products-catalog::product.prices.cost._')">
 --}}
        <x-form-amount name="prices[cost][]"
            :required="$selected !== null"
            min="0" step="{{ 1 / pow(10, $selected->decimals ?? 0) }}"
            :data-currency-by="isset($selected) ? '#f'.$id : '[name=\'prices[currency_id][]\']'"
            value="{{ $old['cost'] ?? ($selected !== null ? number($selected->pivot->cost, $selected->pivot->currency->decimals) : null) }}"
            placeholder="products-catalog::product.prices.cost._"
            class="text-right" />
{{--
        <input name="prices[price][]" type="number" thousand @if (isset($selected)) required @endif
            min="0" step="{{ 1 / pow(10, $selected->decimals ?? 0) }}" data-currency-by="{{ isset($selected) ? "#f$id" : '[name="prices[currency_id][]"]' }}"
            value="{{ $old['price'] ?? ($selected !== null ? number($selected->pivot->price, $selected->pivot->currency->decimals) : null) }}"
            class="form-control ml-2" placeholder="@lang('products-catalog::product.prices.price._')">
 --}}
        <x-form-amount name="prices[price][]"
            :required="$selected !== null"
            min="0" step="{{ 1 / pow(10, $selected->decimals ?? 0) }}"
            :data-currency-by="isset($selected) ? '#f'.$id : '[name=\'prices[currency_id][]\']'"
            value="{{ $old['price'] ?? ($selected !== null ? number($selected->pivot->price, $selected->pivot->currency->decimals) : null) }}"
            placeholder="products-catalog::product.prices.price._"
            class="text-right" />
{{--
        <input name="prices[limit][]" type="number" thousand
            min="0" step="{{ 1 / pow(10, $selected->decimals ?? 0) }}" data-currency-by="{{ isset($selected) ? "#f$id" : '[name="prices[currency_id][]"]' }}"
            value="{{ $old['limit'] ?? ($selected !== null ? number($selected->pivot->price, $selected->pivot->currency->decimals) : null) }}"
            class="form-control ml-2" placeholder="(@lang('optional')) @lang('products-catalog::product.prices.limit._')">
 --}}
        <x-form-amount name="prices[limit][]"
            :required="$selected !== null"
            min="0" step="{{ 1 / pow(10, $selected->decimals ?? 0) }}"
            :data-currency-by="isset($selected) ? '#f'.$id : '[name=\'prices[currency_id][]\']'"
            value="{{ $old['limit'] ?? ($selected !== null ? number($selected->pivot->limit, $selected->pivot->currency->decimals) : null) }}"
            placeholder="products-catalog::product.prices.limit._"
            class="text-right" />
        </div>

        <button type="button" class="btn btn-danger ml-2"
            data-action="delete"
            @if ($selected !== null)
            data-confirm="Eliminar @lang('Price')?"
            data-text="Esta seguro de eliminar la @lang('Price') {{ $selected->name }}?"
            data-accept="Si, eliminar"
            @endif>X</button>
    </div>
{{-- </div> --}}
