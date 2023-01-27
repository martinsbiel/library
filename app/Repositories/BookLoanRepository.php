<?php

namespace App\Repositories;

use App\Interfaces\BookLoanRepositoryInterface;
use App\Models\Book;
use App\Models\BookLoan;

class BookLoanRepository implements BookLoanRepositoryInterface
{
    protected $loan;
    protected $book;

    // model injection
    public function __construct(BookLoan $loan, Book $book)
    {
        $this->loan = $loan;
        $this->book = $book;
    }

    public function getAllLoans()
    {
        $loans = $this->loan->with(['book', 'user'])->get();

        if(count($loans) === 0){
            throw new \Exception('Nenhum empréstimo encontrado.', 404);
        }

        return $loans;
    }

    public function createLoan(array $loanDetails)
    {
        $book = $this->book->find($loanDetails['book_id']);

        if(!$book->status){
            throw new \Exception('Este livro já está emprestado.', 422);
        }

        $loan = $this->loan->create($loanDetails);

        $book->update([
            'status' => false
        ]);

        return $loan;
    }

    public function setBookReturned($bookId)
    {
        $loan = $this->loan->where('book_id', $bookId)->update(['returned' => true]);
        
        if(!$loan){
            throw new \Exception('Nenhum empréstimo encontrado.', 404);
        }

        $book = $this->book->find($bookId);
        
        $book->update([
            'status' => true
        ]);

        return $book;
    }

    public function setLoanDelayed($loanId)
    {
        $loan = $this->loan->find($loanId);

        if(!$loan){
            throw new \Exception('Nenhum empréstimo encontrado.', 404);
        }

        $loan->update([
            'delayed' => true
        ]);

        return $loan;
    }
}