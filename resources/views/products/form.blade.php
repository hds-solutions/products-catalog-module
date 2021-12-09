@include('backend::components.errors')

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="products-catalog::product.name.0"
    placeholder="products-catalog::product.name._" />

<x-backend-form-foreign :resource="$resource ?? null" name="type_id" required
    foreign="types" :values="$types" foreign-add-label="products-catalog::types.add"

    label="products-catalog::product.type_id.0"
    placeholder="products-catalog::product.type_id._"
    {{-- helper="products-catalog::product.type_id.?" --}} />

<x-backend-form-foreign :resource="$resource ?? null" name="brand_id"
    foreign="brands" :values="$brands" foreign-add-label="products-catalog::brands.add"

    label="{{ __('products-catalog::product.brand_id.0') }} / {{ __('products-catalog::product.model_id.0') }}"
    placeholder="products-catalog::product.brand_id.optional"
    {{-- helper="products-catalog::product.brand_id.?" --}}>

    <x-backend-form-foreign :resource="$resource ?? null" name="model_id" secondary
        filtered-by="[name=brand_id]" filtered-using="brand"
        foreign="models" :values="$brands->pluck('models')->flatten()" foreign-add-label="products-catalog::models.add"

        label="products-catalog::product.model_id.0"
        placeholder="products-catalog::product.model_id.optional"
        {{-- helper="products-catalog::product.model_id.?" --}} />

</x-backend-form-foreign>

<x-backend-form-foreign :resource="$resource ?? null" name="line_id"
    foreign="lines" :values="$lines" foreign-add-label="products-catalog::lines.add"

    label="{{ __('products-catalog::product.line_id.0') }} / {{ __('products-catalog::product.gama_id.0') }}"
    placeholder="products-catalog::product.line_id.optional"
    {{-- helper="products-catalog::product.line_id.?" --}}>

    <x-backend-form-foreign :resource="$resource ?? null" name="gama_id" secondary
        filtered-by="[name=line_id]" filtered-using="line"
        foreign="gamas" :values="$lines->pluck('gamas')->flatten()" foreign-add-label="products-catalog::gamas.add"

        label="products-catalog::product.gama_id.0"
        placeholder="products-catalog::product.gama_id.optional"
        {{-- helper="products-catalog::product.gama_id.?" --}} />

</x-backend-form-foreign>

<x-backend-form-foreign :resource="$resource ?? null" name="family_id"
    foreign="families" :values="$families" foreign-add-label="products-catalog::families.add"

    label="{{ __('products-catalog::product.family_id.0') }} / {{ __('products-catalog::product.sub_family_id.0') }}"
    placeholder="products-catalog::product.family_id.optional"
    {{-- helper="products-catalog::product.family_id.?" --}}>

    <x-backend-form-foreign :resource="$resource ?? null" name="sub_family_id" secondary
        filtered-by="[name=family_id]" filtered-using="family"
        foreign="subFamilies" :values="$families->pluck('subFamilies')->flatten()" foreign-add-label="products-catalog::sub_families.add"

        label="products-catalog::product.sub_family_id.0"
        placeholder="products-catalog::product.sub_family_id.optional"
        {{-- helper="products-catalog::product.sub_family_id.?" --}} />

</x-backend-form-foreign>

<x-backend-form-multiple name="categories"
    :values="$categories" :selecteds="isset($resource) ? $resource->categories : []"
    contents-view="products-catalog::products.form.category"

    label="products-catalog::product.categories.0" />

<x-backend-form-textarea :resource="$resource ?? null"
    name="brief" wysiwyg
    label="products-catalog::product.brief.0"
    placeholder="products-catalog::product.brief.optional" />

<x-backend-form-textarea :resource="$resource ?? null"
    name="description" wysiwyg
    label="products-catalog::product.description.0"
    placeholder="products-catalog::product.description.optional" />

<x-backend-form-select :resource="$resource ?? null" name="tax" required
    :values="Product::TAXES"
    field="taxRaw"
    default="10i"
    label="products-catalog::product.tax.0"
    placeholder="products-catalog::product.tax._"
    {{-- helper="products-catalog::product.tax.?" --}} />

<x-backend-form-number :resource="$resource ?? null"
    name="weight"
    label="products-catalog::product.weight.0"
    placeholder="products-catalog::product.weight.optional" />

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 col-lg-2 control-label mb-0">@lang('products-catalog::product.sizes.0')</label>
    <div class="col-3 col-lg-4">
        <div class="form-row">
            <div class="col-4">
                <input name="length" type="number" min="0" step="0.01"
                    value="{{ isset($resource) && !old('length') ? $resource->length : old('length') }}"
                    class="form-control {{ $errors->has('length') ? 'is-danger' : '' }}"
                    placeholder="@lang('products-catalog::product.length.optional')">
            </div>
            <div class="col-4">
                <input name="width" type="number" min="0" step="0.01"
                    value="{{ isset($resource) && !old('width') ? $resource->width : old('width') }}"
                    class="form-control {{ $errors->has('width') ? 'is-danger' : '' }}"
                    placeholder="@lang('products-catalog::product.width.optional')">
            </div>
            <div class="col-4">
                <input name="height" type="number" min="0" step="0.01"
                    value="{{ isset($resource) && !old('height') ? $resource->height : old('height') }}"
                    class="form-control {{ $errors->has('height') ? 'is-danger' : '' }}"
                    placeholder="@lang('products-catalog::product.height.optional')">
            </div>
        </div>
    </div>
</div>

<x-backend-form-boolean :resource="$resource ?? null"
    name="giftcard"
    label="products-catalog::product.giftcard.0"
    placeholder="products-catalog::product.giftcard._" />

<x-backend-form-image :resource="$resource ?? null" :images="$images"
    name="images" multiple
    label="products-catalog::product.images.0"
    placeholder="products-catalog::product.images.optional" />

{{-- <x-backend-form-text :resource="$resource ?? null"
    name="url"
    label="products-catalog::product.url.0"
    prepend="{{ url('/') }}/"
    placeholder="products-catalog::product.url.optional" /> --}}

<x-backend-form-multiple name="tags"
    :values="$tags" :selecteds="isset($resource) ? $resource->tags : []"
    contents-view="products-catalog::products.form.tag"

    label="products-catalog::product.tags.0" />

<x-backend-form-multiple name="locators" values-as="warehouses"
    :values="$warehouses" :selecteds="isset($resource) ? $resource->locators : []"
    grouped old-filter-fields="warehouse_id,locator_id"
    contents-view="products-catalog::products.form.locator" contents-size="lg"
    {{-- row-class="mb-0" container-class="mb-1" --}}

    label="products-catalog::product.locators.0" />

{{-- <x-backend-form-boolean :resource="$resource ?? null"
    name="visible"
    label="products-catalog::product.visible.0"
    placeholder="products-catalog::product.visible._" /> --}}

<x-backend-form-number :resource="$resource ?? null"
    name="priority"
    label="products-catalog::product.priority.0"
    placeholder="products-catalog::product.priority.optional" />

<x-backend-form-controls
    submit="products-catalog::products.save"
    cancel="products-catalog::products.cancel" cancel-route="backend.products" />
