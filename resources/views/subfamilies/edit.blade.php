@extends('backend::layouts.master')

@section('page-name', __('products-catalog/subfamily.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-subfamily-plus"></i>
                @lang('products-catalog/subfamily.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.subfamilies.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog/subfamily.add')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.subfamilies.update', $resource->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @include('products-catalog::subfamilies.form')
        </form>
    </div>
</div>

@endsection