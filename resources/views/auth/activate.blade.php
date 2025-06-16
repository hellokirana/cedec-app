@extends('layouts.app')

@section('content')
<h2>Aktivasi Akun</h2>

@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('activate') }}">
    @csrf
    <button type="submit">Aktifkan Akun</button>
</form>
@endsection
