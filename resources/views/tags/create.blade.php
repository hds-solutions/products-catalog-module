@extends('backend::layouts.master')

@section('page-name', __('products-catalog/tag.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-tag-plus"></i>
                @lang('products-catalog/tag.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.tags.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog/tag.add')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.tags.store') }}" enctype="multipart/form-data">
            @csrf
            @include('products-catalog::tags.form')
        </form>
    </div>
</div>

@endsection