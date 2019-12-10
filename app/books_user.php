<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class books_user extends Model
{
    public function book(){
        return $this->hasOne('App\Book','id', 'book_id');
    }
}
