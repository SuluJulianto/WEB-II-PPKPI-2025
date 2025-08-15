<?php

namespace App\Http\Controllers;

use App\Models\Book;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getDataBuku($category_id)
    {
        $books = Book::where('category_id', $category_id)->get();
        return response()->json(['data' => $books, 'message' => 'fetch Success!!']);
    }

    public function getbuku($buku_id)
    {
        try {
            $book = Book::where('id', $buku_id)->first();
            // $book = Book::find($buku_id);
            // $book = Book::firstOrFail($buku_id);
            return response()->json(['data' => $book, 'message' => 'fetch Success']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
            //throw $th;
        }
    }
}
