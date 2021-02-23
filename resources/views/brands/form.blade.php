@include('backend::components.errors')

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog/brand.name.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="name" type="text" required
            value="{{ isset($resource) && !old('name') ? $resource->name : old('name') }}"
            class="form-control {{ $errors->has('name') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog/brand.name._')">
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('products-catalog/brand.name.?')"></i>
    </div> --}}
    {{-- <label class="col-12 control-label small">@lang('products-catalog/brand.name.?')</label> --}}
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog/brand.logo_id.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <div class="input-group">

            <select name="logo_id"
                value="{{ isset($resource) && !old('logo_id') ? $resource->logo_id : old('logo_id') }}"
                data-preview="#image_preview" class="form-control selectpicker {{ $errors->has('logo_id') ? 'is-danger' : '' }}"
                placeholder="@lang('products-catalog/brand.logo_id._')">
                <option value="" selected>@lang('products-catalog/brand.logo_id._')</option>
                @foreach($images as $image)
                <option value="{{ $image->id }}" url="{{ $image->url }}"
                    {{ (isset($resource) && !old('logo_id') ? $resource->logo_id : old('logo_id')) == $image->id ? 'selected' : '' }}>{{ $image->name }}</option>
                @endforeach
            </select>

            <div class="input-group-append">
                <label class="btn btn-outline-primary mb-0" for="upload">
                    <span class="fas fa-fw fa-cloud-upload-alt"></span>
                    <input type="file" name="image" accept="image/*" id="upload"
                        class="d-none" data-preview="#image_preview">
                </label>
            </div>
        </div>
    </div>
    <div class="col-6 offset-3 d-flex justify-content-center">
        <img src="#" id="image_preview" class="my-1 mh-300px rounded" style="display: none;">
    </div>
</div>

{{-- <div class="form-row form-group">
    <label class="col-3 control-label">Mostrar en Home ?</label>
    <div class="col-3">
        <div class="form-check">
            <input name="show_home" type="checkbox" id="show_home"
                @if (isset($resource) && !old('show_home') ? $resource->show_home : old('show_home')) checked @endif
                class="form-check-input {{ $errors->has('show_home') ? 'is-danger' : '' }}" placeholder="Mostrar en Home ?">
            <label for="show_home" class="form-check-label">Si, mostrar esta Marca en la Home</label>
        </div>
    </div>
</div> --}}

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog/brand.priority.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="priority" type="number"
            value="{{ isset($resource) && !old('priority') ? $resource->priority : old('priority') }}"
            class="form-control {{ $errors->has('priority') ? 'is-danger' : '' }}" placeholder="@lang('products-catalog/brand.priority._')">
    </div>
    {{-- <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
        title="@lang('products-catalog/brand.priority.?')"></i> --}}
</div>

<div class="form-row">
    <div class="offset-0 offset-md-3 col-12 col-md-9">
        <button type="submit" class="btn btn-success">@lang('products-catalog/brand.save')</button>
        <a href="{{ route('backend.brands') }}" class="btn btn-danger">@lang('products-catalog/brand.cancel')</a>
    </div>
</div>
