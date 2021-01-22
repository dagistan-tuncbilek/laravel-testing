<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function checkout($user)
    {
        Reservation::create([
            'user_id' => $user->id,
            'book_id' => $this->id,
            'checked_out_at' => now(),
        ]);
    }

    public function checkin($user)
    {
        $reservation = Reservation::where('user_id', $user->id)
            ->whereNotNull('checked_out_at')
            ->whereNull('checked_in_at')
            ->first();

        if (is_null($reservation)) throw new Exception('Book in not checken out');

        $reservation->update([
            'checked_in_at' => now()
        ]);
        // dd($reservation);
    }

    public function path()
    {
        return '/books' . '/' . $this->id;
    }

    public function setAuthorIdAttribute($author)
    {
        $author = Author::firstOrCreate([
            'name' => $author,
        ]);
        $this->attributes['author_id'] = $author->id;
    }
}
