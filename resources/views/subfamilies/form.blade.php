@include('backend::components.errors')

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::subfamily.family_id.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <select name="family_id" data-live-search="true" required
            value="{{ isset($resource) && !old('family_id') ? $resource->family_id : old('family_id') }}"
            class="form-control selectpicker {{ $errors->has('family_id') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog::subfamily.family_id._')">
            <option value="" selected disabled hidden>@lang('products-catalog::subfamily.family_id.0')</option>
            @foreach($lines as $line)
            <option value="{{ $line->id }}"
                @if (isset($resource) && !old('family_id') && $resource->family_id == $line->id ||
                    old('family_id') == $line->id) selected @endif>{{ $line->name }}</option>
            @endforeach
        </select>
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('products-catalog::subfamily.family_id.?')"></i>
    </div> --}}
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::subfamily.name.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="name" type="text" required
            value="{{ isset($resource) && !old('name') ? $resource->name : old('name') }}"
            class="form-control {{ $errors->has('name') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog::subfamily.name._')">
    </div>
</div>

<div class="form-row">
    <div class="offset-0 offset-md-3 col-12 col-md-9">
        <button type="submit" class="btn btn-success">@lang('products-catalog::subfamilies.save')</button>
        <a href="{{ route('backend.subfamilies') }}" class="btn btn-danger">@lang('products-catalog::subfamilies.cancel')</a>
    </div>
</div>
