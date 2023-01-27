<?php

namespace App\Repositories;

use App\Interfaces\GenreRepositoryInterface;
use App\Models\Genre;

class GenreRepository implements GenreRepositoryInterface
{
    protected $genre;

    // model injection
    public function __construct(Genre $genre)
    {
        $this->genre = $genre;
    }

    public function getAllGenres()
    {
        $genres = $this->genre->with('books')->get();

        if(count($genres) === 0){
            throw new \Exception('Nenhum gênero encontrado.', 404);
        }

        return $genres;
    }

    public function getGenreById($genreId)
    {
        $genre = $this->genre->with('books')->where('id', $genreId)->get();

        if(count($genre) === 0){
            throw new \Exception('Gênero não encontrado.', 404);
        }

        return $genre;
    }

    public function deleteGenre($genreId)
    {
        $genre = $this->genre->find($genreId);

        if(!$genre){
            throw new \Exception('Gênero não encontrado.', 404);
        }

        $genre->delete();

        return $genre;
    }

    public function createGenre(array $genreDetails)
    {
        $genre = $this->genre->create($genreDetails);

        return $genre;
    }

    public function updateGenre($genreId, array $newDetails)
    {
        $genre = $this->genre->find($genreId);

        if(!$genre){
            throw new \Exception('Gênero não encontrado.', 404);
        }

        $genre->update($newDetails);

        return $genre;
    }
}