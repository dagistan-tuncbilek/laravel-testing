<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

class BookReservationTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_library()
    {

        $this->withoutExceptionHandling();

        $response = $this->json('POST', '/books', [
            'title' => 'CoolBook Title',
            'author' => 'Victor'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function a_title_is_required(){

        // $this->withoutExceptionHandling();

        $response = $this->json('POST', '/books', [
            'title' => '',
            'author' => 'Victor'
        ]);

        $response->assertJsonValidationErrors(['title']);
    }

    /** @test */
    public function a_book_can_be_updated(){
        $this->withoutExceptionHandling();
        $this->json('POST', '/books', [
            'title' => 'CoolBook Title',
            'author' => 'Victor'
        ]);
        $book = Book::first();
        $this->json('PATCH', '/books'.'/'.$book->id, [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);
        $book = Book::first();
        $this->assertEquals('New Title', $book->title);
        $this->assertEquals('New Author', $book->author);
    }

}
