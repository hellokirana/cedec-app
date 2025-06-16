@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ url('data/layanan',$data->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Tambah layanan
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <x-form.text label="Nama layanan" for="title" name="title"
                                    value="{{ $data->title }}" :error="$errors->first('title')" required></x-form.text>
                            </div>
                            <div class="col-md-6">
                                <x-form.number label="harga_member" for="harga_member" name="harga_member"
                                    value="{{ $data->harga_member }}" :error="$errors->first('harga_member')" required></x-form.number>
                            </div>
                            <div class="col-md-6">
                                <x-form.number label="harga_worker" for="harga_worker" name="harga_worker"
                                    value="{{ $data->harga_worker }}" :error="$errors->first('harga_worker')" required></x-form.number>
                            </div>
                            <div class="col-12 mt-4">
                                <label>konten</label>
                                <x-form.textarea for="konten" name="konten" :value="$data->konten"
                                    :error="$errors->first('konten')"></x-form.textarea>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Info data
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <input class="" type="checkbox" name="featured" value="1"
                                id="featured" {{ $data->featured == 1 ? 'checked':''}}>
                            <label class="form-check-label" for="featured">
                                featured
                            </label>
                        </div>
                        <div class="form-group mb-3">
                            <label>Kategori </label><br>
                            {{ Form::select('kategori_id', ['' => 'Pilih kategori'] + kategori_all(), $data->kategori_id, ['id' => 'kategori_id', 'class' => 'form-select']) }}
                            @if ($errors->first('kategori'))
                                <small class="text-danger text-capitalize">{{ $errors->first('kategori') }}</small>
                            @endif
                        </div>

                        <div class="mb-3">
                            <x-form.file label="image" for="image" name="image" data-default-file="{{ $data->image_url }}"
                                :error="$errors->first('image')"></x-form.file>
                        </div>

                        <div class="form-group mb-3">
                            <label>Status </label><br>
                            {{ Form::select('status', status_publish(), $data->status, ['class' => 'form-select']) }}
                            @if ($errors->first('status'))
                                <small class="text-danger text-capitalize">{{ $errors->first('status') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary "><i class="fa fa-save me-2"></i>Simpan</button>
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
        .create(document.querySelector('#konten'), {
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
