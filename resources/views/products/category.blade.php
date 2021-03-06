<div class="row category-container mb-3" @if ( ($selected ?? null) === null) id="new" @else data-used="true" @endif>
    <div class="col-12 d-flex">
        <select name="categories[]"
            class="form-control selectpicker" placeholder="@lang('products-catalog::category.name._')">
            <option value="" selected disabled hidden>@lang('products-catalog::category.name.0')</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}"
                @if (isset($selected) && !$old && $category->id == $selected->id ||
                    isset($old) && $category->id == $old)) selected @endif>{{ $category->name }}</option>
            @endforeach
        </select>

        <button type="button" class="btn btn-danger ml-2"
            data-action="delete"
            @if ( ($selected ?? null) !== null && $selected !== 0)
            data-confirm="Eliminar @lang('Category')?"
            data-text="Esta seguro de eliminar la @lang('Category') {{ $selected->name }}?"
            data-accept="Si, eliminar"
            @endif>X</button>
    </div>
</div>
