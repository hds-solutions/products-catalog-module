@include('backend::components.errors')

<x-backend-form-foreign :resource="$resource ?? null" name="line_id" required
    foreign="lines" :values="$lines" foreign-add-label="products-catalog::lines.add"
    request="line" :readonly="request()->has('line')"
    data-live-search="true"

    label="products-catalog::gama.line_id.0"
    placeholder="products-catalog::gama.line_id._"
    {{-- helper="products-catalog::gama.line_id.?" --}} />

<x-backend-form-text :resource="$resource ?? null" name="name" required
    label="products-catalog::gama.name.0"
    placeholder="products-catalog::gama.name._" />

<x-backend-form-controls
    submit="products-catalog::gamas.save"
    cancel="products-catalog::gamas.cancel" cancel-route="backend.gamas" />
