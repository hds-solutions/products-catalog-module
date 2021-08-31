@extends('backend::layouts.master')

@section('page-name', __('products-catalog::sub_families.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <i class="fas fa-subfamily-plus"></i>
                @lang('products-catalog::sub_families.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.sub_families.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('products-catalog::sub_families.create')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.sub_families.update', $resource) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('products-catalog::sub_families.form')
        </form>
    </div>
</div>

@endsection
