@include('backend::components.errors')

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::product.name.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="name" type="text" required
            value="{{ isset($resource) && !old('name') ? $resource->name : old('name') }}"
            class="form-control {{ $errors->has('name') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog::product.name._')">
    </div>
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::product.type_id.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <select name="type_id" data-live-search="true" required
            value="{{ isset($resource) && !old('type_id') ? $resource->type_id : old('type_id') }}"
            class="form-control selectpicker {{ $errors->has('type_id') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog::product.type_id._')">
            <option value="" selected disabled hidden>@lang('products-catalog::product.type_id.0')</option>
            @foreach($types as $type)
            <option value="{{ $type->id }}"
                @if (isset($resource) && !old('type_id') && $resource->type_id == $type->id ||
                    old('type_id') == $type->id) selected @endif>{{ $type->name }}</option>
            @endforeach
        </select>
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('products-catalog::product.type_id.?')"></i>
    </div> --}}
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::product.brand_id.0') / @lang('products-catalog::product.model_id.0')</label>

    <div class="col-12 col-md-9 col-xl-3">
        <select name="brand_id"
            value="{{ isset($resource) && !old('brand_id') ? $resource->brand_id : old('brand_id') }}"
            class="form-control selectpicker {{ $errors->has('brand_id') ? 'is-danger' : '' }}"
            placeholder="(@lang('optional')) @lang('products-catalog::product.brand_id._')">
            <option value="" selected>@lang('products-catalog::product.brand_id.0')</option>
            @foreach($brands as $brand)
            <option value="{{ $brand->id }}"
                @if (isset($resource) && !old('brand_id') && $resource->brand_id == $brand->id ||
                    old('brand_id') == $brand->id) selected @endif>{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12 col-md-9 mt-2 mt-xl-0 offset-md-3 offset-xl-0 col-xl-3">
        <select name="model_id" data-filtered-by="[name=brand_id]" data-filtered-using="brand"
            value="{{ isset($resource) && !old('model_id') ? $resource->model_id : old('model_id') }}"
            class="form-control selectpicker {{ $errors->has('model_id') ? 'is-danger' : '' }}"
            placeholder="(@lang('optional')) @lang('products-catalog::product.model_id._')">
            <option value="" selected>@lang('products-catalog::product.model_id._')</option>
            @foreach($brands->pluck('models')->flatten() as $model)
            <option value="{{ $model->id }}" data-brand="{{ $model->brand_id }}"
                @if (isset($resource) && !old('model_id') && $resource->model_id == $model->id ||
                    old('model_id') == $model->id) selected @endif>{{ $model->name }}</option>
            @endforeach
        </select>
    </div>

</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::product.line_id.0') / @lang('products-catalog::product.gama_id.0')</label>

    <div class="col-12 col-md-9 col-xl-3">
        <select name="line_id"
            value="{{ isset($resource) && !old('line_id') ? $resource->line_id : old('line_id') }}"
            class="form-control selectpicker {{ $errors->has('line_id') ? 'is-danger' : '' }}"
            placeholder="(@lang('optional')) @lang('products-catalog::product.line_id._')">
            <option value="" selected>@lang('products-catalog::product.line_id.0')</option>
            @foreach($lines as $line)
            <option value="{{ $line->id }}"
                @if (isset($resource) && !old('line_id') && $resource->line_id == $line->id ||
                    old('line_id') == $line->id) selected @endif>{{ $line->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12 col-md-9 mt-2 mt-xl-0 offset-md-3 offset-xl-0 col-xl-3">
        <select name="gama_id" data-filtered-by="[name=line_id]" data-filtered-using="line"
            value="{{ isset($resource) && !old('gama_id') ? $resource->gama_id : old('gama_id') }}"
            class="form-control selectpicker {{ $errors->has('gama_id') ? 'is-danger' : '' }}"
            placeholder="(@lang('optional')) @lang('products-catalog::product.gama_id._')">
            <option value="" selected>@lang('products-catalog::product.gama_id.0')</option>
            @foreach($lines->pluck('gamas')->flatten() as $gama)
            <option value="{{ $gama->id }}" data-line="{{ $gama->line_id }}"
                @if (isset($resource) && !old('gama_id') && $resource->gama_id == $gama->id ||
                    old('gama_id') == $gama->id) selected @endif>{{ $gama->name }}</option>
            @endforeach
        </select>
    </div>

</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::product.family_id.0') / @lang('products-catalog::product.sub_family_id.0')</label>

    <div class="col-12 col-md-9 col-xl-3">
        <select name="family_id"
            value="{{ isset($resource) && !old('family_id') ? $resource->family_id : old('family_id') }}"
            class="form-control selectpicker {{ $errors->has('family_id') ? 'is-danger' : '' }}"
            placeholder="(@lang('optional')) @lang('products-catalog::product.family_id._')">
            <option value="" selected>@lang('products-catalog::product.family_id.0')</option>
            @foreach($families as $family)
            <option value="{{ $family->id }}"
                @if (isset($resource) && !old('family_id') && $resource->family_id == $family->id ||
                    old('family_id') == $family->id) selected @endif>{{ $family->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12 col-md-9 mt-2 mt-xl-0 offset-md-3 offset-xl-0 col-xl-3">
        <select name="sub_family_id" data-filtered-by="[name=family_id]" data-filtered-using="family"
            value="{{ isset($resource) && !old('sub_family_id') ? $resource->sub_family_id : old('sub_family_id') }}"
            class="form-control selectpicker {{ $errors->has('sub_family_id') ? 'is-danger' : '' }}"
            placeholder="(@lang('optional')) @lang('products-catalog::product.sub_family_id._')">
            <option value="" selected>@lang('products-catalog::product.sub_family_id.0')</option>
            @foreach($families->pluck('sub_families')->flatten() as $subFamily)
            <option value="{{ $subFamily->id }}" data-family="{{ $subFamily->family_id }}"
                @if (isset($resource) && !old('sub_family_id') && $resource->sub_family_id == $subFamily->id ||
                    old('sub_family_id') == $subFamily->id) selected @endif>{{ $subFamily->name }}</option>
            @endforeach
        </select>
    </div>

</div>

<div class="form-row form-group mb-0">
    <label class="col-12 col-md-3 control-label mt-2 mb-3">@lang('products-catalog::product.categories.0')</label>
    <div class="col-12 col-md-9 col-xl-3" data-multiple=".category-container" data-template="#new">
        @php $old = old('categories') ?? []; @endphp
        {{-- add product current categories --}}
        @if (isset($resource)) @foreach($resource->categories as $idx => $selected)
            @include('products-catalog::products.category', [
                'categories'    => $categories,
                'selected'      => $selected,
                'old'           => $old[$idx] ?? null,
            ])
            @php unset($old[$idx]); @endphp
        @endforeach @endif

        {{-- add new added --}}
        @foreach($old as $selected)
            @include('products-catalog::products.category', [
                'categories'    => $categories,
                'selected'      => 0,
                'old'           => $selected,
            ])
        @endforeach

        {{-- add empty for adding new categories --}}
        @include('products-catalog::products.category', [
            'categories'    => $categories,
            'selected'      => null,
            'old'           => null,
        ])
    </div>
</div>

<div class="form-row form-group">
    <label class="col-12 col-md-3 control-label mt-2 mb-0">@lang('products-catalog::product.brief.0')</label>
    <div class="col-6">
        <textarea name="brief"
            class="form-control resize-none wysiwyg {{ $errors->has('brief') ? 'is-danger' : '' }}"
            placeholder="(@lang('optional')) @lang('products-catalog::product.brief._')">{{ isset($resource) && !old('brief') ? $resource->brief : old('brief') }}</textarea>
    </div>
</div>

<div class="form-row form-group">
    <label class="col-12 col-md-3 control-label mt-2 mb-0">@lang('products-catalog::product.description.0')</label>
    <div class="col-6">
        <textarea name="description"
            class="form-control resize-none wysiwyg {{ $errors->has('description') ? 'is-danger' : '' }}"
            placeholder="(@lang('optional')) @lang('products-catalog::product.description._')">{{ isset($resource) && !old('description') ? $resource->description : old('description') }}</textarea>
    </div>
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::product.price.0') / @lang('products-catalog::product.price_reseller.0')</label>
    <div class="col-3">
        <div class="form-row">

            <div class="col-6">
                <input name="price" type="text" thousand="true"
                    value="{{ isset($resource) && !old('price') ? $resource->priceRaw : old('price') }}"
                    class="form-control {{ $errors->has('price') ? 'is-danger' : '' }}"
                    placeholder="(@lang('optional')) @lang('products-catalog::product.price._')">
            </div>
            <div class="col-6">
                <input name="price_reseller" type="text" thousand="true"
                    value="{{ isset($resource) && !old('price_reseller') ? $resource->price_reseller : old('price_reseller') }}"
                    class="form-control {{ $errors->has('price_reseller') ? 'is-danger' : '' }}"
                    placeholder="(@lang('optional')) @lang('products-catalog::product.price_reseller._')">
            </div>

        </div>
    </div>
    <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
        title="@lang('products-catalog::product.price.?')"></i>
</div>

<div class="form-row form-group d-flex align-items-center">
    <label class="col-12 col-md-3 control-label m-0">@lang('products-catalog::product.tax.0')</label>

    <div class="col-12 col-md-9 col-xl-3">
        <select name="tax" required
            value="{{ isset($resource) && !old('tax') ? $resource->taxRaw : old('tax') }}"
            class="form-control selectpicker {{ $errors->has('tax') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog::product.tax._')">
            <option value="" selected disabled hidden>@lang('products-catalog::product.tax.0')</option>
            @foreach([
                'ex'    => 'Sin I.V.A.',
                '05'    => '5% extra',
                '05i'   => '5% incluido',
                '10'    => '10% extra',
                '10i'   => '10% incluido',
            ] as $tax => $name)
            <option value="{{ $tax }}"
                @if (isset($resource) && !old('tax') && $resource->taxRaw == $tax ||
                    old('tax') == $tax || (!isset($resource) && !old('tax') && $tax == '10i')) selected @endif>{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::product.weight.0')</label>
    <div class="col-3">
        <input name="weight" type="number" min="0" step="0.01"
            value="{{ isset($resource) && !old('weight') ? $resource->weight : old('weight') }}"
            class="form-control {{ $errors->has('weight') ? 'is-danger' : '' }}"
            placeholder="(@lang('optional')) @lang('products-catalog::product.weight._')">
    </div>
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::product.sizes.0')</label>
    <div class="col-3">
        <div class="form-row">
            <div class="col-4">
                <input name="length" type="number" min="0" step="0.01"
                    value="{{ isset($resource) && !old('length') ? $resource->length : old('length') }}"
                    class="form-control {{ $errors->has('length') ? 'is-danger' : '' }}"
                    placeholder="(@lang('optional')) @lang('products-catalog::product.length._')">
            </div>
            <div class="col-4">
                <input name="width" type="number" min="0" step="0.01"
                    value="{{ isset($resource) && !old('width') ? $resource->width : old('width') }}"
                    class="form-control {{ $errors->has('width') ? 'is-danger' : '' }}"
                    placeholder="(@lang('optional')) @lang('products-catalog::product.width._')">
            </div>
            <div class="col-4">
                <input name="height" type="number" min="0" step="0.01"
                    value="{{ isset($resource) && !old('height') ? $resource->height : old('height') }}"
                    class="form-control {{ $errors->has('height') ? 'is-danger' : '' }}"
                    placeholder="(@lang('optional')) @lang('products-catalog::product.height._')">
            </div>
        </div>
    </div>
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::product.giftcard.0')</label>
    <div class="col-3">
        <div class="form-check">
            <input type="hidden" name="giftcard" value="{{ (isset($resource) && !old('giftcard') ? $resource->giftcard : old('giftcard')) ? 'true' : 'false' }}">
            <input type="checkbox" id="giftcard"
                onchange="this.previousElementSibling.value = this.checked ? 'true' : 'false'"
                @if (isset($resource) && !old('giftcard') ? $resource->giftcard : old('giftcard')) checked @endif
                class="form-check-input {{ $errors->has('giftcard') ? 'is-danger' : '' }}"
                placeholder="@lang('products-catalog::product.giftcard._')">
            <label for="giftcard" class="form-check-label">@lang('products-catalog::product.giftcard._')</label>
        </div>
    </div>
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::product.images.0')</label>
    <div class="col-6">
        <div class="input-group">

            <select name="images[]" multiple data-live-search="true"
                data-preview="#image_preview" class="form-control selectpicker {{ $errors->has('image_id') ? 'is-danger' : '' }}"
                placeholder="@lang('products-catalog::product.images._')">
                @foreach($images as $image)
                <option value="{{ $image->id }}" url="{{ $image->url }}"
                    @if (isset($resource) && $resource->images->contains($image->id)) selected @endif>{{ $image->name }}</option>
                @endforeach
            </select>

            <div class="input-group-append">
                <label class="btn btn-outline-primary mb-0" for="upload">
                    <span class="fas fa-fw fa-cloud-upload-alt"></span>
                    <input type="file" name="images[]" accept="image/*" id="upload" multiple
                        class="d-none" data-preview="#image_preview" data-prepend-preview="select[name='images[]']">
                </label>
            </div>
        </div>
    </div>
    <div class="col-9 col-xl-6 offset-3 d-flex flex-wrap justify-content-center">
        <img src="#" id="image_preview" class="m-1 mh-150px rounded" style="display: none;">
    </div>
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::product.url.0')</label>
    <div class="col-6">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">{{ url('/') }}/</div>
            </div>
            <input name="url" type="text"
                value="{{ isset($resource) && !old('url') ? $resource->url_raw : old('url') }}"
                class="form-control {{ $errors->has('url') ? 'is-danger' : '' }}"
                placeholder="(@lang('optional')) @lang('products-catalog::product.url._')">
        </div>
    </div>
</div>

<div class="form-row form-group mb-0">
    <label class="col-12 col-md-3 control-label mt-2 mb-3">@lang('products-catalog::product.tags.0')</label>
    <div class="col-12 col-md-9 col-xl-3" data-multiple=".tag-container" data-template="#new">
        @if (isset($resource))
        @foreach($resource->tags as $selected)
            @include('products-catalog::products.tag', compact('tags', 'selected'))
        @endforeach
        @endif
        {{-- add empty for adding new tags --}}
        @include('products-catalog::products.tag', [ 'tags' => $tags, 'selected' => null ])
    </div>
</div>

<div class="form-row form-group mb-0">
    <label class="col-12 col-md-3 control-label mt-2 mb-3">@lang('products-catalog::product.locators.0')</label>
    <div class="col-12 col-md-9 col-xl-6" data-multiple=".locator-container" data-template="#new">
        {{-- TODO: Locators --}}
        @if (false && isset($resource))
        @foreach($resource->locators as $selected)
            @include('products-catalog::products.locator', compact('warehouses', 'selected'))
        @endforeach
        @endif
        {{-- add empty for adding new locators --}}
        @include('products-catalog::products.locator', [ 'warehouses' => $warehouses, 'selected' => null ])
    </div>
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::product.visible.0')</label>
    <div class="col-3">
        <div class="form-check">
            <input type="hidden" name="visible" value="{{ (isset($resource) && !old('visible') ? $resource->visible : old('visible')) ? 'true' : 'false' }}">
            <input type="checkbox" id="visible"
                onchange="this.previousElementSibling.value = this.checked ? 'true' : 'false'"
                @if (isset($resource) && !old('visible') ? $resource->visible : old('visible')) checked @endif
                class="form-check-input {{ $errors->has('visible') ? 'is-danger' : '' }}"
                placeholder="@lang('products-catalog::product.visible._')">
            <label for="visible" class="form-check-label">@lang('products-catalog::product.visible._')</label>
        </div>
    </div>
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::product.priority.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="priority" type="number"
            value="{{ isset($resource) && !old('priority') ? $resource->priority : old('priority') }}"
            class="form-control {{ $errors->has('priority') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog::product.priority._')">
    </div>
    {{-- <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
        title="@lang('products-catalog::product.priority.?')"></i> --}}
</div>

<div class="form-row">
    <div class="offset-0 offset-md-3 col-12 col-md-9">
        <button type="submit" class="btn btn-success">@lang('products-catalog::products.save')</button>
        <a href="{{ route('backend.products') }}" class="btn btn-danger">@lang('products-catalog::products.cancel')</a>
    </div>
</div>
