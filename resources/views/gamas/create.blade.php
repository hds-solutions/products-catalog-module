@extends('backend::layouts.master')

@section('page-name', __('products-catalog::gamas.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <i class="fas fa-gama-plus"></i>
                @lang('products-catalog::gamas.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.gamas.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('products-catalog::gamas.create')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.gamas.store') }}" enctype="multipart/form-data">
            @csrf
            @onlyform
            @include('products-catalog::gamas.form')
        </form>
    </div>
</div>

@endsection
