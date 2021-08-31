@include('backend::components.errors')

<x-backend-form-foreign :resource="$resource ?? null" name="family_id" required
    foreign="families" :values="$families" foreign-add-label="products-catalog::families.add"
    request="family" :readonly="request()->has('family')"

    label="products-catalog::sub_family.family_id.0"
    placeholder="products-catalog::sub_family.family_id._"
    {{-- helper="products-catalog::sub_family.family_id.?" --}} />

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="products-catalog::sub_family.name.0"
    placeholder="products-catalog::sub_family.name._" />

<x-backend-form-controls
    submit="products-catalog::sub_families.save"
    cancel="products-catalog::sub_families.cancel" cancel-route="backend.sub_families" />
