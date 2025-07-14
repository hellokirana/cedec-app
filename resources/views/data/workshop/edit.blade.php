@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('workshop.update', $workshop->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Form Utama -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Edit Workshop
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Judul -->
                            <div class="col-12">
                                <x-form.text label="Judul Workshop" name="title"
                                    value="{{ old('title', $workshop->title) }}" :error="$errors->first('title')" required />
                            </div>

                            <!-- Deskripsi -->
                            <div class="col-12 mt-4">
                                <label>Description</label>
                                <x-form.textarea for="description" name="description"
                                    :value="old('description', $workshop->description)"
                                    :error="$errors->first('description')"></x-form.textarea>
                            </div>

                            <!-- Tanggal Mulai & Selesai -->
                            <div class="col-md-6">
                                <x-form.date label="Tanggal Mulai Workshop" name="workshop_start_date"
                                    value="{{ old('workshop_start_date', $workshop->workshop_start_date) }}" :error="$errors->first('workshop_start_date')" required />
                            </div>
                            <div class="col-md-6">
                                <x-form.date label="Tanggal Selesai Workshop" name="workshop_end_date"
                                    value="{{ old('workshop_end_date', $workshop->workshop_end_date) }}" :error="$errors->first('workshop_end_date')" required />
                            </div>

                            <!-- Waktu & Tempat -->
                            <div class="col-md-6">
                                <x-form.text label="Waktu" name="time"
                                    value="{{ old('time', $workshop->time) }}" :error="$errors->first('time')" />
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="Tempat" name="place"
                                    value="{{ old('place', $workshop->place) }}" :error="$errors->first('place')" />
                            </div>

                            <!-- Biaya & Kuota -->
                            <div class="col-md-6">
                                <x-form.text label="Biaya (Fee)" name="fee"
                                    value="{{ old('fee', $workshop->fee) }}" :error="$errors->first('fee')" />
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="Kuota Peserta" name="quota"
                                    value="{{ old('quota', $workshop->quota) }}" :error="$errors->first('quota')" />
                            </div>

                            <!-- Tanggal Registrasi -->
                            <div class="col-md-6">
                                <x-form.date label="Registrasi Mulai" name="registration_start_date"
                                    value="{{ old('registration_start_date', $workshop->registration_start_date) }}" :error="$errors->first('registration_start_date')" />
                            </div>
                            <div class="col-md-6">
                                <x-form.date label="Registrasi Selesai" name="registration_end_date"
                                    value="{{ old('registration_end_date', $workshop->registration_end_date) }}" :error="$errors->first('registration_end_date')" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Samping -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Informasi Tambahan
                    </div>
                    <div class="card-body">
                        <!-- Gambar -->
                        <x-form.file label="Gambar / Poster Workshop" name="image"
                            value="{{ old('image', $workshop->image) }}" :error="$errors->first('image')" />

                        <!-- Status -->
                        <div class="form-group mt-3">
                            <label>Status</label>
                            {{ Form::select('status', status_publish(), old('status', $workshop->status), ['class' => 'form-select']) }}
                            @if ($errors->first('status'))
                                <small class="text-danger">{{ $errors->first('status') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: {
                items: [
                    'undo', 'redo',
                    '|',
                    'heading',
                    '|',
                    'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                    '|',
                    'bold', 'italic', 'strikethrough', 'subscript', 'superscript', 'code',
                    '|',
                    'link', 'uploadImage', 'blockQuote', 'codeBlock',
                    '|',
                    'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent'
                ],
                shouldNotGroupWhenFull: false
            }
        });
</script>
@endpush
