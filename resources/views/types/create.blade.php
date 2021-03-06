@extends('backend::layouts.master')

@section('page-name', __('products-catalog::types.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-type-plus"></i>
                @lang('products-catalog::types.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.types.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog::types.add')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.types.store') }}" enctype="multipart/form-data">
            @csrf
            @onlyform
            @include('products-catalog::types.form')
        </form>
    </div>
</div>

@endsection