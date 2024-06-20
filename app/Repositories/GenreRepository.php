<?php

namespace App\Repositories;

use App\Interfaces\GenreRepositoryInterface;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;

class GenreRepository implements GenreRepositoryInterface
{
    protected $genre;

    // model injection
    public function __construct(Genre $genre)
    {
        $this->genre = $genre;
    }

    public function getAllGenres(): Collection
    {
        $genres = $this->genre->with('books')->get();

        if(count($genres) === 0){
            throw new \Exception(__('genre.not_found'), 404);
        }

        return $genres;
    }

    public function getGenreById(int $genreId): Collection
    {
        $genre = $this->genre->with('books')->where('id', $genreId)->get();

        if(count($genre) === 0){
            throw new \Exception(__('genre.not_found'), 404);
        }

        return $genre;
    }

    public function deleteGenre(int $genreId): Genre
    {
        $genre = $this->genre->find($genreId);

        if(!$genre){
            throw new \Exception(__('genre.not_found'), 404);
        }

        $genre->delete();

        return $genre;
    }

    public function createGenre(array $genreDetails): Genre
    {
        $genre = $this->genre->create($genreDetails);

        return $genre;
    }

    public function updateGenre(int $genreId, array $newDetails): Genre
    {
        $genre = $this->genre->find($genreId);

        if(!$genre){
            throw new \Exception(__('genre.not_found'), 404);
        }

        $genre->update($newDetails);

        return $genre;
    }
}