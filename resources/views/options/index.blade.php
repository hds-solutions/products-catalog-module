@extends('backend::layouts.master')

@section('page-name', __('products-catalog::options.title'))
@section('description', __('products-catalog::options.description'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <i class="fas fa-table mr-2"></i>
                @lang('products-catalog::options.index')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.options.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('products-catalog::options.create')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if ($count)
            <div class="table-responsive">
                {{ $dataTable->table() }}
                @include('backend::components.datatable-actions', [
                    'resource'  => 'options',
                    'actions'   => [ 'update', 'delete' ],
                    'label'     => '{resource.label}',
                ])
            </div>
        @else
            <div class="text-center m-t-30 m-b-30 p-b-10">
                <h2><i class="fas fa-table text-custom"></i></h2>
                <h3>@lang('backend.empty.title')</h3>
                <p class="text-muted">
                    @lang('backend.empty.description')
                    <a href="{{ route('backend.options.create') }}" class="text-custom">
                        <ins>@lang('products-catalog::options.create')</ins>
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
