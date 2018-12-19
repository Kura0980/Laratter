<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
    protected $guarded = [
        'id'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class);
    }
}
