@extends('backend::layouts.master')

@section('page-name', __('products-catalog/gama.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-gama-plus"></i>
                @lang('products-catalog/gama.edit')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.gamas.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog/gama.add')</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.gamas.update', $resource->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @include('products-catalog::gamas.form')
        </form>
    </div>
</div>

@endsection