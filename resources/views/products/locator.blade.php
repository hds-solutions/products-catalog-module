<div class="form-row locator-container mb-3" @if ($selected === null) id="new" @else data-used="true" @endif>
    <div class="col-6">
        <select name="warehouses[]" @if (isset($selected)) id="f{{ $id = Str::random(16) }}" @endif
            value="{{ isset($selected) ? $selected->warehouse_id : '' }}"
            class="form-control selectpicker" placeholder="@lang('products-catalog::warehouse.name._')">
            <option value="" selected disabled hidden>@lang('products-catalog::warehouse.name.0')</option>
            @foreach($warehouses as $warehouse)
            <option value="{{ $warehouse->id }}"
                @if (isset($selected) && $selected->warehouse_id == $warehouse->id) selected @endif>{{ $warehouse->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-4">
        <select name="locators[]"
            data-filtered-by='{{ isset($selected) ? "#f$id" : '[name="warehouses[]"]' }}' data-filtered-using="warehouse"
            class="form-control custom-select" placeholder="@lang('products-catalog::locator.name._')">
            <option value="" selected disabled hidden>@lang('products-catalog::locator.name.0')</option>
            @foreach($warehouses->pluck('locators')->flatten() as $locator)
            <option value="{{ $locator->id }}" data-warehouse="{{ $locator->warehouse_id }}"
                @if (isset($selected) && $selected->id == $locator->id &&
                    $selected->warehouse_id == $locator->warehouse_id) selected @endif>{{ $locator->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-2 d-flex justify-content-end">
        <button type="button" class="btn btn-danger"
            data-action="delete"
            @if ($selected !== null)
            data-confirm="Eliminar @lang('Locator')?"
            data-text="Esta seguro de eliminar la @lang('Locator') {{ $selected->name }}?"
            data-accept="Si, eliminar"
            @endif>X</button>
    </div>
</div>
