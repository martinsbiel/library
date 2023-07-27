<?php

namespace App\Repositories;

use App\Interfaces\BookRepositoryInterface;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

class BookRepository implements BookRepositoryInterface
{
    protected $book;

    // model injection
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function getAllBooks(): Collection
    {
        $books = $this->book->with(['genre', 'loan'])->get();

        if(count($books) === 0){
            throw new \Exception('Nenhum livro encontrado.', 404);
        }

        return $books;
    }

    public function getBookById(int $bookId): Collection
    {
        $book = $this->book->with(['genre', 'loan'])->where('id', $bookId)->get();

        if(count($book) === 0){
            throw new \Exception('Livro não encontrado.', 404);
        }

        return $book;
    }

    public function deleteBook(int $bookId): Book
    {
        $book = $this->book->find($bookId);

        if(!$book){
            throw new \Exception('Livro não encontrado.', 404);
        }

        $book->delete();

        return $book;
    }

    public function createBook(array $bookDetails): Book
    {
        $book = $this->book->create($bookDetails);

        return $book;
    }

    public function updateBook(int $bookId, array $newDetails): Book
    {
        $book = $this->book->find($bookId);

        if(!$book){
            throw new \Exception('Livro não encontrado.', 404);
        }

        $book->update($newDetails);

        return $book;
    }
}