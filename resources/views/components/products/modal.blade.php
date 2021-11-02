<div class="modal fade" id="products-modal" tabindex="-1" role="dialog" aria-labelledby="products-modal-title" aria-hidden="true">
    <div class="modal-xl modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content vh-75">

            <div class="modal-header bg-light p-0 border-0">
                <div class="container-fluid px-3">

                    <div class="row py-2 border-bottom">
                        <div class="col d-flex align-items-center">
                            <i class="fas fa-search mr-2"></i>
                            @lang('products-catalog::products.title')
                        </div>
                        <div class="col d-flex align-items-center justify-content-end">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" tabindex="-1">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('backend.products') }}" autocomplete="off"
                        data-filters-for="#{{ $dataTable->getTableAttribute('id') }}"
                        data-modal="#products-modal" class="row py-2">
                        <input type="text" name="autocomplete" autocomplete="false" class="d-none">

                        <div class="col">

                            <x-backend-form-text name="filters[code]"
                                row-class="mb-1"
                                label="products-catalog::product.sku.0"
                                placeholder="products-catalog::product.sku._" />

                            <x-backend-form-foreign name="filters[type]"
                                :values="$types"
                                data-live-search="true"

                                label="products-catalog::product.type_id.0"
                                placeholder="products-catalog::product.type_id._"
                                row-class="mb-1"
                                {{-- helper="products-catalog::product.type_id.?" --}} />

                            <x-backend-form-foreign name="filters[brand]"
                                :values="$brands"
                                data-live-search="true"

                                label="products-catalog::product.brand_id.0"
                                placeholder="products-catalog::product.brand_id._"
                                row-class="mb-1"
                                {{-- helper="products-catalog::product.brand_id.?" --}}>

                                <x-backend-form-foreign name="filters[model]" secondary
                                    :values="$brands->pluck('models')->flatten()"
                                    data-live-search="true"

                                    filtered-by='[name="filters[brand]"]' filtered-using="brand"

                                    label="products-catalog::product.model_id.0"
                                    placeholder="products-catalog::product.model_id._"
                                    {{-- helper="products-catalog::product.model_id.?" --}} />

                            </x-backend-form-foreign>

                            <x-backend-form-foreign name="filters[family]"
                                :values="$families"
                                data-live-search="true"

                                label="products-catalog::product.family_id.0"
                                placeholder="products-catalog::product.family_id._"
                                row-class="mb-1"
                                {{-- helper="products-catalog::product.family_id.?" --}}>

                                <x-backend-form-foreign name="filters[sub_family]" secondary
                                    :values="$families->pluck('subFamilies')->flatten()"
                                    data-live-search="true"

                                    filtered-by='[name="filters[family]"]' filtered-using="family"

                                    label="products-catalog::product.sub_family_id.0"
                                    placeholder="products-catalog::product.sub_family_id._"
                                    {{-- helper="products-catalog::product.sub_family_id.?" --}} />

                            </x-backend-form-foreign>

                            <x-backend-form-foreign name="filters[line]"
                                :values="$lines"
                                data-live-search="true"

                                label="products-catalog::product.line_id.0"
                                placeholder="products-catalog::product.line_id._"
                                row-class="mb-0"
                                {{-- helper="products-catalog::product.line_id.?" --}}>

                                <x-backend-form-foreign name="filters[gama]" secondary
                                    :values="$lines->pluck('gamas')->flatten()"
                                    data-live-search="true"

                                    filtered-by='[name="filters[line]"]' filtered-using="line"

                                    label="products-catalog::product.gama_id.0"
                                    placeholder="products-catalog::product.gama_id._"
                                    {{-- helper="products-catalog::product.gama_id.?" --}} />

                            </x-backend-form-foreign>

                            <button type="submit" class="d-none"></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-body p-0">
                {{ $dataTable->table() }}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Seleccionar</button>
            </div>

        </div>
    </div>
</div>

@push('config-scripts')
{{ $dataTable->scripts() }}
@endpush
