@extends('backend::layouts.master')

@section('page-name', __('products-catalog::subfamilies.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-subfamily-plus"></i>
                @lang('products-catalog::subfamilies.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.subfamilies.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog::subfamilies.add')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.subfamilies.store') }}" enctype="multipart/form-data">
            @csrf
            @include('products-catalog::subfamilies.form')
        </form>
    </div>
</div>

@endsection