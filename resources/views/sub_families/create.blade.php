@extends('backend::layouts.master')

@section('page-name', __('products-catalog::sub_families.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-subfamily-plus"></i>
                @lang('products-catalog::sub_families.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.sub_families.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog::sub_families.add')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.sub_families.store') }}" enctype="multipart/form-data">
            @csrf
            @onlyform
            @include('products-catalog::sub_families.form')
        </form>
    </div>
</div>

@endsection
