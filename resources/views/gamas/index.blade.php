@extends('backend::layouts.master')

@section('page-name', __('products-catalog/gama.title'))
@section('description', __('products-catalog/gama.description'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-table"></i>
                @lang('products-catalog/gama.index')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.gamas.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog/gama.add')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if ($count)
            <div class="table-responsive">
                {{
                    $dataTable->table([
                        'class'         => 'table table-bordered',
                        'data-route'    => route('backend.gamas'),
                        'data-columns'  => $dataTable->getColumns()->map(fn($item) => [ 'data' => $item->data])->toJson(),
                    ])
                }}

                @include('backend::components.datatable-actions', [
                    'actions'   => [ 'update', 'delete' ]
                ])
            </div>
        @else
            <div class="text-center m-t-30 m-b-30 p-b-10">
                <h2><i class="fas fa-table text-custom"></i></h2>
                <h3>@lang('backend.empty.title')</h3>
                <p class="text-muted">
                    @lang('backend.empty.description')
                    <a href="{{ route('backend.gamas.create') }}" class="text-custom">
                        <ins>@lang('products-catalog/gama.add')</ins>
                    </a>
                </p>
            </div>
        @endif
    </div>
</div>

@endsection
