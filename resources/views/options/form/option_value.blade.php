<input type="hidden" name="values[id][]" value="{{ $selected->id ?? 'new' }}">
<div class="col-12 d-flex mb-1">
    <x-form-input type="text" name="values[value][]" :required="$selected !== null"
        :value="$selected->value ?? null"
        placeholder="products-catalog::option.values.value._" />

    <x-form-input :type="($extra->first()->value_type ?? null) == 'color' ? 'color' : 'text'" name="values[extra][]"
        :value="$selected->extra ?? null"
        placeholder="products-catalog::option.values.extra.optional"

        class="ml-2" />

    <button type="button" class="btn btn-danger ml-2"
        data-action="delete"
        @if ($selected !== null)
        data-confirm="Eliminar Valor?"
        data-text="Esta seguro de eliminar el valor {{ $selected->value ?? 'nuevo' }}?"
        data-accept="Si, eliminar"
        @endif>X</button>
</div>
