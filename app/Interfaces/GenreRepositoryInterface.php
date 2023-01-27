<?php

namespace App\Interfaces;

interface GenreRepositoryInterface 
{
    public function getAllGenres();
    public function getGenreById($genreId);
    public function deleteGenre($genreId);
    public function createGenre(array $genreDetails);
    public function updateGenre($genreId, array $newDetails);
}