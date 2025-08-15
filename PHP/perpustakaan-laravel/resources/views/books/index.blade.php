@extends('layout.app')
@section('title', 'Data Buku')

@section('content')
<div align="right" class="mb-3">
    <a href="{{route('book.create')}}" class="btn btn-primary">Tambah</a>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kategori</th>
            <th>Judul</th>
            <th>Penerbit</th>
            <th>Tahun Terbit</th>
            <th>Penulis</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datas as $key =>  $item)
        <tr>
            <td>{{$key + 1 }}</td>
            <td>{{$item->category->category_name}}</td>
            <td>{{$item->judul}}</td>
            <td>{{$item->penerbit}}</td>
            <td>{{$item->tahun_terbit}}</td>
            <td>{{$item->penulis}}</td>
            <td>
                <a class="btn btn-success btn-xs" href="{{route('book.edit', $item->id)}}">Edit</a>
                <form class="d-inline" action="{{route('book.destroy', $item->id)}}" method="post">
                    @csrf
                    @method("DELETE")
                    <!-- <input type="hidden" name="_method" value="DELETE"> -->
                    <button class="btn btn-danger btn-xs" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
