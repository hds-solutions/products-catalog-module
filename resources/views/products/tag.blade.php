<div class="row tag-container mb-3" @if ($selected === null) id="new" @else data-used="true" @endif>
    <div class="col-10">
        <select name="tags[]"
            class="form-control selectpicker" placeholder="@lang('Tag')">
            <option value="" selected disabled hidden>@lang('Tag')</option>
            @foreach($tags as $tag)
            <option value="{{ $tag->id }}"
                @if(isset($selected) && $selected->id == $tag->id) selected @endif>{{ $tag->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-2 d-flex justify-content-end">
        <button type="button" class="btn btn-danger"
            data-action="delete"
            @if ($selected !== null)
            data-confirm="Eliminar @lang('Tag')?"
            data-text="Esta seguro de eliminar la @lang('Tag') {{ $selected->name }}?"
            data-accept="Si, eliminar"
            @endif>X</button>
    </div>
</div>
