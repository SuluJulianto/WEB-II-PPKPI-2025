<form action="{{route('store_tambah')}}" method="post">
    @csrf
    <div class="form-group">
        <label for="">Angka 1</label>
        <input type="text" name="angka1">
    </div>
    <div class="form-group">
        <label for="">Angka 2</label>
        <input type="text" name="angka2">
    </div>
    <div class="form-group">
        <button type="submit">Tambah</button>
    </div>
</form>

<h1>Jumlahnya Adalah : {{$jumlah}}</h1>