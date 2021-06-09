{{-- <div class="row category-container mb-3" @if ($selected === null && $old === null) id="new" @else data-used="true" @endif> --}}
    <div class="col-12 d-flex mb-1">
        <x-form-foreign name="categories[]"
            :values="$categories"
            default="{{ $old ?? $selected?->id }}"

            foreign="categories"
            foreign-add-label="products-catalog::categories.add"

            label="products-catalog::product.categories.category_id.0"
            placeholder="products-catalog::product.categories.category_id._"
            {{-- helper="products-catalog::product.categories.category_id.?" --}}
            />
{{--
        <select name="categories[]"
            data-none-selected-text="@lang('products-catalog::product.categories.category_id._')"
            class="form-control selectpicker" placeholder="@lang('products-catalog::product.categories.category_id._')">
            <option value="" selected disabled hidden>@lang('products-catalog::product.categories.category_id.0')</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}"
                @if (isset($selected) && !$old && $category->id == $selected->id ||
                    isset($old) && $category->id == $old)) selected @endif>{{ $category->name }}</option>
            @endforeach
        </select>
 --}}
        <button type="button" class="btn btn-danger ml-2"
            data-action="delete"
            @if ($selected !== null)
            data-confirm="Eliminar @lang('Category')?"
            data-text="Esta seguro de eliminar la @lang('Category') {{ $selected->name }}?"
            data-accept="Si, eliminar"
            @endif>X</button>
    </div>
{{-- </div> --}}
