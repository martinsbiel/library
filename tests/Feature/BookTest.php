<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_can_be_created()
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $genre = Genre::factory()->create();

        $data = [
            'name' => 'Livro 1',
            'author' => 'João da Silva',
            'genre_id' => 1
        ];

        $response = $this->postJson(route('books.store'), $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'name',
            'author',
            'genre_id',
            'created_at',
            'updated_at',
        ]);
    }

    public function test_books_can_be_listed()
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $genre = Genre::factory()->create();
        $books = Book::factory(10)->create();

        $response = $this->getJson(route('books.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'id',
                'name',
                'author',
                'status',
                'genre_id',
                'genre',
                'loan',
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        ]);
    }

    public function test_book_can_be_selected()
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $genre = Genre::factory()->create();
        $book = Book::factory()->create();

        $response = $this->getJson(route('books.show', ['book' => $book->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'id',
                'name',
                'author',
                'status',
                'genre_id',
                'genre',
                'loan',
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        ]);
    }

    public function test_book_can_be_deleted()
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $genre = Genre::factory()->create();
        $book = Book::factory()->create();

        $response = $this->deleteJson(route('books.destroy', ['book' => $book->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success'
        ]);
    }

    public function test_book_can_be_updated()
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );
        
        $genre = Genre::factory()->create();
        $book = Book::factory()->create();

        $response = $this->patchJson(route('books.update', ['book' => $book->id]), ['name' => 'Terror']);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'author',
            'status',
            'genre_id',
            'created_at',
            'updated_at',
            'deleted_at'
        ]);
    }
}
