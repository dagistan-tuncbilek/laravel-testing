<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_checked_out()
    {
        // $this->withoutExceptionHandling();
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkout($user);
        $reservation = Reservation::first();

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, $reservation->user_id);
        $this->assertEquals($book->id, $reservation->book_id);
        $this->assertEquals(now(), $reservation->checked_out_at);
    }

        /** @test */
        public function a_book_can_be_returned()
        {
            $book = Book::factory()->create();
            $user = User::factory()->create();
            $book->checkout($user);

            $book->checkin($user);
            $reservation = Reservation::first();

            $this->assertCount(1, Reservation::all());
            $this->assertEquals($user->id, $reservation->user_id);
            $this->assertEquals($book->id, $reservation->book_id);
            $this->assertEquals(now(), $reservation->checked_in_at);
        }

        /** @test */
        public function a_user_can_check_out_a_book_twice()
        {
            $book = Book::factory()->create();
            $user = User::factory()->create();
            $book->checkout($user);
            $book->checkin($user);

            $book->checkout($user);

            $reservation = Reservation::find(2);
            $this->assertCount(2, Reservation::all());
            $this->assertEquals($user->id, $reservation->user_id);
            $this->assertEquals($book->id, $reservation->book_id);
            $this->assertNull($reservation->checked_in_at);
            $this->assertEquals(now(), $reservation->checked_out_at);

            $book->checkin($user);
            $this->assertNotNull(Reservation::find(2)->checked_in_at);
        }

        /** @test */
        public function if_not_checked_out_exception_thrown()
        {
            $this->expectException(\Exception::class);
            $book = Book::factory()->create();
            $user = User::factory()->create();
            $book->checkin($user);
        }
}
