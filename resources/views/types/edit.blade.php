@extends('backend::layouts.master')

@section('page-name', __('products-catalog::types.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <i class="fas fa-type-plus"></i>
                @lang('products-catalog::types.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.types.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('products-catalog::types.create')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.types.update', $resource) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('products-catalog::types.form')
        </form>
    </div>
</div>

@endsection
