@extends('backend::layouts.master')

@section('page-name', __('products-catalog::families.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <i class="fas fa-family-plus"></i>
                @lang('products-catalog::families.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.families.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('products-catalog::families.create')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.families.update', $resource) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('products-catalog::families.form')
        </form>
    </div>
</div>

@endsection
