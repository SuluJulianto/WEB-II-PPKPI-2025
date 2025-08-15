<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'judul', 'jumlah', 'penerbit', 'tahun_terbit', 'penulis'
    ];

    protected $table = "bukus";

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
