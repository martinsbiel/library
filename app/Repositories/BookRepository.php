<?php

namespace App\Repositories;

use App\Interfaces\BookRepositoryInterface;
use App\Models\Book;

class BookRepository implements BookRepositoryInterface
{
    protected $book;

    // model injection
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function getAllBooks()
    {
        $books = $this->book->with(['genre', 'loan'])->get();

        if(count($books) === 0){
            throw new \Exception('Nenhum livro encontrado.', 404);
        }

        return $books;
    }

    public function getBookById($bookId)
    {
        $book = $this->book->with(['genre', 'loan'])->where('id', $bookId)->get();

        if(count($book) === 0){
            throw new \Exception('Livro não encontrado.', 404);
        }

        return $book;
    }

    public function deleteBook($bookId)
    {
        $book = $this->book->find($bookId);

        if(!$book){
            throw new \Exception('Livro não encontrado.', 404);
        }

        $book->delete();

        return $book;
    }

    public function createBook(array $bookDetails)
    {
        $book = $this->book->create($bookDetails);

        return $book;
    }

    public function updateBook($bookId, array $newDetails)
    {
        $book = $this->book->find($bookId);

        if(!$book){
            throw new \Exception('Livro não encontrado.', 404);
        }

        $book->update($newDetails);

        return $book;
    }
}