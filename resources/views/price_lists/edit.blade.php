@extends('backend::layouts.master')

@section('page-name', __('products-catalog::price_lists.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <i class="fas fa-family-plus"></i>
                @lang('products-catalog::price_lists.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.price_lists.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('products-catalog::price_lists.create')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.price_lists.update', $resource) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('products-catalog::price_lists.form')
        </form>
    </div>
</div>

@endsection
