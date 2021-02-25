@include('backend::components.errors')

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog/gama.line_id.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <select name="line_id" data-live-search="true" required
            value="{{ isset($resource) && !old('line_id') ? $resource->line_id : old('line_id') }}"
            class="form-control selectpicker {{ $errors->has('line_id') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog/gama.line_id._')">
            <option value="" selected disabled hidden>@lang('products-catalog/gama.line_id.0')</option>
            @foreach($lines as $line)
            <option value="{{ $line->id }}"
                @if (isset($resource) && !old('line_id') && $resource->line_id == $line->id ||
                    old('line_id') == $line->id) selected @endif>{{ $line->name }}</option>
            @endforeach
        </select>
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('products-catalog/gama.line_id.?')"></i>
    </div> --}}
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog/gama.name.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="name" type="text" required
            value="{{ isset($resource) && !old('name') ? $resource->name : old('name') }}"
            class="form-control {{ $errors->has('name') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog/gama.name._')">
    </div>
</div>

<div class="form-row">
    <div class="offset-0 offset-md-3 col-12 col-md-9">
        <button type="submit" class="btn btn-success">@lang('products-catalog/gama.save')</button>
        <a href="{{ route('backend.gamas') }}" class="btn btn-danger">@lang('products-catalog/gama.cancel')</a>
    </div>
</div>
