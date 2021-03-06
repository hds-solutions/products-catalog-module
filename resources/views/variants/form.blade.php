@include('backend::components.errors')

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::variant.product_id.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <select name="product_id" data-live-search="true" required
            value="{{ isset($resource) && !old('product_id') ? $resource->product_id : old('product_id') }}"
            class="form-control selectpicker {{ $errors->has('product_id') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog::variant.product_id._')">
            <option value="" selected disabled hidden>@lang('products-catalog::variant.product_id.0')</option>
            @foreach($products as $product)
            <option value="{{ $product->id }}"
                data-type="{{ $product->type_id }}"
                data-family="{{ $product->family_id }}"
                data-line="{{ $product->line_id }}"
                @if (isset($resource) && !old('product_id') && $resource->product_id == $product->id ||
                    old('product_id') == $product->id ||
                    request('product') == $product->id) selected @endif>{{ $product->name }}</option>
            @endforeach
        </select>
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('products-catalog::variant.product_id.?')"></i>
    </div> --}}
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::variant.sku.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="sku" type="text" required
            value="{{ isset($resource) && !old('sku') ? $resource->sku : old('sku') }}"
            class="form-control {{ $errors->has('sku') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog::variant.sku._')">
    </div>
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::variant.price.0') / @lang('products-catalog::variant.price_reseller.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <div class="form-row">

            <div class="col-6">
                <input name="price" type="text" thousand="true"
                    value="{{ isset($resource) && !old('price') ? $resource->priceRaw : old('price') }}"
                    class="form-control {{ $errors->has('price') ? 'is-danger' : '' }}"
                    placeholder="(@lang('optional')) @lang('products-catalog::variant.price._')">
            </div>
            <div class="col-6">
                <input name="price_reseller" type="text" thousand="true"
                    value="{{ isset($resource) && !old('price_reseller') ? $resource->price_reseller : old('price_reseller') }}"
                    class="form-control {{ $errors->has('price_reseller') ? 'is-danger' : '' }}"
                    placeholder="(@lang('optional')) @lang('products-catalog::variant.price_reseller._')">
            </div>

        </div>
    </div>
    <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
        title="@lang('products-catalog::variant.price.?')"></i>
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::variant.images.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <div class="input-group">

            <select name="images[]" multiple data-live-search="true"
                data-filtered-by="[name=product_id]" data-filtered-using="product"
                data-preview="#image_preview" class="form-control selectpicker {{ $errors->has('image_id') ? 'is-danger' : '' }}"
                placeholder="@lang('products-catalog::variant.images._')">
                @foreach($images as $image)
                <option value="{{ $image->id }}" url="{{ $image->url }}" data-product="{{ $image->pivot->product_id }}"
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

<!-- available options -->
@foreach ($options as $option)

<div class="form-row form-group align-items-center"
    data-types="{{ implode(',', optional(optional($option->types)->pluck('id'))->all() ?? [] ) }}"
    data-families="{{ implode(',', optional(optional($option->families)->pluck('id'))->all() ?? [] ) }}"
    data-lines="{{ implode(',', optional(optional($option->lines)->pluck('id'))->all() ?? [] ) }}"
    data-linked-with="[name=product_id]" data-linked-using="type:types|family:families|line:lines">

    <label class="col-12 col-md-3 control-label m-0">{{ $option->name }}</label>

    <div class="col-12 col-md-9 col-xl-3">
        {{-- get selected value on variant, if exists --}}
        @php( $key = isset($resource) ? $resource->values->pluck('option_id')->search($option->id) : null )

        {{-- option available values --}}
        <select name="option_value_id[{{ $option->id }}]"
            class="form-control selectpicker"
            placeholder="{{ $option->name }}">

            <option value="" selected disabled hidden>-- {{ $option->name }} --</option>
            @foreach ($option->values as $value)
            <option value="{{ $value->id }}"
                @if (isset($resource) && (
                    $resource->values->pluck('option_id')[$key] == $option->id &&
                    $resource->values->pluck('option_value_id')[$key] == $value->id
                )) selected @endif>{{ $value->value }}</option>
            @endforeach

        </select>
    </div>

    @if ($option->label !== null)
    <i class="fas fa-info-circle ml-2 cursor-help d-none d-lg-inline-block" data-toggle="tooltip" data-placement="right"
        title="{{ $option->label }}"></i>
    @endif
</div>

@endforeach

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::variant.priority.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="priority" type="number"
            value="{{ isset($resource) && !old('priority') ? $resource->priority : old('priority') }}"
            class="form-control {{ $errors->has('priority') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog::variant.priority._')">
    </div>
    {{-- <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
        title="@lang('products-catalog::variant.priority.?')"></i> --}}
</div>

<div class="form-row form-group mb-0">
    <label class="col-12 col-md-3 control-label mt-2 mb-3">@lang('products-catalog::variant.locators.0')</label>
    <div class="col-12 col-md-9 col-xl-6" data-multiple=".locator-container" data-template="#new">
        {{-- TODO: Locators --}}
        @if (false && isset($resource))
        @foreach($resource->locators as $selected)
            @include('products-catalog::variants.locator', compact('warehouses', 'selected'))
        @endforeach
        @endif
        {{-- add empty for adding new locators --}}
        @include('products-catalog::variants.locator', [ 'warehouses' => $warehouses, 'selected' => null ])
    </div>
</div>

<div class="form-row">
    <div class="offset-0 offset-md-3 col-12 col-md-9">
        <button type="submit" class="btn btn-success">@lang('products-catalog::variants.save')</button>
        <a href="{{ route('backend.variants') }}" class="btn btn-danger">@lang('products-catalog::variants.cancel')</a>
    </div>
</div>
