<div class="col-12 d-flex mb-1">
    <x-form-foreign name="options[]" :values="$options"
        show="label - name"
        default="{{ $old ?? $selected?->id }}"

        foreign="options" foreign-add-label="products-catalog::options.add"

        label="products-catalog::type.options.name.0"
        placeholder="products-catalog::type.options.name._"
        {{-- helper="products-catalog::type.options.name.?" --}} />

    <button type="button" class="btn btn-danger ml-2"
        data-action="delete"
        @if ($selected !== null)
        data-confirm="Eliminar Opción?"
        data-text="Esta seguro de eliminar la opción {{ $selected->name }}?"
        data-accept="Si, eliminar"
        @endif>X</button>
</div>
