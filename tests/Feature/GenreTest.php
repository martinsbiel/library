<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use RefreshDatabase;

    public function test_genre_can_be_created(): void
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $data = [
            'name' => 'Ficção'
        ];

        $response = $this->postJson(route('genres.store'), $data);
        $response->assertStatus(201);
        $response->assertJson($data);
    }

    public function test_genres_can_be_listed(): void
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $genres = Genre::factory(10)->create();

        $response = $this->getJson(route('genres.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'id',
                'name',
                'books',
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        ]);
    }

    public function test_genre_can_be_selected(): void
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $genre = Genre::factory()->create();

        $response = $this->getJson(route('genres.show', ['genre' => $genre->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'id',
                'name',
                'books',
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        ]);
    }

    public function test_genre_can_be_deleted(): void
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $genre = Genre::factory()->create();

        $response = $this->deleteJson(route('genres.destroy', ['genre' => $genre->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success'
        ]);
    }

    public function test_genre_can_be_updated(): void
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );
        
        $genre = Genre::factory()->create();

        $response = $this->patchJson(route('genres.update', ['genre' => $genre->id]), ['name' => 'Terror']);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'created_at',
            'updated_at',
            'deleted_at'
        ]);
    }
}
