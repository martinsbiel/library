<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Book;
use App\Models\BookLoan;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookLoanTest extends TestCase
{
    use RefreshDatabase;

    public function test_loan_can_be_created()
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $user = User::factory()->create();
        $genre = Genre::factory()->create();
        $book = Book::factory()->create();

        $data = [
            'target_date' => '2023-01-25',
            'user_id' => 1,
            'book_id' => 1
        ];

        $response = $this->postJson(route('loans.store'), $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'target_date',
            'created_at',
            'updated_at'
        ]);
    }

    public function test_loans_can_be_listed()
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $user = User::factory()->create();
        $genre = Genre::factory()->create();
        $book = Book::factory()->create();
        $loan = BookLoan::factory(10)->create();

        $response = $this->getJson(route('loans.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'id',
                'target_date',
                'returned',
                'delayed',
                'book',
                'user',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    public function test_book_can_be_returned()
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );

        $user = User::factory()->create();
        $genre = Genre::factory()->create();
        $book = Book::factory()->create();
        $loan = BookLoan::factory()->create();

        $response = $this->patchJson(route('loans.set-returned', ['id' => $loan->id]));
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'success'
        ]);
    }

    public function test_loan_can_be_set_delayed()
    {
        Sanctum::actingAs(
            Admin::factory()->create(),
            ['*']
        );
        
        $user = User::factory()->create();
        $genre = Genre::factory()->create();
        $book = Book::factory()->create();
        $loan = BookLoan::factory()->create();

        $response = $this->patchJson(route('loans.set-delayed', ['id' => $loan->id]));
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'success'
        ]);
    }
}
