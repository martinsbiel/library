<?php

namespace App\Interfaces;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;

interface GenreRepositoryInterface 
{
    public function getAllGenres(): Collection;
    public function getGenreById(int $genreId): Collection;
    public function deleteGenre(int $genreId): Genre;
    public function createGenre(array $genreDetails): Genre;
    public function updateGenre(int $genreId, array $newDetails): Genre;
}