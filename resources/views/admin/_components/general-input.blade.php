<div class="form-group">
    @if (isset($label))
        <label class="form-label" for="{{ $id ?? $field }}">{{ $label }} @if (isset($required) && $required) <span class="text-danger">*</span> @endif</label>
    @endif
    <div class="form-control-wrap">
        @if (isset($icon))
            <div class="form-icon form-icon-left">
                <em class="{{ $icon }}"></em>
            </div>
        @endif
        @if (isset($type) && $type == 'file')
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="{{ $field }}" id="{{ $id ?? $field }}" placeholder="{{ $placeholder ?? '' }}" autocomplete="off">
                <label class="custom-file-label"  for="">Choose file</label>
            </div>
        @else
            <input type="{{ $type ?? 'text' }}" class="form-control form-control-lg {{ $classes ?? '' }}" name="{{ $field }}" data-date-format="{{ $dateFormat ?? '' }}" id="{{ $id ?? $field }}" placeholder="{{ $placeholder ?? '' }}" autocomplete="off">
        @endif
        
    </div>
    <i class="text-danger small d-none" id="{{ $field }}-error"></i>
</div>
