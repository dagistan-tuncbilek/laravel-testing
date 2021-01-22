<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $guarded = [];


    protected $dates = ['birthDate'];


    // public function setBirthDateAttribute($birthDate){
    //     $this->attributes['birthDate'] = Carbon::parse($birthDate);
    // }


    public function path(){
        return '/authors'. '/' . $this->id;
    }
}
