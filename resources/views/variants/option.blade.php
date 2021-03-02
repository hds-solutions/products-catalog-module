<div class="col-6 mb-2 option-container" @if ($selected === null) id="new" @else data-used="true" @endif>
    <div class="card bg-light">
        <div class="card-body py-2">

            <div class="row">
                <div class="col-10">
                    <div class="row d-flex align-items-center">
                        <label class="col-4 control-label m-0">Opción:</label>
                        <div class="col-8">

                            <select name="options[]"
                                class="form-control custom-select" placeholder="Opción">
                                <option value="" selected disabled hidden>Opción</option>
                                @foreach($options as $option)
                                <option value="{{ $option->id }}"
                                    @if(isset($selected) && $selected->id == $option->id) selected @endif>{{ $option->name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger"
                        data-action="delete"
                        @if ($selected !== null)
                        data-confirm="Eliminar Opción?"
                        data-text="Esta seguro de eliminar la opción {{ $selected->name }}?"
                        data-accept="Si, eliminar"
                        @endif>X</button>
                </div>
            </div>

        </div>
    </div>
</div>