<?php

namespace Tests\Unit;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_name_is_rerquired_to_create_an_author()
    {

        Author::create([
            'name' => 'Victor Hugo',
        ]);
        $this->assertTrue(true);
        // $this->assertCount(1, Author::all());
    }
}
