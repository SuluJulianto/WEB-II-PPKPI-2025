@extends('layout.app')
@section('title','Edit Kategori')

@section('content')
<form action="{{route('category.update', $edit->id)}}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="">Nama Kategori</label>
        <input class="form-control" type="text" name="category_name" value="{{$edit->category_name}}">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{url()->previous()}}">Kembali</a>
    </div>
</form>

@endsection