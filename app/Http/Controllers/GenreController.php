<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Interfaces\GenreRepositoryInterface;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * @return \Illuminate\Http\Response
     */
    public function store(GenreRequest $request)
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
     * @return \Illuminate\Http\Response
     */
    public function update(GenreRequest $request, $id)
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $this->genreRepository->deleteGenre($id);

            return response()->json(['success' => 'Gênero excluído com sucesso.'], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }
}
