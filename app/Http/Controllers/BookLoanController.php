<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookLoanRequest;
use App\Interfaces\BookLoanRepositoryInterface;

class BookLoanController extends Controller
{
    private BookLoanRepositoryInterface $loanRepository;

    public function __construct(BookLoanRepositoryInterface $loanRepository) 
    {
        $this->loanRepository = $loanRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return response()->json($this->loanRepository->getAllLoans(), 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\BookLoanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookLoanRequest $request)
    {
        try{
            $validated = $request->validated();

            return response()->json($this->loanRepository->createLoan($validated), 201);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    public function setBookReturn($id)
    {
        try{
            $this->loanRepository->setBookReturned($id);

            return response()->json(['success' => 'Livro devolvido com sucesso.'], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    public function setLoanDelayed($id)
    {
        try{
            $this->loanRepository->setLoanDelayed($id);

            return response()->json(['success' => 'Empréstimo marcado como atrasado.'], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }
}
