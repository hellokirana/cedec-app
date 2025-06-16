@props([
    'label' => false,
    'for' => false,
    'error' => false,
    'required' => false,
    'placeholder' => false,
    'justread' => false,
    'value'=>false,
])


<div class="mb-3">
    <label for="{{ $for }}" class="text-capitalize">
        {{ str_replace('_', ' ', $label) }}
        @if ($required)
            <small class="text-danger" title="wajib diisi">*</small>
        @endif
    </label>
    <textarea class="form-control {{ $error ? 'is-invalid' : '' }}" id="{{ $for }}" placeholder="{{ $placeholder }}"  {{ $attributes }} @if ($required) required @endif @if ($justread == "true") readonly @endif>{{ $value}}</textarea>
    
    @if ($error)
        <div class="invalid-feedback text-capitalize">{{ $error }}</div>
    @endif
    {{ $slot }}
</div>
