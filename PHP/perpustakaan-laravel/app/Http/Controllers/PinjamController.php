<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Pinjam;
use App\Models\DetailPinjam;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class PinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // select * from users;
        $datas =  Pinjam::with('anggota')->get();
        return view('pinjam.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        $anggotas = Anggota::get();
        $kode_unik = Pinjam::get()->last();
        $id_pinjam = isset($kode_unik->id) ? ($kode_unik->id == "" ? 1 : $kode_unik->id) : '';
        $id_pinjam++;
        $kode_transaksi = "PJM" . date("dmY") . sprintf("%03s", $id_pinjam);
        return view('pinjam.create', compact('categories', 'anggotas', 'kode_transaksi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $category = new Category();
        // $category->category_name  = $request->category_name;
        // $category->save();

        // return $request;
        // cara ke dua
        $pinjam = Pinjam::create([
            'anggota_id'  => $request->id_anggota,
            'kode_transaksi'  => $request->kode_transaksi,
            'tgl_pinjam'  => $request->tgl_pinjam,
            'tgl_kembali'  => $request->tgl_kembali,
            'petugas'  => (Auth::user()->name ?? 'Faiz')
        ]);

        if ($pinjam) {
            foreach ($request->buku_id as $key => $val) {
                DetailPinjam::create([
                    'buku_id'   => $val,
                    'pinjam_id' => $pinjam->id,
                ]);
            }
        }

        Alert::success('Good Job', 'Transaksi Pinjam Berhasil di Buat');

        // User::create($request->all());
        return redirect()->to('pinjam')->with('message', 'Data berhasil diubah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $edit = User::where('id', $id)->first();
        $edit = Category::find($id);
        return view('category.edit', compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Category::where('id', $id)->update([
            'category_name'  => $request->category_name,
        ]);

        // $user = User::find($id);
        // $user->name  = $request->name;
        // $user->email = $request->email;
        // $user->password = $request->password;
        // $user->save();

        return redirect()->to('category')->with('messsage', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect()->to('category')->with('message', 'Data berhasil di hapus');
    }
}
