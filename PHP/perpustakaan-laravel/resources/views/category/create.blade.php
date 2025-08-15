@extends('layout.app')
@section('title','Tambah Kategori')

@section('content')
<form action="{{route('category.store')}}" method="post">
    @csrf
    <div class="form-group">
        <label for="">Nama Kategori</label>
        <input type="text" name="category_name" class="form-control">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Simpan</button>

    </div>
</form>
@endsection