@extends('backend::layouts.master')

@section('page-name', __('products-catalog/category.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-category-plus"></i>
                @lang('products-catalog/category.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.categories.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog/category.add')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.categories.store') }}" enctype="multipart/form-data">
            @csrf
            @include('products-catalog::categories.form')
        </form>
    </div>
</div>

@endsection