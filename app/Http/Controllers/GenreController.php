<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Interfaces\GenreRepositoryInterface;
use Illuminate\Http\JsonResponse;

class GenreController extends Controller
{
    private GenreRepositoryInterface $genreRepository;

    public function __construct(GenreRepositoryInterface $genreRepository) 
    {
        $this->genreRepository = $genreRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try{
            return response()->json($this->genreRepository->getAllGenres(), 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\GenreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GenreRequest $request): JsonResponse
    {
        try{
            $validated = $request->validated();

            return response()->json($this->genreRepository->createGenre($validated), 201);
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
            return response()->json($this->genreRepository->getGenreById($id), 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\GenreRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GenreRequest $request, int $id): JsonResponse
    {
        try{
            $validated = $request->validated();

            return response()->json($this->genreRepository->updateGenre($id, $validated), 200);
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
            $this->genreRepository->deleteGenre($id);

            return response()->json(['success' => __('genre.deleted')], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }
}
