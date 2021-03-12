@include('backend::components.errors')

<x-backend-form-foreign :resource="$resource ?? null" name="product_id" required
    foreign="products" :values="$products" foreign-add-label="{{ __('products-catalog::products.add') }}"
    append="type,family,line" request="product"

    label="{{ __('products-catalog::variant.product_id.0') }}"
    placeholder="{{ __('products-catalog::variant.product_id._') }}"
    {{-- helper="{{ __('products-catalog::variant.product_id.?') }}" --}} />

<x-backend-form-text :resource="$resource ?? null" name="sku" required
    label="{{ __('products-catalog::variant.sku.0') }}"
    placeholder="{{ __('products-catalog::variant.sku._') }}" />

<div class="form-row form-group mb-0">
    <label class="col-12 col-md-3 control-label mt-2 mb-3">@lang('products-catalog::variant.prices.0')</label>
    <div class="col-11 col-md-8 col-lg-6" data-multiple=".price-container" data-template="#new">
        @php $old = old('prices') ?? []; @endphp
        {{-- add product current prices --}}
        @if (isset($resource)) @foreach($resource->prices as $idx => $selected)
            @include('products-catalog::variants.price', [
                'currencies'    => $currencies,
                'selected'      => $selected,
                'old'           => $old[$idx] ?? null,
            ])
            @php unset($old[$idx]); @endphp
        @endforeach @endif

        {{-- add new added --}}
        @foreach($old as $selected)
            @include('products-catalog::variants.price', [
                'currencies'    => $currencies,
                'selected'      => 0,
                'old'           => $selected,
            ])
        @endforeach

        {{-- add empty for adding new prices --}}
        @include('products-catalog::variants.price', [
            'currencies'    => $currencies,
            'selected'      => null,
            'old'           => null,
        ])
    </div>
</div>

{{-- <x-backend-form-amount :resource="$resource ?? null"
    name="price" field="priceRaw" prepend="{{ config('settings.currency-symbol', 'USD') }}"
    label="{{ __('products-catalog::variant.price.0') }} / {{ __('products-catalog::variant.price_reseller.0') }}"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::variant.price._') }}"
    helper="{{ __('products-catalog::variant.price.?') }}">

    <x-backend-form-amount :resource="$resource ?? null" secondary
        name="price_reseller" prepend="{{ config('settings.currency-symbol', 'USD') }}"
        label="{{ __('products-catalog::variant.price_reseller.0') }}"
        placeholder="({{ __('optional') }}) {{ __('products-catalog::variant.price_reseller._') }}"
        helper="{{ __('products-catalog::variant.price_reseller.?') }}">
    </x-backend-form-amount>

</x-backend-form-amount> --}}

<x-backend-form-image :resource="$resource ?? null" :images="$images"
    name="images" multiple
    filtered-by="[name=product_id]" filtered-using="product"

    label="{{ __('products-catalog::variant.images.0') }}"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::variant.images._') }}" />

{{-- <div class="form-row form-group align-items-center">
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
</div> --}}

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
        @php
            $key = isset($resource) ? $resource->values->pluck('option_id')->search($option->id) : null;
        @endphp

        {{-- option available values --}}
        <select name="option_value_id[{{ $option->id }}]"
            class="form-control selectpicker"
            placeholder="{{ $option->name }}">

            <option value="" selected disabled hidden>-- {{ $option->name }} --</option>
            @foreach ($option->values as $value)
            <option value="{{ $value->id }}"
                @if (isset($resource) && $resource->values->count() && (
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

<x-backend-form-number :resource="$resource ?? null"
    name="priority"
    label="{{ __('products-catalog::variant.priority.0') }}"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::variant.priority._') }}" />

<div class="form-row form-group mb-0">
    <label class="col-12 col-md-3 control-label mt-2 mb-3">@lang('products-catalog::variant.locators.0')</label>
    <div class="col-11 col-md-8 col-lg-6" data-multiple=".locator-container" data-template="#new">
        @php $old = old('locators') ?? []; @endphp
        {{-- add variant current locators --}}
        @if (isset($resource)) @foreach($resource->locators as $idx => $selected)
            @include('products-catalog::variants.locator', [
                'warehouses'    => $warehouses,
                'selected'      => $selected,
                'old'           => $old[$idx] ?? null,
            ])
            @php unset($old[$idx]); @endphp
        @endforeach @endif

        {{-- add new added --}}
        @foreach($old as $selected)
            @include('products-catalog::variants.locator', [
                'warehouses'    => $warehouses,
                'selected'      => 0,
                'old'           => $selected,
            ])
        @endforeach

        {{-- add empty for adding new locators --}}
        @include('products-catalog::variants.locator', [
            'warehouses'    => $warehouses,
            'selected'      => null,
            'old'           => null,
        ])
    </div>
</div>

<div class="form-row">
    <div class="offset-0 offset-md-3 col-12 col-md-9">
        <button type="submit" class="btn btn-success">@lang('products-catalog::variants.save')</button>
        <a href="{{ route('backend.variants') }}" class="btn btn-danger">@lang('products-catalog::variants.cancel')</a>
    </div>
</div>
