{{-- <div class="form-row locator-container mb-3" @if ($selected === null && $old === null) id="new" @else data-used="true" @endif> --}}
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
        <x-form-foreign name="locators[warehouse_id][]" id="f{{ $id = Str::random(16) }}"
            :values="$warehouses"
            default="{{ $old['warehouse_id'] ?? $selected?->warehouse_id }}"

            foreign="warehouses"
            foreign-add-label="inventory::warehouses.add"

            label="inventory::warehouse.name.0"
            placeholder="inventory::warehouse.name._"
            {{-- helper="inventory::warehouse.name.?" --}} />

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
        <x-form-foreign name="locators[locator_id][]"
            :values="$warehouses->pluck('locators')->flatten()"
            default="{{ $old['locator_id'] ?? $selected?->id }}"

            foreign="locators"
            foreign-add-label="inventory::locators.add"

            filtered-by="{!! $selected !== null ? '#f'.$id : '[name=\'locator[warehouse_id][]\']' !!}"
            data-filtered-using="warehouse" data-filtered-init="false"
            append="warehouse:warehouse_id"

            label="inventory::locator.x.0"
            placeholder="inventory::locator.x.0"
            {{-- helper="inventory::locator.x.?" --}} />

        <button type="button" class="btn btn-danger ml-2"
            data-action="delete"
            @if ($selected !== null)
            data-confirm="Eliminar @lang('Locator')?"
            data-text="Esta seguro de eliminar la @lang('Locator') {{ $selected->name }}?"
            data-accept="Si, eliminar"
            @endif>X</button>
    </div>
{{-- </div> --}}
