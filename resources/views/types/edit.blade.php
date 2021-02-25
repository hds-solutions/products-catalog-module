@extends('backend::layouts.master')

@section('page-name', __('products-catalog/type.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-type-plus"></i>
                @lang('products-catalog/type.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.types.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog/type.add')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.types.update', $resource->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @include('products-catalog::types.form')
        </form>
    </div>
</div>

@endsection