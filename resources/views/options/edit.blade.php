@extends('backend::layouts.master')

@section('page-name', __('products-catalog::options.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <i class="fas fa-option-plus"></i>
                @lang('products-catalog::options.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.options.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('products-catalog::options.create')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.options.update', $resource) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('products-catalog::options.form')
        </form>
    </div>
</div>

@endsection
