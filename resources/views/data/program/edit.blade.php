@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ url('data/program', $data->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Edit Study Program
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <x-form.text 
                                label="Program Name" 
                                for="title" 
                                name="title"
                                value="{{ $data->title }}" 
                                :error="$errors->first('title')" 
                                required>
                            </x-form.text>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Additional Info
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label>Status</label><br>
                            {{ Form::select('status', [1 => 'Active', 0 => 'Inactive'], $data->status, ['class' => 'form-select']) }}
                            @if ($errors->first('status'))
                                <small class="text-danger">{{ $errors->first('status') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-2"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
