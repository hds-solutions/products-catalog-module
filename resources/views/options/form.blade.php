@include('backend::components.errors')

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::option.name.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="name" type="text" required
            value="{{ isset($resource) && !old('name') ? $resource->name : old('name') }}"
            class="form-control {{ $errors->has('name') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog::option.name._')">
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('products-catalog::option.name.?')"></i>
    </div> --}}
    {{-- <label class="col-12 control-label small">@lang('products-catalog::option.name.?')</label> --}}
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::option.label.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="label" type="text"
            value="{{ isset($resource) && !old('label') ? $resource->label : old('label') }}"
            class="form-control {{ $errors->has('label') ? 'is-danger' : '' }}"
            placeholder="(@lang('optional')) @lang('products-catalog::option.label._')">
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('products-catalog::option.label.?')"></i>
    </div> --}}
    {{-- <label class="col-12 control-label small">@lang('products-catalog::option.label.?')</label> --}}
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::option.value_type.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <select name="value_type" required
            value="{{ isset($resource) && !old('value_type') ? $resource->value_type : old('value_type') }}"
            class="form-control selectpicker {{ $errors->has('value_type') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog::option.value_type._')">
            <option value="" selected disabled hidden>@lang('products-catalog::option.value_type.0')</option>
            @foreach([
                'text'  => __('Text'),
                'color' => __('Color'),
                'image' => __('Image'),
            ] as $value_type => $name)
            <option value="{{ $value_type }}"
                @if (isset($resource) && !old('value_type') && $resource->value_type == $value_type ||
                    old('value_type') == $value_type ||
                    (!isset($resource) && !old('value_type') && $value_type == 'text')) selected @endif>{{ $name }}</option>
            @endforeach
        </select>
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('products-catalog::option.value_type.?')"></i>
    </div> --}}
    {{-- <label class="col-12 control-label small">@lang('products-catalog::option.value_type.?')</label> --}}
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::option.show.0')</label>
    <div class="col-3">
        <div class="form-check">
            <input type="hidden" name="show" value="{{ (isset($resource) && !old('show') ? $resource->show : old('show')) ? 'true' : 'false' }}">
            <input type="checkbox" id="show"
                onchange="this.previousElementSibling.value = this.checked ? 'true' : 'false'"
                @if (isset($resource) && !old('show') ? $resource->show : old('show')) checked @endif
                class="form-check-input {{ $errors->has('show') ? 'is-danger' : '' }}" placeholder="@lang('products-catalog::option.show._')">
            <label for="show" class="form-check-label">@lang('products-catalog::option.show._')</label>
        </div>
    </div>
</div>

<div class="form-row form-group d-flex">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::option.values.0')</label>
    <div class="col-9">
        <div class="row" data-multiple=".option-value-container" data-template="#new">
            @if (isset($resource))
            @foreach($resource->values as $value)
                @include('products-catalog::options.option_value', compact('value'))
            @endforeach
            @endif
            {{-- add empty for adding new options --}}
            @include('products-catalog::options.option_value', [ 'value' => null ])
        </div>
    </div>
</div>

<div class="form-row">
    <div class="offset-0 offset-md-3 col-12 col-md-9">
        <button type="submit" class="btn btn-success">@lang('products-catalog::options.save')</button>
        <a href="{{ route('backend.options') }}" class="btn btn-danger">@lang('products-catalog::options.cancel')</a>
    </div>
</div>
