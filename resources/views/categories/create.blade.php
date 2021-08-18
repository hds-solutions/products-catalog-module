@extends('backend::layouts.master')

@section('page-name', __('products-catalog::categories.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <i class="fas fa-category-plus"></i>
                @lang('products-catalog::categories.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.categories.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('products-catalog::categories.create')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.categories.store') }}" enctype="multipart/form-data">
            @csrf
            @onlyform
            @include('products-catalog::categories.form')
        </form>
    </div>
</div>

@endsection
