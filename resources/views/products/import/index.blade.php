@extends('backend::layouts.master')

@section('page-name', __('products-catalog::products.import.title'))
@section('description', __('products-catalog::products.import.description'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-table"></i>
                @lang('products-catalog::products.import.index')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.products.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog::products.create')</a>
            </div>
        </div>
    </div>
    <div class="card-body">

        <form method="POST" action="{{ route('backend.products.import') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-row form-group align-items-center">
                <label class="col-12 col-md-3 col-lg-2">@lang('products-catalog::products.import.file._')</label>
                <div class="col-12 col-md-8 col-lg-6">

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="import-name">Excel</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="import" required
                                class="custom-file-input" id="import-file" aria-describedby="import-name">
                            <label class="custom-file-label" for="import-file" data-show-file-name="true">@lang('products-catalog::products.import.file._')</label>
                        </div>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary" id="import-label">@lang('products-catalog::products.import.save-create')</button>
                        </div>
                    </div>

                </div>
            </div>

        </form>

    </div>
</div>


@endsection
