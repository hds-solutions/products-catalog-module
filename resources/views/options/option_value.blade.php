<div class="col-6 mb-2 option-value-container" @if ($value === null) id="new" @else data-used="true" @endif>
    <div class="card bg-light">
        <div class="card-body py-2">

            <input type="hidden" name="values[id][]" value="{{ $value->id ?? 'new' }}">
            <div class="row">
                <div class="col-10">
                    <div class="row mb-1 d-flex align-items-center">
                        <label class="col-4 control-label m-0">@lang('products-catalog/option.values.value.0')</label>
                        <div class="col-8">
                            <input name="values[value][]" type="text"
                                value="{{ $value->value ?? '' }}" @if ($value !== null) required @endif
                                class="form-control" placeholder="@lang('products-catalog/option.values.value._')">
                        </div>
                    </div>
                    <div class="row d-flex align-items-center">
                        <label class="col-4 control-label m-0">@lang('products-catalog/option.values.extra._')</label>
                        <div class="col-8">
                            <input name="values[extra][]" type="{{ ($resource->value_type ?? null) == 'color' ? 'color' : 'text' }}"
                                value="{{ $value->extra ?? '' }}"
                                class="form-control" placeholder="(@lang('optional')) @lang('products-catalog/option.values.extra._')">
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger"
                        data-action="delete"
                        @if ($value !== null)
                        data-confirm="Eliminar Valor?"
                        data-text="Esta seguro de eliminar el valor {{ $value->value ?? 'nuevo' }}?"
                        data-accept="Si, eliminar"
                        @endif>X</button>
                </div>
            </div>

        </div>
    </div>
</div>