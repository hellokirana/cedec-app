@props([
    'label' => false,
    'for' => false,
    'error' => false,
    'required' => false,
    'placeholder' => false
])


<div class="form-floating form-floating-outline mb-6">
    <input type="datetime-local" class="form-control {{ $error ? 'is-invalid' : '' }}" id="{{ $for }}" placeholder="{{ $placeholder }}"  {{ $attributes }} @if ($required) required @endif>
    <label for="{{ $for }}" class="text-capitalize">
        {{ str_replace('_', ' ', $label) }}
        @if ($required)
            <small class="text-danger" title="wajib diisi">*</small>
        @endif
    </label>
    <div class="valid-feedback"> Looks good! </div>
    @if ($error)
        <div class="invalid-feedback text-capitalize">{{ $error }}</div>
    @endif
    {{ $slot }}
</div>
