@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('workshop.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Form Utama -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Tambah Workshop
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Judul -->
                            <div class="col-12">
                                <x-form.text label="Judul Workshop" name="title"
                                    value="{{ old('title') }}" :error="$errors->first('title')" required />
                            </div>

                            <!-- Deskripsi -->
                            <div class="col-12 mt-4">
                                    <label>Description</label>
                                    <x-form.textarea id="description" for="description" name="description" :value="old('description')"
                                        :error="$errors->first('description')"></x-form.textarea>
                                </div>

                            <!-- Tanggal Mulai & Selesai -->
                            <div class="col-md-6">
                                <x-form.date label="Tanggal Mulai Workshop" name="workshop_start_date"
                                    value="{{ old('workshop_start_date') }}" :error="$errors->first('workshop_start_date')" required />
                            </div>
                            <div class="col-md-6">
                                <x-form.date label="Tanggal Selesai Workshop" name="workshop_end_date"
                                    value="{{ old('workshop_end_date') }}" :error="$errors->first('workshop_end_date')" required />
                            </div>

                            <!-- Waktu & Tempat -->
                            <div class="col-md-6">
                                <x-form.text label="Waktu" name="time"
                                    value="{{ old('time') }}" :error="$errors->first('time')" />
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="Tempat" name="place"
                                    value="{{ old('place') }}" :error="$errors->first('place')" />
                            </div>

                            <!-- Biaya & Kuota -->
                            <div class="col-md-6">
                                <x-form.text label="Biaya (Fee)" name="fee"
                                    value="{{ old('fee') }}" :error="$errors->first('fee')" />
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="Kuota Peserta" name="quota"
                                    value="{{ old('quota') }}" :error="$errors->first('quota')" />
                            </div>

                            <!-- Tanggal Registrasi -->
                            <div class="col-md-6">
                                <x-form.date label="Registrasi Mulai" name="registration_start_date"
                                    value="{{ old('registration_start_date') }}" :error="$errors->first('registration_start_date')" />
                            </div>
                            <div class="col-md-6">
                                <x-form.date label="Registrasi Selesai" name="registration_end_date"
                                    value="{{ old('registration_end_date') }}" :error="$errors->first('registration_end_date')" />
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
                            value="{{ old('image') }}" :error="$errors->first('image')" />

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Save</button>
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
