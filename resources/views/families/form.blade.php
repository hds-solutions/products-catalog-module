@include('backend::components.errors')

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::family.name.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="name" type="text" required
            value="{{ isset($resource) && !old('name') ? $resource->name : old('name') }}"
            class="form-control {{ $errors->has('name') ? 'is-danger' : '' }}"
            placeholder="@lang('products-catalog::family.name._')">
    </div>
    {{-- <div class="col-1">
        <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
            title="@lang('products-catalog::family.name.?')"></i>
    </div> --}}
    {{-- <label class="col-12 control-label small">@lang('products-catalog::family.name.?')</label> --}}
</div>

<div class="form-row form-group d-flex">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::family.options.0')</label>
    <div class="col-9">
        <div class="row" data-multiple=".family-option-container" data-template="#new">
            @if (isset($resource))
            @foreach($resource->options as $selected)
                @include('products-catalog::families.option', compact('options', 'selected'))
            @endforeach
            @endif
            {{-- add empty for adding new options --}}
            @include('products-catalog::families.option', [
                'options'  => $options,
                'selected' => null,
            ])
        </div>
    </div>
</div>

<div class="form-row form-group align-items-center">
    <label class="col-12 col-md-3 control-label mb-0">@lang('products-catalog::family.priority.0')</label>
    <div class="col-11 col-md-8 col-lg-6 col-xl-4">
        <input name="priority" type="number"
            value="{{ isset($resource) && !old('priority') ? $resource->priority : old('priority') }}"
            class="form-control {{ $errors->has('priority') ? 'is-danger' : '' }}" placeholder="@lang('products-catalog::family.priority._')">
    </div>
    {{-- <i class="fas fa-info-circle ml-2 cursor-help" data-toggle="tooltip" data-placement="right"
        title="@lang('products-catalog::family.priority.?')"></i> --}}
</div>

<div class="form-row">
    <div class="offset-0 offset-md-3 col-12 col-md-9">
        <button type="submit" class="btn btn-success">@lang('products-catalog::families.save')</button>
        <a href="{{ route('backend.families') }}" class="btn btn-danger">@lang('products-catalog::families.cancel')</a>
    </div>
</div>
