<div class="col-12 d-flex mb-1">
    <x-form-foreign name="locators[warehouse_id][]" id="f{{ $id = Str::random(16) }}"
        :values="$warehouses"
        default="{{ $old['warehouse_id'] ?? $selected?->warehouse_id }}"

        foreign="warehouses"
        foreign-add-label="products-catalog::warehouses.add"

        label="products-catalog::warehouse.name.0"
        placeholder="products-catalog::warehouse.name._"
        {{-- helper="products-catalog::warehouse.name.?" --}} />

    <div class="ml-1"></div>

    <x-form-foreign name="locators[locator_id][]"
        :values="$warehouses->pluck('locators')->flatten()"
        default="{{ $old['locator_id'] ?? $selected?->id }}"

        foreign="locators"
        foreign-add-label="products-catalog::locators.add"

        filtered-by="{!! $selected !== null ? '#f'.$id : '[name=\'locator[warehouse_id][]\']' !!}"
        data-filtered-using="warehouse" data-filtered-init="false"
        append="warehouse:warehouse_id"

        label="products-catalog::locator.name.0"
        placeholder="products-catalog::locator.name._"
        {{-- helper="products-catalog::locator.name.?" --}} />

    <button type="button" class="btn btn-danger ml-2"
        data-action="delete"
        @if ($selected !== null)
        data-confirm="Eliminar @lang('Locator')?"
        data-text="Esta seguro de eliminar la @lang('Locator') {{ $selected->name }}?"
        data-accept="Si, eliminar"
        @endif>X</button>
</div>
