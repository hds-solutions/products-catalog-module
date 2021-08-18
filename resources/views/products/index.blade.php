@extends('backend::layouts.master')

@section('page-name', __('products-catalog::products.title'))
@section('description', __('products-catalog::products.description'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center cursor-pointer"
                data-toggle="collapse" data-target="#filters">
                <i class="fas fa-table mr-2"></i>
                @lang('products-catalog::products.index')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.products.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('products-catalog::products.create')</a>
            </div>
        </div>
        <div class="row collapse @if (request()->has('filters')) show @endif" id="filters">
            <form action="{{ route('backend.products') }}"
                class="col mt-2 pt-3 pb-2 border-top">

                <x-backend-form-foreign name="filters[type]"
                    :values="$types" default="{{ request('filters.type') }}"

                    label="products-catalog::product.type_id.0"
                    placeholder="products-catalog::product.type_id._"
                    {{-- helper="products-catalog::product.type_id.?" --}} />

                <x-backend-form-foreign name="filters[brand]"
                    :values="$brands" default="{{ request('filters.brand') }}"

                    label="products-catalog::product.brand_id.0"
                    placeholder="products-catalog::product.brand_id._"
                    {{-- helper="products-catalog::product.brand_id.?" --}}>

                    <x-backend-form-foreign name="filters[model]" secondary
                        :values="$brands->pluck('models')->flatten()" default="{{ request('filters.model') }}"

                        filtered-by='[name="filters[brand]"]' filtered-using="brand"

                        label="products-catalog::product.model_id.0"
                        placeholder="products-catalog::product.model_id._"
                        {{-- helper="products-catalog::product.model_id.?" --}} />

                </x-backend-form-foreign>

                <x-backend-form-foreign name="filters[family]"
                    :values="$families" default="{{ request('filters.family') }}"

                    label="products-catalog::product.family_id.0"
                    placeholder="products-catalog::product.family_id._"
                    {{-- helper="products-catalog::product.family_id.?" --}}>

                    <x-backend-form-foreign name="filters[sub_family]" secondary
                        :values="$families->pluck('subFamilies')->flatten()" default="{{ request('filters.sub_family') }}"

                        filtered-by='[name="filters[family]"]' filtered-using="family"

                        label="products-catalog::product.sub_family_id.0"
                        placeholder="products-catalog::product.sub_family_id._"
                        {{-- helper="products-catalog::product.sub_family_id.?" --}} />

                </x-backend-form-foreign>

                <x-backend-form-foreign name="filters[line]"
                    :values="$lines" default="{{ request('filters.line') }}"

                    label="products-catalog::product.line_id.0"
                    placeholder="products-catalog::product.line_id._"
                    {{-- helper="products-catalog::product.line_id.?" --}}>

                    <x-backend-form-foreign name="filters[gama]" secondary
                        :values="$lines->pluck('gamas')->flatten()" default="{{ request('filters.gama') }}"

                        filtered-by='[name="filters[line]"]' filtered-using="line"

                        label="products-catalog::product.gama_id.0"
                        placeholder="products-catalog::product.gama_id._"
                        {{-- helper="products-catalog::product.gama_id.?" --}} />

                </x-backend-form-foreign>

                <button type="submit"
                    class="btn btn-sm btn-outline-primary">Filtrar</button>

                <button type="reset"
                    class="btn btn-sm btn-outline-secondary btn-hover-danger">Limpiar filtros</button>
            </form>
        </div>
    </div>
    <div class="card-body">
        @if ($count)
            <div class="table-responsive">
                {{ $dataTable->table() }}
                @include('backend::components.datatable-actions', [
                    'actions'   => [ 'visible', 'update', 'delete' ],
                    'label'     => '{resource.name}',
                ])
            </div>
        @else
            <div class="text-center m-t-30 m-b-30 p-b-10">
                <h2><i class="fas fa-table text-custom"></i></h2>
                <h3>@lang('backend.empty.title')</h3>
                <p class="text-muted">
                    @lang('backend.empty.description')
                    <a href="{{ route('backend.products.create') }}" class="text-custom">
                        <ins>@lang('products-catalog::products.create')</ins>
                    </a>
                </p>
            </div>
        @endif
    </div>
</div>

@endsection

@push('config-scripts')
{{ $dataTable->scripts() }}
@endpush
