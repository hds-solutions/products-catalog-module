@extends('backend::layouts.master')

@section('page-name', __('products-catalog::options.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-option-plus"></i>
                @lang('products-catalog::options.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.options.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog::options.add')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.options.update', $resource->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @include('products-catalog::options.form')
        </form>
    </div>
</div>

@endsection