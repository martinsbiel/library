<?php

namespace App\Interfaces;

use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Database\Eloquent\Collection;

interface BookLoanRepositoryInterface 
{
    public function getAllLoans(): Collection;
    public function createLoan(array $loanDetails): BookLoan;
    public function setBookReturned(int $loanId): Book;
    public function setLoanDelayed(int $loanId): BookLoan;
}