<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookLoanRequest;
use App\Interfaces\BookLoanRepositoryInterface;
use Illuminate\Http\JsonResponse;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BookLoanRequest $request): JsonResponse
    {
        try{
            $validated = $request->validated();

            return response()->json($this->loanRepository->createLoan($validated), 201);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    public function setBookReturn(int $id): JsonResponse
    {
        try{
            $this->loanRepository->setBookReturned($id);

            return response()->json(['success' => __('book.returned')], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    public function setLoanDelayed(int $id): JsonResponse
    {
        try{
            $this->loanRepository->setLoanDelayed($id);

            return response()->json(['success' => __('loan.overdue')], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }
}
