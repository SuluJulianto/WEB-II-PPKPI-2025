<h1>Tambah User</h1>
<form action="{{route('user.store')}}" method="post">
    @csrf
    <div class="form-group">
        <label for="">Nama Lengkap</label>
        <input type="text" name="name">
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input type="email" name="email">
    </div>
    <div class="form-group">
        <label for="">Password</label>
        <input type="password" name="password">
    </div>
    <div class="form-group">
        <button type="submit">Simpan</button>
    </div>
</form>