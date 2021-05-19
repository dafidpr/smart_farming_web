<div class="form-group">
    @if (isset($label))
        <label class="form-label" for="{{ $id ?? $field }}">{{ $label }} @if(isset($required) && $required) <span class="text-danger">*</span> @endif</label>
    @endif
    <div class="form-control-wrap">
        <select class="form-select form-control form-control-lg {{ $classes ?? '' }}" id="{{ $id ?? $field }}" name="{{ $field }}" {{ isset($searchable) && $searchable ? 'data-search=on' : '' }} {{ $required ? 'required' : '' }}>
            {{ $slot }}
        </select>
        <i class="text-danger small d-none" id="{{ $field . '-error' }}"></i>
    </div>
</div>
