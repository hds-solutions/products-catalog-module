@extends('backend::layouts.master')

@section('page-name', __('products-catalog::variants.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-variants-plus"></i>
                @lang('products-catalog::variants.create')
            </div>
            <div class="col-6 d-flex justify-content-end">
                {{-- <a href="{{ route('backend.variants.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog::variants.add')</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.variants.store') }}" enctype="multipart/form-data">
            @csrf
            @include('products-catalog::variants.form')
        </form>
    </div>
</div>

@endsection