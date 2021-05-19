<div class="form-group">
    @if (isset($label))
        <label class="form-label" for="{{ $field ?? $id }}">{{ $label }} @if(isset($required) && $required) <span class="text-danger">*</span> @endif</label>
    @endif
    <div class="form-control-wrap">
        <textarea name="{{ $field }}" cols="{{ $cols ?? 30 }}" rows="{{ $rows ?? 1 }}" id="{{ $field ?? $id }}" class="form-control {{ $classes ?? '' }}">{{ isset($lecturer->address) ? $lecturer->address : '' }}</textarea>
    </div>
    <i class="text-danger small d-none" id="{{ $field }}-error"></i>
</div>
