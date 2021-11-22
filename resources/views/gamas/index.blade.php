@extends('backend::layouts.master')

@section('page-name', __('products-catalog::gamas.title'))
@section('description', __('products-catalog::gamas.description'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center cursor-pointer"
                data-toggle="collapse" data-target="#filters">
                <i class="fas fa-table mr-2"></i>
                @lang('products-catalog::gamas.index')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.gamas.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('products-catalog::gamas.create')</a>
            </div>
        </div>
        <div class="row collapse @if (request()->has('filters')) show @endif" id="filters">
            <form action="{{ route('backend.gamas') }}"
                class="col mt-2 pt-3 pb-2 border-top">

                <x-backend-form-foreign name="filters[line]"
                    :values="$lines" default="{{ request('filters.line') }}"

                    label="products-catalog::gama.line_id.0"
                    placeholder="products-catalog::gama.line_id._"
                    {{-- helper="products-catalog::gama.line_id.?" --}} />

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
                    'resource'  => 'gamas',
                    'actions'   => [ 'update', 'delete' ],
                    'label'     => '{resource.name}',
                ])
            </div>
        @else
            <div class="text-center m-t-30 m-b-30 p-b-10">
                <h2><i class="fas fa-table text-custom"></i></h2>
                <h3>@lang('backend.empty.title')</h3>
                <p class="text-muted">
                    @lang('backend.empty.description')
                    <a href="{{ route('backend.gamas.create') }}" class="text-custom">
                        <ins>@lang('products-catalog::gamas.create')</ins>
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
