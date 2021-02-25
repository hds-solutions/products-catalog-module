@include('backend::components.errors')

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog/type.name.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="name" type="text" required
            value="{{ isset($resource) && !old('name') ? $resource->name : old('name') }}"
            class="form-control {{ $errors->has('name') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog/type.name._')">
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('products-catalog/type.name.?')"></i>
    </div> --}}
    {{-- <label class="col-12 control-label small">@lang('products-catalog/type.name.?')</label> --}}
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog/type.sold.0')</label>
    <div class="col-3">
        <div class="form-check">
            <input type="hidden" name="sold" value="{{ (isset($resource) && !old('sold') ? $resource->sold : old('sold')) ? 'true' : 'false' }}">
            <input type="checkbox" id="sold"
                onchange="this.previousElementSibling.value = this.checked ? 'true' : 'false'"
                @if (isset($resource) && !old('sold') ? $resource->sold : old('sold')) checked @endif
                class="form-check-input {{ $errors->has('sold') ? 'is-danger' : '' }}" placeholder="@lang('products-catalog/type.sold._')">
            <label for="sold" class="form-check-label">@lang('products-catalog/type.sold._')</label>
        </div>
    </div>
</div>

<div class="form-row form-group d-flex">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog/type.options.0')</label>
    <div class="col-9">
        <div class="row" data-multiple=".type-option-container" data-template="#new">
            @if (isset($resource))
            @foreach($resource->options as $selected)
                @include('products-catalog::types.option', compact('options', 'selected'))
            @endforeach
            @endif
            {{-- add empty for adding new options --}}
            @include('products-catalog::types.option', [
                'options'  => $options,
                'selected' => null,
            ])
        </div>
    </div>
</div>

<div class="form-row">
    <div class="offset-0 offset-md-3 col-12 col-md-9">
        <button type="submit" class="btn btn-success">@lang('products-catalog/type.save')</button>
        <a href="{{ route('backend.types') }}" class="btn btn-danger">@lang('products-catalog/type.cancel')</a>
    </div>
</div>
