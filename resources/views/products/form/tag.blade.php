<div class="col-12 d-flex mb-1">
    <x-form-foreign name="tags[]"
        :values="$tags"
        default="{{ $old ?? $selected?->id }}"

        foreign="tags" foreign-add-label="products-catalog::tags.add"

        label="products-catalog::product.tags.tag_id.0"
        placeholder="products-catalog::product.tags.tag_id._"
        {{-- helper="products-catalog::product.tags.tag_id.?" --}} />

    <button type="button" class="btn btn-danger ml-2"
        data-action="delete"
        @if ($selected !== null)
        data-confirm="Eliminar @lang('Tag')?"
        data-text="Esta seguro de eliminar la @lang('Tag') {{ $selected->name }}?"
        data-accept="Si, eliminar"
        @endif>X</button>
</div>
