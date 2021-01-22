<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use Illuminate\Support\Facades\Log;

class BookManagmentTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->json('post', '/books', $this->data());
        $book = Book::first();
        $response->assertStatus(302);
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_title_is_required()
    {
        $response = $this->json('post', '/books', array_merge($this->data(), ['title' => '']));
        $response->assertJsonValidationErrors(['title']);
    }

    /** @test */
    public function an_author_is_required()
    {
        $response = $this->json('post', '/books', array_merge($this->data(), ['author_id' => '']));
        $response->assertJsonValidationErrors(['author_id']);
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->json('post', '/books',  $this->data());
        $book = Book::first();
        $response = $this->json('patch', $book->path(), [
            'title' => 'New Title',
            'author_id' => 'New Author'
        ]);
        $book = Book::first();
        $this->assertEquals('New Title', $book->title);
        $this->assertEquals('New Author', Author::find($book->author_id)->name);
        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->json('post', '/books',  $this->data());
        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response = $this->json('delete', '/books' . '/' . $book->id);
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

    private function data()
    {
        return [
            'title' => 'CoolBook Title',
            'author_id' => 'Victor'
        ];
    }
}
