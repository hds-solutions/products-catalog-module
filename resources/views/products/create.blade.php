@extends('backend::layouts.master')

@section('page-name', __('products-catalog::products.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-product-plus"></i>
                @lang('products-catalog::products.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.products.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog::products.create')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.products.store') }}" enctype="multipart/form-data">
            @csrf
            @onlyform
            @include('products-catalog::products.form')
        </form>
    </div>
</div>

@endsection
