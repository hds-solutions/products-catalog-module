@extends('backend::layouts.master')

@section('page-name', __('products-catalog/family.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-family-plus"></i>
                @lang('products-catalog/family.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.families.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog/family.add')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.families.update', $resource->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @include('products-catalog::families.form')
        </form>
    </div>
</div>

@endsection