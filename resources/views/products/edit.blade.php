@extends('backend::layouts.master')

@section('page-name', __('products-catalog::products.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-products-plus"></i>
                @lang('products-catalog::products.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.products.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog::products.create')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.products.update', $resource) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @include('products-catalog::products.form')
        </form>
    </div>
</div>

@endsection
