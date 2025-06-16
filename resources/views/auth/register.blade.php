<form method="POST" action="{{ route('register') }}">
    @csrf

    <label for="name">Nama</label>
    <input type="text" name="name" required>

    <label for="email">Email</label>
    <input type="email" name="email" required>

    <label for="password">Password</label>
    <input type="password" name="password" required>

    <label for="password_confirmation">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" required>

    <label for="role">Daftar Sebagai</label>
    <select name="role" required>
        <option value="user">User</option>
        <option value="mitra">Mitra</option>
    </select>

    <label for="alamat">Alamat</label>
    <input type="text" name="alamat" required>

    <label for="kode_pos">Kode Pos</label>
    <input type="text" name="kode_pos" required>

    <label for="kelurahan">Kelurahan</label>
    <input type="text" name="kelurahan" required>

    <label for="kecamatan">Kecamatan</label>
    <input type="text" name="kecamatan" required>

    <button type="submit">Register</button>
</form>
