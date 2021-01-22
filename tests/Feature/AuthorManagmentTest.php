<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class AuthorManagmentTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function an_author_can_be_created()
    {

        $response = $this->json('post', '/authors', [
            'name' => 'Victor Hugo',
            'birthDate' => '01.01.1840',
        ]);
        $author = Author::first();
        // $response->assertStatus(302);
        $this->assertCount(1, Author::all());
        // $response->assertRedirect($author->path());
        $this->assertInstanceOf(Carbon::class, $author->birthDate);
        $this->assertEquals('1840-01-01', $author->birthDate->format('Y-d-m'));
    }

    public function new_auther_automatically_added(){

    }
}
