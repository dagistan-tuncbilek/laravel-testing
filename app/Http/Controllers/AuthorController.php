<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function store(){
        $author = Author::create($this->validateRequest());
        // return redirect($this->path());
    }

    private function validateRequest(){
        return request()->validate([
            'name' => 'required',
            'birthDate' => 'required',
        ]);
    }
}
