<div class="col-12 d-flex mb-1">
    <x-form-foreign name="categories[]"
        :values="$categories"
        default="{{ $old ?? $selected?->id }}"

        foreign="categories"
        foreign-add-label="products-catalog::categories.add"

        label="products-catalog::product.categories.category_id.0"
        placeholder="products-catalog::product.categories.category_id._"
        {{-- helper="products-catalog::product.categories.category_id.?" --}} />

    <button type="button" class="btn btn-danger ml-2"
        data-action="delete"
        @if ($selected !== null)
        data-confirm="Eliminar @lang('Category')?"
        data-text="Esta seguro de eliminar la @lang('Category') {{ $selected->name }}?"
        data-accept="Si, eliminar"
        @endif>X</button>
</div>
