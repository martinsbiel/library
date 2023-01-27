<?php

namespace App\Interfaces;

interface BookLoanRepositoryInterface 
{
    public function getAllLoans();
    public function createLoan(array $loanDetails);
    public function setBookReturned($bookId);
    public function setLoanDelayed($loanId);
}