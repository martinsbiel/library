<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Interfaces\BookRepositoryInterface;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository) 
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try{
            return response()->json($this->bookRepository->getAllBooks(), 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        try{
            $validated = $request->validated();

            return response()->json($this->bookRepository->createBook($validated), 201);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try{
            return response()->json($this->bookRepository->getBookById($id), 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateBookRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBookRequest $request, int $id): JsonResponse
    {
        try{
            $validated = $request->validated();

            return response()->json($this->bookRepository->updateBook($id, $validated), 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try{
            $this->bookRepository->deleteBook($id);

            return response()->json(['success' => __('book.deleted')], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }
}
