{{-- <div class="row tag-container mb-3" @if ( ($selected ?? null) === null) id="new" @else data-used="true" @endif> --}}
    <div class="col-12 d-flex mb-3">
        <x-form-foreign name="tags[]"
            :values="$tags"
            default="{{ $old ?? $selected?->id }}"

            {{-- foreign="" --}}
            {{-- foreign-add-label="products-catalog::tags.add" --}}

            label="products-catalog::product.tags.tag_id.0"
            placeholder="products-catalog::product.tags.tag_id._"
            {{-- helper="products-catalog::product.tags.tag_id.?" --}}
            />
{{--
        <select name="tags[]"
            class="form-control selectpicker" placeholder="@lang('products-catalog::tag.name._')">
            <option value="" selected disabled hidden>@lang('products-catalog::category.name.0')</option>
            @foreach($tags as $tag)
            <option value="{{ $tag->id }}"
                @if (isset($selected) && !$old && $tag->id == $selected->id ||
                    isset($old) && $tag->id == $old)) selected @endif>{{ $tag->name }}</option>
            @endforeach
        </select>
 --}}
        <button type="button" class="btn btn-danger ml-2"
            data-action="delete"
            @if ($selected !== null)
            data-confirm="Eliminar @lang('Tag')?"
            data-text="Esta seguro de eliminar la @lang('Tag') {{ $selected->name }}?"
            data-accept="Si, eliminar"
            @endif>X</button>
    </div>
{{-- </div> --}}
