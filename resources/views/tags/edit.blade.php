@extends('backend::layouts.master')

@section('page-name', __('products-catalog::tags.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <i class="fas fa-tag-plus"></i>
                @lang('products-catalog::tags.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.tags.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('products-catalog::tags.create')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.tags.update', $resource) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('products-catalog::tags.form')
        </form>
    </div>
</div>

@endsection
