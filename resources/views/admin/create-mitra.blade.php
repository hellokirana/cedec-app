@extends('layouts.admin')

@section('content')
<h2>Tambah Mitra Baru</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('admin.storeMitra') }}">
    @csrf

    <label for="name">Nama:</label>
    <input type="text" name="name" required>

    <label for="email">Email:</label>
    <input type="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <label for="alamat">Alamat:</label>
    <input type="text" name="alamat" required>

    <label for="kode_pos">Kode Pos:</label>
    <input type="text" name="kode_pos" required>

    <label for="kelurahan">Kelurahan:</label>
    <input type="text" name="kelurahan" required>

    <label for="kecamatan">Kecamatan:</label>
    <input type="text" name="kecamatan" required>

    <button type="submit">Tambah Mitra</button>
</form>
@endsection
