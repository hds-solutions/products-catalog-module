@extends('backend::layouts.master')

@section('page-name', __('products-catalog::lines.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <i class="fas fa-line-plus"></i>
                @lang('products-catalog::lines.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.lines.create') }}"
                    class="btn btn-sm btn-outline-primary">@lang('products-catalog::lines.create')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.lines.store') }}" enctype="multipart/form-data">
            @csrf
            @onlyform
            @include('products-catalog::lines.form')
        </form>
    </div>
</div>

@endsection
