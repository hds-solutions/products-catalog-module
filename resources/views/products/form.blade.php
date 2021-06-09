@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="{{ __('products-catalog::product.name.0') }}"
    placeholder="{{ __('products-catalog::product.name._') }}" />

<x-backend-form-foreign :resource="$resource ?? null" name="type_id" required
    foreign="types" :values="$types" foreign-add-label="{{ __('products-catalog::types.add') }}"

    label="{{ __('products-catalog::product.type_id.0') }}"
    placeholder="{{ __('products-catalog::product.type_id._') }}"
    {{-- helper="{{ __('products-catalog::product.type_id.?') }}" --}} />

<x-backend-form-foreign :resource="$resource ?? null" name="brand_id"
    foreign="brands" :values="$brands" foreign-add-label="{{ __('products-catalog::brands.add') }}"

    label="{{ __('products-catalog::product.brand_id.0') }} / {{ __('products-catalog::product.model_id.0') }}"
    placeholder="{{ __('products-catalog::product.brand_id.optional') }}"
    {{-- helper="{{ __('products-catalog::product.brand_id.?') }}" --}}>

    <x-backend-form-foreign :resource="$resource ?? null" name="model_id" secondary
        filtered-by="[name=brand_id]" filtered-using="brand"
        foreign="models" :values="$brands->pluck('models')->flatten()" foreign-add-label="{{ __('products-catalog::models.add') }}"

        label="{{ __('products-catalog::product.model_id.0') }}"
        placeholder="{{ __('products-catalog::product.model_id.optional') }}"
        {{-- helper="{{ __('products-catalog::product.model_id.?') }}" --}} />

</x-backend-form-foreign>

<x-backend-form-foreign :resource="$resource ?? null" name="line_id"
    foreign="lines" :values="$lines" foreign-add-label="{{ __('products-catalog::lines.add') }}"

    label="{{ __('products-catalog::product.line_id.0') }} / {{ __('products-catalog::product.gama_id.0') }}"
    placeholder="{{ __('products-catalog::product.line_id.optional') }}"
    {{-- helper="{{ __('products-catalog::product.line_id.?') }}" --}}>

    <x-backend-form-foreign :resource="$resource ?? null" name="gama_id" secondary
        filtered-by="[name=line_id]" filtered-using="line"
        foreign="gamas" :values="$lines->pluck('gamas')->flatten()" foreign-add-label="{{ __('products-catalog::gamas.add') }}"

        label="{{ __('products-catalog::product.gama_id.0') }}"
        placeholder="{{ __('products-catalog::product.gama_id.optional') }}"
        {{-- helper="{{ __('products-catalog::product.gama_id.?') }}" --}} />

</x-backend-form-foreign>

<x-backend-form-foreign :resource="$resource ?? null" name="family_id"
    foreign="families" :values="$families" foreign-add-label="{{ __('products-catalog::families.add') }}"

    label="{{ __('products-catalog::product.family_id.0') }} / {{ __('products-catalog::product.sub_family_id.0') }}"
    placeholder="{{ __('products-catalog::product.family_id.optional') }}"
    {{-- helper="{{ __('products-catalog::product.family_id.?') }}" --}}>

    <x-backend-form-foreign :resource="$resource ?? null" name="sub_family_id" secondary
        filtered-by="[name=family_id]" filtered-using="family"
        foreign="subFamilies" :values="$families->pluck('subFamilies')->flatten()" foreign-add-label="{{ __('products-catalog::sub_families.add') }}"

        label="{{ __('products-catalog::product.sub_family_id.0') }}"
        placeholder="{{ __('products-catalog::product.sub_family_id.optional') }}"
        {{-- helper="{{ __('products-catalog::product.sub_family_id.?') }}" --}} />

