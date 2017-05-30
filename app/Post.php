<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
    /*Many to OutOfBoundsException
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
