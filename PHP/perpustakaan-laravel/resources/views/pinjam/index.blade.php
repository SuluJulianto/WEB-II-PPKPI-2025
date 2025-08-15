@extends('layout.app')
@section('title', 'Data Kategori')

@section('content')
    <div align="right" class="mb-3">
        <a href="{{ route('pinjam.create') }}" class="btn btn-primary">Tambah</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Nama Anggota</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->kode_transaksi }}</td>
                    <td>{{ $item->anggota->nama_anggota}}</td>
                    <td>{{date('D, d-m-Y', strtotime($item->tgl_pinjam))}}</td>
                    <td>{{date('D, d-m-Y', strtotime($item->tgl_kembali))}}</td>
                    <td>
                        <a class="btn btn-success btn-xs" href="{{ route('pinjam.edit', $item->id) }}">Detail</a>
                        <form class="d-inline" action="{{ route('pinjam.destroy', $item->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <!-- <input type="hidden" name="_method" value="DELETE"> -->
                            <button class="btn btn-danger btn-xs" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
