<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class BooksController extends Controller
{
    /**
    
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // select * from users;
        // $datas =  Book::join('categories', 'categories.id', '=', 'bukus.category_id')->get();
        $datas =  Book::with('category')->get();
        // return $datas;
        return view('books.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $user = new Book;
        $user->category_id  = $request->category_id;
        $user->judul  = $request->judul;
        $user->jumlah = $request->jumlah;
        $user->penerbit = $request->penerbit;
        $user->tahun_terbit = $request->tahun_terbit;
        $user->penulis = $request->penulis;
        $user->save();

        // cara ke dua
        // User::create([
        //     'name'  => $request->name,
        //     'email'  => $request->email,
        //     'password'  => $request->password,
        // ]);

        // User::create($request->all());
        return redirect()->to('book')->with('message', 'Data berhasil ditambah');
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
        $edit = Book::find($id);
        return view('books.edit', compact('edit'));
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
        Book::where('id', $id)->update([
            'category_id'  => $request->category_id,
            'judul'  => $request->judul,
            'jumlah'  => $request->jumlah,
            'penerbit'  => $request->penerbit,
            'tahun_terbit'  => $request->tahun_terbit,
            'penulis'  => $request->penulis,

        ]);

        // $user = User::find($id);
        // $user->name  = $request->name;
        // $user->email = $request->email;
        // $user->password = $request->password;
        // $user->save();

        return redirect()->to('book')->with('messsage', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Book::find($id)->delete();
        return redirect()->to('book')->with('message', 'Data berhasil di hapus');
    }
}