</x-backend-form-foreign>
{{--
<div class="form-row form-group mb-0">
    <label class="col-12 col-md-3 col-lg-2 control-label mt-2 mb-3">@lang('products-catalog::product.categories.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4" data-multiple=".category-container" data-template="#new">
        <?php $old_lines = old('categories') ?? []; ?>
        <!-- add product current categories -->
        @if (isset($resource)) @foreach($resource->categories as $idx => $selected)
            @include('products-catalog::products.form.category', [
                'categories'    => $categories,
                'selected'      => $selected,
                'old'           => $old_lines[$idx] ?? null,
            ])
            <?php unset($old_lines[$idx]); ?>
        @endforeach @endif

        <!-- add new added -->
        @foreach($old_lines as $old)
            <!-- ignore empty -->
            @if ( ($old ?? null) === null)
                @continue
            @endif
            @include('products-catalog::products.form.category', [
                'categories'    => $categories,
                'selected'      => null,
                'old'           => $old,
            ])
        @endforeach

        <!-- add empty for adding new categories -->
        @include('products-catalog::products.form.category', [
            'categories'    => $categories,
            'selected'      => null,
            'old'           => null,
        ])
    </div>
</div>
 --}}
<x-backend-form-multiple name="categories"
    :values="$categories" :selecteds="isset($resource) ? $resource->categories : []"
    contents-view="products-catalog::products.form.category"

    label="products-catalog::product.categories.0" />

<x-backend-form-textarea :resource="$resource ?? null"
    name="brief" wysiwyg
    label="{{ __('products-catalog::product.brief.0') }}"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::product.brief._') }}" />

<x-backend-form-textarea :resource="$resource ?? null"
    name="description" wysiwyg
    label="{{ __('products-catalog::product.description.0') }}"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::product.description._') }}" />
{{--
<div class="form-row form-group mb-0">
    <label class="col-12 col-md-3 col-lg-2 control-label mt-2 mb-3">@lang('products-catalog::product.prices.0')</label>
    <div class="col-11 col-md-8 col-lg-6" data-multiple=".price-container" data-template="#new">
        <?php $old_lines = array_group(old('prices') ?? []); ?>
        <!-- add product current prices -->
        @if (isset($resource)) @foreach($resource->prices as $idx => $selected)
            @include('products-catalog::products.form.price', [
                'currencies'    => $currencies,
                'selected'      => $selected,
                'old'           => $old_lines[$idx] ?? null,
            ])
            <?php unset($old_lines[$idx]); ?>
        @endforeach @endif

        <!-- add new added -->
        @foreach($old_lines as $old)
            <!-- ignore empty -->
            @if ( ($old['currency_id'] ?? null) === null &&
                ($old['cost'] ?? null) === null &&
                ($old['price'] ?? null) === null &&
                ($old['limit'] ?? null) === null)
                @continue
            @endif
            @include('products-catalog::products.form.price', [
                'currencies'    => $currencies,
                'selected'      => null,
                'old'           => $old,
            ])
        @endforeach

        <!-- add empty for adding new prices -->
        @include('products-catalog::products.form.price', [
            'currencies'    => $currencies,
            'selected'      => null,
            'old'           => null,
        ])
    </div>
</div>
 --}}
<x-backend-form-multiple name="prices" values-as="currencies"
    :values="$currencies" :selecteds="isset($resource) ? $resource->prices : []"
    grouped old-filter-fields="currency_id,cost,price,limit"
    contents-view="products-catalog::products.form.price" contents-size="lg"
    row-class="mb-0" container-class="mb-3"

    label="products-catalog::product.prices.0" />

{{-- <x-backend-form-amount :resource="$resource ?? null"
    name="price" field="priceRaw" prepend="{{ config('settings.currency-symbol', 'USD') }}"
    label="{{ __('products-catalog::product.price.0') }} / {{ __('products-catalog::product.price_reseller.0') }}"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::product.price._') }}"
    helper="{{ __('products-catalog::product.price.?') }}">

    <x-backend-form-amount :resource="$resource ?? null" secondary
        name="price_reseller" prepend="{{ config('settings.currency-symbol', 'USD') }}"
        label="{{ __('products-catalog::product.price_reseller.0') }}"
        placeholder="({{ __('optional') }}) {{ __('products-catalog::product.price_reseller._') }}"
        helper="{{ __('products-catalog::product.price_reseller.?') }}">
    </x-backend-form-amount>

</x-backend-form-amount> --}}

<x-backend-form-select :resource="$resource ?? null" name="tax" required
    :values="\HDSSolutions\Finpar\Models\Product::TAXES"
    field="taxRaw"
    default="10i"
    label="{{ __('products-catalog::product.tax.0') }}"
    placeholder="{{ __('products-catalog::product.tax._') }}"
    {{-- helper="{{ __('products-catalog::product.tax.?') }}" --}} />

<x-backend-form-number :resource="$resource ?? null"
    name="weight"
    label="{{ __('products-catalog::product.weight.0') }}"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::product.weight._') }}" />

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 col-lg-2 control-label mb-0">@lang('products-catalog::product.sizes.0')</label>
    <div class="col-3 col-lg-4">
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

<x-backend-form-boolean :resource="$resource ?? null"
    name="giftcard"
    label="{{ __('products-catalog::product.giftcard.0') }}"
    placeholder="{{ __('products-catalog::product.giftcard._') }}" />

<x-backend-form-image :resource="$resource ?? null" :images="$images"
    name="images" multiple
    label="{{ __('products-catalog::product.images.0') }}"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::product.images._') }}" />

<x-backend-form-text :resource="$resource ?? null"
    name="url"
    label="{{ __('products-catalog::product.url.0') }}"
    prepend="{{ url('/') }}/"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::product.url._') }}" />
{{--
<div class="form-row form-group mb-0">
    <label class="col-12 col-md-3 col-lg-2 control-label mt-2 mb-3">@lang('products-catalog::product.tags.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4" data-multiple=".tag-container" data-template="#new">
        <?php $old_lines = old('tags') ?? []; ?>
        <!-- add product current tags -->
        @if (isset($resource)) @foreach($resource->tags as $idx => $selected)
            @include('products-catalog::products.form.tag', [
                'tags'      => $tags,
                'selected'  => $selected,
                'old'       => $old_lines[$idx] ?? null,
            ])
            <?php unset($old_lines[$idx]); ?>
        @endforeach @endif

        <!-- add new added -->
        @foreach($old_lines as $old)
            <!-- ignore empty -->
            @if ( ($old ?? null) === null)
                @continue
            @endif
            @include('products-catalog::products.form.tag', [
                'tags'      => $tags,
                'selected'  => null,
                'old'       => $old,
            ])
        @endforeach

        <!-- add empty for adding new tags -->
        @include('products-catalog::products.form.tag', [
            'tags'      => $tags,
            'selected'  => null,
            'old'       => null,
        ])
    </div>
</div>
 --}}
<x-backend-form-multiple name="tags"
    :values="$tags" :selecteds="isset($resource) ? $resource->tags : []"
    contents-view="products-catalog::products.form.tag"

    label="products-catalog::product.tags.0" />
{{--
<div class="form-row form-group mb-0">
    <label class="col-12 col-md-3 col-lg-2 control-label mt-2 mb-3">@lang('products-catalog::product.locators.0')</label>
    <div class="col-11 col-md-8 col-lg-6" data-multiple=".locator-container" data-template="#new">
        <?php $old_lines = array_group(old('locators') ?? []); ?>
        <!-- add product current locators -->
        @if (isset($resource)) @foreach($resource->locators as $idx => $selected)
            @include('products-catalog::products.form.locator', [
                'warehouses'    => $warehouses,
                'selected'      => $selected,
                'old'           => $old_lines[$idx] ?? null,
            ])
            <?php unset($old_lines[$idx]); ?>
        @endforeach @endif

        <!-- add new added -->
        @foreach($old_lines as $old)
            <!-- ignore empty -->
            @if ( ($old['warehouse_id'] ?? null) === null &&
                ($old['locator_id'] ?? null) === null)
                @continue
            @endif
            @include('products-catalog::products.form.locator', [
                'warehouses'    => $warehouses,
                'selected'      => null,
                'old'           => $old,
            ])
        @endforeach

        <!-- add empty for adding new locators -->
        @include('products-catalog::products.form.locator', [
            'warehouses'    => $warehouses,
            'selected'      => null,
            'old'           => null,
        ])
    </div>
</div>
 --}}
<x-backend-form-multiple name="locators" values-as="warehouses"
    :values="$warehouses" :selecteds="isset($resource) ? $resource->locators : []"
    grouped old-filter-fields="warehouse_id,locator_id"
    contents-view="products-catalog::products.form.locator" contents-size="lg"
    row-class="mb-0" container-class="mb-3"

    label="products-catalog::product.locators.0" />

<x-backend-form-boolean :resource="$resource ?? null"
    name="visible"
    label="{{ __('products-catalog::product.visible.0') }}"
    placeholder="{{ __('products-catalog::product.visible._') }}" />

<x-backend-form-number :resource="$resource ?? null"
    name="priority"
    label="{{ __('products-catalog::product.priority.0') }}"
    placeholder="({{ __('optional') }}) {{ __('products-catalog::product.priority._') }}" />

<x-backend-form-controls
    submit="products-catalog::products.save"
    cancel="products-catalog::products.cancel" cancel-route="backend.products" />
