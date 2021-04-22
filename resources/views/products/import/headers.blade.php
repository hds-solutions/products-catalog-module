@extends('backend::layouts.master')

@section('page-name', __('products-catalog::products.import.title'))

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-user-plus"></i>
                @lang('products-catalog::products.import.show')
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ route('backend.products.create') }}"
                    class="btn btn-sm btn-primary">@lang('products-catalog::products.create')</a>
            </div>
        </div>
    </div>
    <div class="card-body">

        @include('backend::components.errors')

        <div class="row">
            <div class="col">
                <h2>@lang('products-catalog::products.import.headers')</h2>
            </div>
        </div>

        <form method="POST" action="{{ route('backend.products.import.process', $import) }}">
            @csrf

            <x-backend-form-select name="sheet" required
                :values="$sheets->keys()"

                label="{{ 'products-catalog::products.import.sheet.0' }}"
                placeholder="{{ 'products-catalog::products.import.sheet._' }}"
                {{-- helper="{{ 'products-catalog::products.import.sheet.?' }}" --}} />

            @foreach ([
                'name'          => true,
                //'code'          => false,
                'sku'           => true,
                'type_id'       => true,
                //'description'   => false,
                'brand_id'      => false,
                'model_id'      => false,
                'family_id'     => false,
                'sub_family_id' => false,
                'line_id'       => false,
                'gama_id'       => false,
            ] as $field => $required)

            <div class="form-row form-group d-flex align-items-center">
                <label class="col-12 col-md-3 col-lg-2 control-label mb-0">@lang("products-catalog::product.$field.0")</label>
                <div class="col-11 col-md-8 col-lg-6 col-xl-4">

                    <select name="headers[{{ $field }}]" data-live-search="true" @if ($required) required @endif
                        data-filtered-by="[name=sheet]" data-filtered-using="sheet"
                        class="form-control selectpicker" data-none-selected-text="@lang("products-catalog::product.$field.".($required?'_':'optional'))">

                        <option value="" selected @if ($required) disabled hidden @endif>@lang("products-catalog::product.$field.".($required?'_':'optional'))</option>

                        @foreach ($sheets->values() as $sheet => $headers)
                            @foreach ($headers as $idx => $header)

                        <option value="{{ $idx }}" data-sheet="{{ $sheet }}">{{ $header }}</option>

                            @endforeach
                        @endforeach

                    </select>

                </div>
            </div>

            @endforeach

            <div class="form-row form-group d-flex align-items-center">
                <label class="col-12 col-md-3 col-lg-2 control-label mb-0">@lang("products-catalog::products.import.customs.0")</label>
                <div class="col-11 col-md-8 col-lg-6" data-multiple=".custom-field-container" data-template="#new">

                    <div class="form-row custom-field-container mb-2" id="new">
                        <div class="col-11">
                            <div class="form-row">

                                <div class="col-6">
                                    <select name="customs[header][]"
                                        data-filtered-by="[name=sheet]" data-filtered-using="sheet" data-filtered-keep-id="true"
                                        data-none-selected-text="@lang('products-catalog::products.import.custom._')"
                                        class="form-control selectpicker" placeholder="@lang('products-catalog::products.import.custom._')">

                                        <option value="" selected>@lang('products-catalog::products.import.custom.0')</option>

                                        @foreach ($sheets->values() as $sheet => $headers)
                                            @foreach ($headers as $idx => $header)

                                        <option value="{{ $idx }}" data-sheet="{{ $sheet }}">{{ $header }}</option>

                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6">
                                    <select name="customs[field][]"
                                        data-none-selected-text="@lang('products-catalog::products.import.field._')"
                                        class="form-control selectpicker" placeholder="@lang('products-catalog::products.import.field._')">

                                        <option value="" selected>@lang('products-catalog::products.import.field.0')</option>

                                        @foreach ([
                                            'type'      => __('products-catalog::product.type_id.0'),
                                            'line'      => __('products-catalog::product.line_id.0'),
                                            'family'    => __('products-catalog::product.family_id.0'),
                                        ] as $value => $name)

                                        <option value="{{ $value }}">{{ $name }}</option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>
                        </div>

                        <div class="col-1">
                            <button type="button" class="btn btn-danger ml-2"
                                data-action="delete">X</button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <input type="submit" class="btn btn-lg btn-primary" value="@lang('Import')">
                </div>
            </div>

        </form>

    </div>
</div>

@endsection
