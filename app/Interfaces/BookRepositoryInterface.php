<?php

namespace App\Interfaces;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

interface BookRepositoryInterface 
{
    public function getAllBooks(): Collection;
    public function getBookById(int $bookId): Collection;
    public function deleteBook(int $bookId): Book;
    public function createBook(array $bookDetails): Book;
    public function updateBook(int $bookId, array $newDetails): Book;
}