@props([
    'label' => false,
    'for' => false,
    'error' => false,
    'required' => false,
    'placeholder' => false
])


<div class="">
    <label for="{{ $for }}" class="text-capitalize">
        {{ str_replace('_', ' ', $label) }}
        @if ($required)
            <small class="text-danger" title="wajib diisi">*</small>
        @endif
    </label>
    <input type="file" class="dropify" id="{{ $for }}" placeholder="{{ $placeholder }}"  {{ $attributes }} @if ($required) required @endif>
    
    
    @if ($error)
        <div class="invalid-feedback text-capitalize">{{ $error }}</div>
    @endif
    {{ $slot }}
</div>
