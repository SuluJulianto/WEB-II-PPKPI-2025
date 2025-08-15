<h1>Edit User</h1>
<form action="{{route('user.update', $edit->id)}}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="">Nama Lengkap</label>
        <input type="text" name="name" value="{{$edit->name}}">
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input type="email" name="email" value="{{$edit->email}}">
    </div>
    <div class="form-group">
        <label for="">Password</label>
        <input type="password" name="password">
    </div>
    <div class="form-group">
        <button type="submit">Simpan</button>
    </div>
</form>