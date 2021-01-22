<?php

namespace Tests\Unit;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_author_id_is_recorded()
    {
        Book::create([
            'title' => 'Cool title',
            'author_id' => 1,
        ]);

        $this->assertEquals(1, Book::first()->author_id);
    }
}
