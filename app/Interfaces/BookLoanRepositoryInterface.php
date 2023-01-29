<?php

namespace App\Interfaces;

interface BookLoanRepositoryInterface 
{
    public function getAllLoans();
    public function createLoan(array $loanDetails);
    public function setBookReturned($loanId);
    public function setLoanDelayed($loanId);
}