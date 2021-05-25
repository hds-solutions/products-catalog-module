<div class="form-row locator-container mb-3"
    @if ($selected === null && $old === null) id="new" @else data-used="true" @endif>
    <div class="col-12 d-flex">
{{--
        <select name="warehouses[]" @if (isset($selected)) id="f{{ $id = Str::random(16) }}" @endif
            value="{{ isset($selected) ? $selected->warehouse_id : '' }}"
            class="form-control selectpicker" placeholder="@lang('products-catalog::warehouse.name._')">
            <option value="" selected disabled hidden>@lang('products-catalog::warehouse.name.0')</option>
            @foreach($warehouses as $warehouse)
            <option value="{{ $warehouse->id }}"
                @if (isset($selected) && $selected->warehouse_id == $warehouse->id) selected @endif>{{ $warehouse->name }}</option>
            @endforeach
        </select>
 --}}
        <x-form-foreign name="warehouses[]" id="{{ isset($selected) ? 'f'.($id = Str::random(16)) : null }}"
            :values="$warehouses"

            {{-- show="code name" title="code" --}}
            {{-- append="decimals" --}}
            default="{{ $old['warehouse_id'] ?? $selected?->warehouse_id ?? null }}"

            {{-- foreign="currencies" foreign-add-label="products-catalog::currencies.add" --}}

            label="products-catalog::warehouse.name.0"
            placeholder="products-catalog::warehouse.name._"
            />

        <div class="ml-2"></div>
{{--
        <select name="locators[]"
            data-filtered-by='{{ isset($selected) ? "#f$id" : '[name="warehouses[]"]' }}' data-filtered-using="warehouse"
            class="form-control selectpicker" placeholder="@lang('products-catalog::locator.name._')">
            <option value="" selected disabled hidden>@lang('products-catalog::locator.name.0')</option>
            @foreach($warehouses->pluck('locators')->flatten() as $locator)
            <option value="{{ $locator->id }}" data-warehouse="{{ $locator->warehouse_id }}"
                @if (isset($selected) && $selected->id == $locator->id &&
                    $selected->warehouse_id == $locator->warehouse_id) selected @endif>{{ $locator->name }}</option>
            @endforeach
        </select>
 --}}
        <x-form-foreign name="locators[]"
            :values="$warehouses->pluck('locators')->flatten()"

            {{-- show="warehouse.name [name]" title="name" --}}
            append="warehouse:warehouse_id"
            default="{{ $old['locator_id'] ?? $selected?->id ?? null }}"

            :data-filtered-by="isset($selected) ? '#f'.$id : '[name=\'warehouses[]\']'" data-filtered-using="warehouse"

            {{-- foreign="warehouses" foreign-add-label="products-catalog::warehouses.add" --}}

            label="products-catalog::locator.name.0"
            placeholder="products-catalog::locator.name._"
            />

        <button type="button" class="btn btn-danger ml-2"
            data-action="delete"
            @if ($selected !== null)
            data-confirm="Eliminar @lang('Locator')?"
            data-text="Esta seguro de eliminar la @lang('Locator') {{ $selected->name }}?"
            data-accept="Si, eliminar"
            @endif>X</button>
    </div>
</div>
