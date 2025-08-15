@extends('layout.app')
@section('title', 'Tambah Kategori')

@section('content')
    <form action="{{ route('pinjam.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="">Kode Transaksi</label>
                    </div>
                    <div class="col-sm-6">
                        <input value="{{$kode_transaksi}}" type="text" name="kode_transaksi" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="">Nama Anggota</label>
                    </div>
                    <div class="col-sm-6">
                        <select name="id_anggota" id="" class="form-control" required>
                            <option value="">Pilih Anggota</option>
                            @foreach ($anggotas as $anggota)
                            <option value="{{$anggota->id}}">{{$anggota->nama_anggota}}</option>

                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="">Tanggal Pinjam</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="date" name="tgl_pinjam" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="">Tanggal Kembali </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="date" name="tgl_kembali" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-sm-6"></div>
        </div>
        <div class="form-group row mt-5">
            <div class="col-sm-2">
                <label for="">Kategori Buku</label>
            </div>
            <div class="col-sm-4">
                <select name="" id="category_id" class="form-control">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                    @endforeach

                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">
                <label for="">Judul Buku</label>
            </div>
            <div class="col-sm-4">
                <select name="" id="buku_id" class="form-control">
                    <option value="">Pilih Judul Buku</option>

                </select>
                <input type="text" id="nama_penerbit">
            </div>
        </div>
        <div class="form-group">
            <div align="right" class="mb-3">
                <button type="button" class="btn btn-success" id="tambah-row">Tambah Row</button>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Penerbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Simpan</button>

        </div>
    </form>
@endsection
