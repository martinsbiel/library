<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_date',
        'user_id',
        'book_id',
        'returned',
        'delayed'
    ];

    protected $hidden = [
        'user_id',
        'book_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function book(){
        return $this->belongsTo(Book::class);
    }
}
