@extends('backend::layouts.master')

@section('page-name', __('products-catalog/brand.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-brand-plus"></i>
                @lang('products-catalog/brand.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.brands.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog/brand.add')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.brands.update', $resource->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @include('products-catalog::brands.form')
        </form>
    </div>
</div>

@endsection