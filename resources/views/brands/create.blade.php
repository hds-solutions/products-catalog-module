@extends('backend::layouts.master')

@section('page-name', __('products-catalog::brands.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <i class="fas fa-brand-plus"></i>
                @lang('products-catalog::brands.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.brands.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('products-catalog::brands.create')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.brands.store') }}" enctype="multipart/form-data">
            @csrf
            @onlyform
            @include('products-catalog::brands.form')
        </form>
    </div>
</div>

@endsection
